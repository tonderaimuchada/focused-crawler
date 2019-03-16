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
					for($i = strpos($buffer, $searchValue) - 1; $i >= 0; $i--){ // skipping values at index 0
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
					if($inTags == false){
						array_push($htmlFiles, $fileItem);
					}
					// echo($buffer);
					// echo(strpos($buffer, $searchValue));
					// echo($fileItem."\n");
					break;
				}
			}
			fclose($myfile);
		}
	}
	print_r($htmlFiles);

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
	






	// $error = False
	// $report = False

	// with open(html_path) as html_file:
  	// 	for line in html_file:
  	// 	  print(line)
  	// 	  if 'Error' in line:
	// 		$error = True
  	// 	  if 'Report' in line:
	// 		$report = True
  	// 	  print(line)
  	// 	else:
  	// 	  if $error:
  	// 	    print('error')
  	// 	  else if $report:
  	// 	    print('result')
  	// 	  else:
  	// 	    print('nothing')
?>