<?php
    $start = 'http://technoextreme.co.zw/';
    
    function crawler($url){
        $doc = new DOMDocument();
        $doc -> loadHTML(file_get_contents($url));
        $linklist = $doc->getElementsByTagName("a");
        foreach ($linklist as $link) {
            $l = $link-> getAttribute("href")."\n";
            if(substr($l, 0, 1) == "/" && substr($l, 0, 2) != "//") {
                $l = parse_url($url)["scheme"]."://".parse_url($url)["host"].$l;
            } else if(substr($l, 0, 2) == "//") {
                $l = parse_url($url)["scheme"].":".$l;
            } else if(substr($l, 0, 2) == "./") {
                $l = parse_url($url)["scheme"]."://".parse_url($url)["host"].dirname(parse_url($url)["path"]).substr($l, 1);
            } else if(substr($l, 0, 1) == "#") {
                $l = parse_url($url)["scheme"]."://".parse_url($url)["host"].parse_url($url)["path"].$l;
            } else if(substr($l, 0, 3) == "../") {
                $l = parse_url($url)["scheme"]."://".parse_url($url)["host"]."/".$l;
            } else if(substr($l, 0, 11) == "javascript:") {
                continue;
            } else if(substr($l, 0, 5) != "https" || substr($l, 0, 4) != "http") {
                $l = parse_url($url)["scheme"]."://".parse_url($url)["host"].$l;
            }
            echo $l."\n";
        }
    }
    crawler($start);
?>