<?php

require('fn.php');

echo '<p>Max upload size : ' . readablesize(file_upload_max_size()) . 'o</p>';

$conf = json_decode(file_get_contents("config.json"));


?>




<form enctype="multipart/form-data" method="post" action="upload.php">
    <input type="file" name="files[]" multiple>
    <?php if (!empty($conf->password)) { ?>
        <input type="password" name="password" id="password" placeholder="password">
    <?php } ?>
    <input type="submit" name="Submit" value="upload">
</form>



