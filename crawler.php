<?php
	$searchValue = 'test';

	define('ROOTPATH', __DIR__);
	$inTags = true;
	$dir = ROOTPATH.'/SW';
	$htmlFiles = array();

    foreach (readFileSubDir($dir) as $fileItem) {
		if($myfile = @fopen($fileItem, 'r+')){
			while (($buffer = fgets($myfile)) !== false) {
				if (strpos($buffer, $searchValue) !== false) {
					if(strpos($buffer, $searchValue) == 0){
						$inTags = false;
					} else {
						for($i = strpos($buffer, $searchValue) - 1; $i >= 0; $i--){
							if(substr($buffer, $i, 1) == '>'){
								$inTags = false;
								break;
							} else if(substr($buffer, $i, 1) == '<'){
								$inTags = true;
								break;
							} else {
								$inTags = false;
							}
						}
					}
					if($inTags == false){
						array_push($htmlFiles, $fileItem);
					}
					echo($buffer);
					echo(strpos($buffer, $searchValue)."\n");
					echo($fileItem."\n")."\n";
					break;
				}
			}
			fclose($myfile);
		}
	}
	//print_r($htmlFiles);

    function readFileSubDir($scanDir) {
    	$handle = opendir($scanDir);
    	while (($fileItem = readdir($handle)) !== false) {
    		// skip '.' and '..'
    		if (($fileItem == '.') || ($fileItem == '..')) continue;
    		$fileItem = rtrim($scanDir,'/') . '/' . $fileItem;
    		// if dir found call again recursively
    		if (is_dir($fileItem)) {
    			foreach (readFileSubDir($fileItem) as $childFileItem) {
    				yield $childFileItem;
    			}
    		} else {
    			yield $fileItem;
    		}
    	}
    	closedir($handle);
	}
?>