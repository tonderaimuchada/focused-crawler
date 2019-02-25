<?php
    $start = 'http://technoextreme.co.zw/';
    
    function crawler($url){
        $doc = new DOMDocument();
        $doc -> loadHTML(file_get_contents($url));
        $linklist = array();
        $urlTags = array('option', 'a','h1','h2','h3','h4','h5','h6','li','ul','ol','p','div','button','frame',
        'label','img','link','nav','option','style','table','tbody','tfoot','thead','figure',
        'figcaption','picture');

        foreach ($urlTags as $tag) {
            array_push($linklist, $doc->getElementsByTagName($tag));
            // $linklist = $doc->getElementsByTagName($tag);
        }
        print_r($linklist);

        foreach ($linklist as $link) {
            try{
                if($link->length==0){
                    print_r('length now zero');
                    continue;
                } else {
                    print_r('length is not zero');
                    $l = !empty($link->getAttribute("href")) ? $link->getAttribute("href")."\n" : 'continue'; // Exception here
                    print_r($l);

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
            } catch (Exception $e){
                echo 'Message: ' .$e->getMessage();
            }
        }
    }

    crawler($start);
?>