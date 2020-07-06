<?php

session_start();


echo '<a href=".">back</a></br>';

require('./vendor/autoload.php');


$conf = getconffile();

if (
    empty($conf->password)
    ||
    (
        !empty($_POST['password'])
        && $conf->password === $_POST['password']
    )
) {


    if (!is_dir($conf->uploadfolder)) {
        mkdir($conf->uploadfolder, 0777, true);
    }

    if ($conf->folderbysession) {
        
        if (!isset($_SESSION['timestamp'])) {
            $now = new DateTimeImmutable();
            $timestamp = $now->format(DATE_ISO8601);
            $_SESSION['timestamp'] = $timestamp;
        } else {
            $timestamp = $_SESSION['timestamp'];
        }

        $dir = $conf->uploadfolder . '/' . $timestamp;

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

    } else {
        $dir = $conf->uploadfolder . '/';
    }


    // Simple validation (max file size 2MB )
    $validator = new FileUpload\Validator\Simple($conf->maxuploadsize);

    // Simple path resolver, where uploads will be put
    $pathresolver = new FileUpload\PathResolver\Simple($dir);


    $filenamegenerator = new FileUpload\FileNameGenerator\Slug();

    // The machine's filesystem
    $filesystem = new FileUpload\FileSystem\Simple();

    // FileUploader itself
    $fileupload = new FileUpload\FileUpload($_FILES['files'], $_SERVER);

    // Adding it all together. Note that you can use multiple validators or none at all
    $fileupload->setPathResolver($pathresolver);
    $fileupload->setFileSystem($filesystem);
    $fileupload->addValidator($validator);
    $fileupload->setFileNameGenerator($filenamegenerator);


    // Doing the deed
    list($files, $headers) = $fileupload->processAll();

    // Outputting it, for example like this
    foreach($headers as $header => $value) {
        header($header . ': ' . $value);
    }


    $satus = [];

    foreach($files as $key => $file){
        
        $status[$key]['name'] = $file->getFilename();
        $status[$key]['size'] = readablesize($file->size) .'o';
        if ($file->completed) {
            if ($file->isFile()) {
                $status[$key]['message'] = "file uploaded successfully";
            }
        } else {
            $status[$key]['message'] = $file->error;
        }
    }


?>

<table>

    <thead>
        <tr>
            <th>name</th><th>size</th><th>status</th>
        </tr>
    </thead>
    <tbody>

        
    <?php foreach ($status as $file) { ?>
        <tr>
            <td><?= $file['name'] ?></td>
            <td><?= $file['size'] ?></td>
            <td><?= $file['message'] ?></td>
        </tr>
    <?php } ?>
        
    </tbody>

</table>


<?php

} else {
    echo '<p>wrong password</p>';
}


?>




