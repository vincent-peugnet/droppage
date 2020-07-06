<?php


// Returns a file size limit in bytes based on the PHP upload_max_filesize
// and post_max_size
function file_upload_max_size()
{
    static $max_size = -1;
  
    if ($max_size < 0) {
      // Start with post_max_size.
        $post_max_size = parse_size(ini_get('post_max_size'));
        if ($post_max_size > 0) {
            $max_size = $post_max_size;
        }
  
      // If upload_max_size is less, then reduce. Except if upload_max_size is
      // zero, which indicates no limit.
        $upload_max = parse_size(ini_get('upload_max_filesize'));
        if ($upload_max > 0 && $upload_max < $max_size) {
            $max_size = $upload_max;
        }
    }
    return $max_size;
}

function parse_size($size)
{
    $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
    $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
    $size = floatval($size);
    if ($unit) {
      // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
        return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
    } else {
        return round($size);
    }
}


function readablesize($bytes, $base = 2 ** 10)
{
    $format = ' %d %s';

    if ($base === 2 ** 10) {
        $i = 'i';
    } else {
        $i = '';
    }

    $unit = '';

    if ($bytes < $base) {
        $num = $bytes;
    } elseif ($bytes < $base ** 2) {
        $num = round($bytes / $base, 1);
        $unit = 'K' . $i;
    } elseif ($bytes < $base ** 3) {
        $num = round($bytes / $base ** 2, 1);
        $unit = 'M' . $i;
    } else {
        $num = round($bytes / $base ** 3, 1);
        $unit = 'G' . $i;
    }

    return sprintf($format, $num, $unit);
}

/**
 * @return Anonymous object conataining config settings
 * @throws Exception if file does not exist or json format is invalid
 */
function getconffile()
{
    if (is_file('config.json')) {
        $json = json_decode(file_get_contents("config.json"));
        if (empty($json)) {
            throw new Exception("Config file format error", 1);
        } else {
            return $json;
        }
    } else {
        throw new Exception("Can't find config file", 1);
        
    }
}


?>