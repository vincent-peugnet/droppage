<?php

namespace Droppage;

class Config
{
    public $uploadfolder = "";
    public $maxuploadsize = "20M";
    public $password = "";
    public $folderbysession = false;
    public $title = "";
    public $description = "";
    public $paragraph = "";
    public $debug = false;
    public $logo = "";


    public function __construct() {
        $this->readconfig();
    }

    
    public function hydrate(array $datas)
    {
        foreach ($datas as $key => $value) {
            $method = 'set' . $key;
            if (method_exists(get_called_class(), $method)) {
                $this->$method($value);
            }
        }
    }

    public function readconfig()
    {
        if (file_exists('config.json')) {
            $current = file_get_contents('config.json');
            $datas = json_decode($current, true);
            $this->hydrate($datas);
            return true;
        } else {
            return false;
        }
    }




    // ___________________ S E T ______________________

    public function setuploadfolder($uploadfolder)
    {
        if (is_string($uploadfolder)) {
            $uploadfolder = rtrim($uploadfolder, '/');
            $this->uploadfolder = $uploadfolder;
        }
    }

    public function maxuploadsize($maxuploadsize)
    {
        if (is_string($maxuploadsize)) {
            $this->maxuploadsize = $maxuploadsize;
        }
    }

    public function setpassword($password)
    {
        if (is_string($password)) {
            $this->password = $password;
        }
    }

    public function setfolderbysession($folderbysession)
    {
        $this->folderbysession = boolval($folderbysession);
    }

    public function settitle($title)
    {
        if (is_string($title)) {
            $this->title = $title;
        }
    }

    public function setdescription($description)
    {
        if (is_string($description)) {
            $this->description = $description;
        }
    }

    public function setparagraph($paragraph)
    {
        if (is_string($paragraph)) {
            $this->paragraph = $paragraph;
        }
    }

    public function setdebug($debug)
    {
        $this->debug = boolval($debug);
    }

    public function setlogo($logo)
    {
        if (is_string($logo)) {
            $this->logo = $logo;
        }
    }
}



?>