<?php
// ------------------------------------------------------
// dir2json - v0.1.1b
//
// by Ryan, 2015
// http://www.ryadel.com/
// ------------------------------------------------------
// Type the following for help:
//   > php dir2json -h
// ------------------------------------------------------


function dir2json($dir)
{
    $a = [];
    if($handler = opendir($dir))
    {
        while (($content = readdir($handler)) !== FALSE)
        {
            if ($content != "." && $content != ".." && $content != "Thumb.db")
            {
                if(is_file($dir."/".$content)) $a[] = $content;
				else if(is_dir($dir."/".$content)) $a[$content] = dir2json($dir."/".$content); 
            } 
        }    
        closedir($handler); 
    } 
    return $a;    
}
$argv[1]="uploadedFiles";
$argv[2]="jsonoutput.php";
$argv[3]="JSON_PRETTY_PRINT";

$argv1 = $argv[1];
$argv2 = $argv[2];
$argv3 = $argv[3];
if (empty($argv3)) $argv3 = 0;
else $argv3 = constant($argv3);

if (empty($argv2)) {
    echo "invalid arguments";
	exit;
}

$arr = dir2json($argv1);
$json = json_encode($arr, $argv3);
file_put_contents($argv2, $json);
?>
