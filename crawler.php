<?php
	$searchValue = 'test';

	define('ROOTPATH', __DIR__);
	$inTags = true;
	$dir = ROOTPATH.'/SW';
	$htmlFiles = array();
	include 'reasoner.php';
	$urlList = [];

    foreach (readFileSubDir($dir) as $fileItem) {
		if($myfile = @fopen($fileItem, 'r+')){
			while (($buffer = fgets($myfile)) !== false) {
				if (strpos($buffer, $searchValue) !== false) {
					//echo("File name: ".$fileItem);

					array_push($urlList, $fileItem);
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
					// echo($buffer);
					// echo(strpos($buffer, $searchValue)."\n");
					
					// if($new){
					// 	fwrite($txtFile,"1|".$fileItem);
					// } else {
					// 	// Update the rating
					// 	$rating = substr($contents, 0, strpos($contents, '|'));
					// 	$rating++;
					// 	echo($rating);
					// }
					
					// echo($fileItem."\n")."\n";
					break;
				}
			}
			fclose($myfile);
		}
	}

	$rankingsFile = "rankings.txt";

	if($txtFile = @fopen($rankingsFile, 'r+')){
		//$txtFile = @fopen($rankingsFile, "r+") or die("Unable to open file!");
		// $contents = fread($txtFile,filesize($rankingsFile));
		// echo($txtBuffer = fgets($txtFile));
		
		foreach($urlList as $fileItem){
			$result = '';
			while (($txtBuffer = fgets($txtFile)) !== false) {
				// echo($fileItem);				
				$rating = substr($txtBuffer, 0, strpos($txtBuffer, '|'));
				// Errors below: Increments not exceeding 2 and not updating the original values
				// if (strpos($txtBuffer, $fileItem) !== false || strpos($txtBuffer, "file://".$fileItem) !== false) {
					// Update here
					$rating++;
					// echo(str_replace(substr($txtBuffer, 0, strpos($txtBuffer, '|')), $rating, 1));
					$result .= str_replace(substr($txtBuffer, 0, strpos($txtBuffer, '|')), $rating, 1);
					$txtBuffer = str_replace(substr($txtBuffer, 0, strpos($txtBuffer, '|')), $rating, 1);
					// fwrite($txtFile,$rating."|".$fileItem."\n");
				// }
				// else {
				// 	// fwrite($txtFile, "1|".$fileItem."\n");
				// 	echo("Else"."1|".$fileItem."\n");
				// 	$result .= "1|".$fileItem."\n";
				// }
			}
			file_put_contents($rankingsFile, "");
			file_put_contents($rankingsFile, $result);
		}
	}
	// fclose($rankingsFile);
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