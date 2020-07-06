<?php

echo '<a href=".">back</a></br>';

require('./vendor/autoload.php');









// Simple validation (max file size 2MB )
$validator = new FileUpload\Validator\Simple('2M');

// Simple path resolver, where uploads will be put
$pathresolver = new FileUpload\PathResolver\Simple('test/');

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

var_dump(['files' => $files]);

foreach($files as $file){
    //Remeber to check if the upload was completed
    if ($file->completed) {
        echo $file->getRealPath();
        
        // Call any method on an SplFileInfo instance
        var_dump($file->isFile());
    }
}

?>




