<?php
//echo $_SERVER['REMOTE_ADDR'];
$myfile = fopen("dev.json", "w") or die("Unable to open file!");
$txt = json_encode(array(
    'remote_addr' => $_SERVER['REMOTE_ADDR']
    ));
fwrite($myfile, $txt);
/*
$txt = "Jane Doe\n";
fwrite($myfile, $txt);*/
fclose($myfile);
?>