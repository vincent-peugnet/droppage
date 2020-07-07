<?php

session_start();

require_once('vendor/autoload.php');

$conf = new Droppage\Config();

var_dump($conf);

if (empty($conf->uploadfolder)) {
    echo 'upload folder not set !';
    exit;
}

?>

<h1><?= !empty($conf->title) && is_string($conf->title) ? $conf->title : 'DropPage' ?></h1>

<?= !empty($conf->description) && is_string($conf->description) ? '<p><strong>' . $conf->description .'</strong></p>' : '' ?>

<hr>

<ul>    
    <li>Max total upload size : <?= readablesize(file_upload_max_size()) ?>o</li>

    <li>Max upload size by individual file : <?= $conf->maxuploadsize ?>io</li>
</ul>






<form enctype="multipart/form-data" method="post" action="upload.php">
    <input type="file" name="files[]" multiple required>
    <?php if (!empty($conf->password)) { ?>
        </br>
        <input type="password" name="password" id="password" placeholder="password" required>
    <?php } ?>
    </br>
    <input type="submit" name="Submit" value="upload">
</form>



