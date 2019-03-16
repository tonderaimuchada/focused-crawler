<?php
    $start = 'http://technoextreme.co.zw/';
    
    function crawler($url){
        define('ROOTPATH', __DIR__);
        $dir = ROOTPATH.'/SW';
        $searchValue = 'test';

        // if (is_dir(ROOTPATH.'/SW')){
        //     if ($dh = opendir($dir)){
        //         while (($file = readdir($dh)) !== false){
        //             if($file != '.' &&  $file != '..'){
        //                 if (!is_dir($file)){
        //                     echo $file;
        //                     //echo "filename:" . $file ."<br>";
        //                 }
        //             }
        //         }
        //     }
        // }

        $path = ROOTPATH.'/SW/Bands';
        $sub_folder = scandir($path);
        $num = count($sub_folder);

        $files = array();
        $htmlFiles = array();
        //$files = preg_grep('~\.(jpeg|jpg|png)$~', scandir($dir_f)); // For multiple files extensions
        foreach (glob($path.".html") as $file) {
            array_push($files, $file);
            $files[] = $file;
        }
        //print_r($files);

        $allowed =  array('html');
        $filename = $path.'/1.html';
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $doc = new DOMDocument();

        if (is_dir(ROOTPATH.'/SW/Bands')){
            if ($dh = opendir(ROOTPATH.'/SW/Bands')){
                while (($file = readdir($dh)) !== false){
                    if($file != '.' &&  $file != '..' && !is_dir($file) && pathinfo($file, PATHINFO_EXTENSION) == 'html'){
                        array_push($htmlFiles, searchText($file, $searchValue)->$file);
                        // $doc -> loadHTML(file_get_contents($file));// exceptions here
                        $title = $doc->getElementsByTagName("title");// Search on titles
                        //echo "filename:" . $file ."<br>";
                    }
                }
            }
        }

        // $html = get(url.host, url.page); // Search text on files


        // traverse directory contents
        // $dirs = array_filter(glob('*'), 'is_dir');
        // print_r( $dirs);




        if(!in_array($ext,$allowed) ) {
            echo 'error';
        } else {
            echo 'success';
        }

        // for ($i = 2; $i < $num; $i++)
        // {
        //     if(is_dir($path.'/'.$sub_folder[$i])){
        //         searchDirectory($path.'/'.$sub_folder[$i]);
        //     }
        // }

        // try{
        //     $doc = new DOMDocument();
        //     $doc -> loadHTML(file_get_contents($url));
        //     $linklist = $doc->getElementsByTagName("a");
        //     foreach ($linklist as $link) {
        //         $l = $link-> getAttribute("href")."\n";
        //         if(substr($l, 0, 1) == "/" && substr($l, 0, 2) != "//") {
        //             $l = parse_url($url)["scheme"]."://".parse_url($url)["host"].$l;
        //         } else if(substr($l, 0, 2) == "//") {
        //             $l = parse_url($url)["scheme"].":".$l;
        //         } else if(substr($l, 0, 2) == "./") {
        //             $l = parse_url($url)["scheme"]."://".parse_url($url)["host"].dirname(parse_url($url)["path"]).substr($l, 1);
        //         } else if(substr($l, 0, 1) == "#") {
        //             $l = parse_url($url)["scheme"]."://".parse_url($url)["host"].parse_url($url)["path"].$l;
        //         } else if(substr($l, 0, 3) == "../") {
        //             $l = parse_url($url)["scheme"]."://".parse_url($url)["host"]."/".$l;
        //         } else if(substr($l, 0, 11) == "javascript:") {
        //             continue;
        //         } else if(substr($l, 0, 5) != "https" || substr($l, 0, 4) != "http") {
        //             $l = parse_url($url)["scheme"]."://".parse_url($url)["host"].$l;
        //         }
        //         echo $l."\n";
        //     }
        // } catch(Exception $e){
        //     echo 'Message: ' .$e->getMessage();
        // }
    }
    
    class FileFound {
        public $file;
        public $count;

        public function __construct($file, $count){
            $this->$file = $file;
            $this->$count = $count;
        }
    }

    function searchText($file, $searchValue){
        $count = 0;
        return new FileFound($file, $count);
    }

    function sortList($htmlFiles){
        return $htmlFiles;
    }

    function searchDirectory($path){
        $filesList = array();
        $sub_folder = scandir($path);
        $num = count($sub_folder);
        for ($i = 2; $i < $num; $i++)
        {
            //$filesList. // add to list
            if(is_dir($path.'/'.$sub_folder[$i])){
                scandir($path.'/'.$sub_folder[$i]);
            } else {
                if($path.'/'.$sub_folder[$i].include('.html')){// check the file extension
                    echo 'HTML file';
                }
            }
        }
        // return $sub_folder list
    }

    function search(){
        $doc = new DOMDocument();
        $match = $doc->body->textContent->match("search input");
        if($match->length == 0){
            // JS search parameter 'gi' - global match
        }
    }

    $file_to_search = "abc.pdf";

    search_file('.',$file_to_search);

    function search_file($dir,$file_to_search){

        $files = scandir($dir);
        
        foreach($files as $key => $value){
        
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        
            if(!is_dir($path)) {
            
                if($file_to_search == $value){
                    echo "file found<br>";
                    echo $path;
                    break;
                }
            
            } else if($value != "." && $value != "..") {
            
                search_file($path, $file_to_search);
            
            }  
        }
    }

    function countKey($key){
        $pattern = new RegExp($key, "gi");
        $match = document.body.textContent.match(pattern);
        if($match === null){
            return 0;
        } else {
            echo $match.length;
            return $match.length;
        }
    }

    crawler($start);
?>