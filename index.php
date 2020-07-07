<?php

session_start();

require_once('vendor/autoload.php');

$conf = new Droppage\Config();

if ($conf->debug) {
    highlight_string("<?php\n\$conf =\n" . var_export($conf, true));
}


// check if upload folder is defined
if (empty($conf->uploadfolder)) {
    echo 'upload folder not set !';
    exit;
}

// check if upload folder exists
if (!is_dir($conf->uploadfolder)) {
    if(!mkdir($conf->uploadfolder, 0777, true)) {
        echo 'upload directory can\'t be created';
        exit;
    }
}

if (isset($_GET['error']) && $_GET['error'] == "wrongpassword") {
    $error = "Wrong password !";
}

?>

<html>

    <head>
        <meta charset="utf-8">
        <title><?= $conf->title ?></title>
        <meta name="description" content="<?= $conf->description ?>">
        <meta name="viewport" content="width=device-width">
        <meta property="og:title" content="<?= $conf->title ?>">
        <meta property="og:description" content="<?= $conf->description ?>">
        <link href="default.css" rel="stylesheet">
        <?= file_exists('custom.css') ? '<link href="custom.css" rel="stylesheet">' : '' ?>
    </head>

    <body>

        <header>
        
        <?= !empty($conf->logo) ? '<img src="' . $conf->logo . '" alt="logo" id="logo">' : '' ?>

        <?= !empty($conf->title) ? '<h1>' . $conf->title . '</h1>' : '' ?>

        <?= !empty($conf->description) ? '<p><strong>' . $conf->description .'</strong></p>' : '' ?>

        <?= !empty($conf->paragraph) ? '<p>' . $conf->paragraph .'</p>' : '' ?>


        </header>

        <hr>

        <main>

        <ul>    
            <li>Max total upload size : <?= readablesize(file_upload_max_size()) ?>o</li>

            <li>Max upload size by individual file : <?= $conf->maxuploadsize ?>io</li>
        </ul>






        <form enctype="multipart/form-data" method="post" action="upload.php">
            <input type="file" name="files[]" multiple required>
            <?php if (!empty($conf->password)) { ?>
                </br>
                <?= !empty($error) ? $error . '</br>' : '' ?>
                <input type="password" name="password" id="password" placeholder="password" required>
            <?php } ?>
            </br>
            <input type="submit" name="Submit" value="upload">
        </form>


        </main>


    </body>


</html>