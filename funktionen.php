<?php

function isImage($url)
{
    $pos = strrpos( $url, ".");
    if($pos === false)
        return false;

    $ext = strtolower(trim(substr( $url, $pos)));
    $imgExts = array(".gif", ".jpg", ".jpeg", ".png", ".tiff", ".tif"); // this is far from complete but that's always going to be the case...
    if ( in_array($ext, $imgExts) )
    {
        return true;
    }
    else
    {
        return false;
    }
}

function findUrl($u)
{
    $url = $u[0];
    $afterUrl = ''; // Zeichenkette am Ende der URL, die nicht zur URL gehört
    while(preg_match('#[[:punct:]]$#', $url, $found))
    {
        $chr = $found[0]; // letztes Zeichen
        if($chr==='.' || $chr===',' || $chr==='!' || $chr==='?' || $chr===':' || $chr===';' || $chr==='>' || $chr==='<')
        {
            // Ein Satzzeichen, das nicht zur URL gehört
            $afterUrl = $chr.$afterUrl;
            $url = substr($url, 0, -1);
        }
        elseif($chr===')' && strpos($url, '(')!==false || $chr===']' && strpos($url, '[')!==false || $chr==='}' && strpos($url, '{')!==false)
            break; // Klammer gehört nur zur URL, wenn auch öffnende Klammer vorkommt.
        elseif($chr===')' || $chr===']' || $chr==='}')
        {
            // .. Klammer gehört nicht zur URL
            $afterUrl = $chr.$afterUrl;
            $url = substr($url, 0, -1);
        }
        elseif($chr==='(' || $chr==='[' || $chr==='{')
        {
            // öffnende Klammer am Ende gehört nicht zur URL
            $afterUrl = $chr.$afterUrl;
            $url = substr($url, 0, -1);
        }
        else
        break; // Zeichen gehört zur URL
    }

    // YoutubeLink oder NormalerLink
    if(!isImage($url))
    {
        $istyoutube = strpos($url, "youtube");

        //Youtube-Link
        if($istyoutube)
        {
            //lest die ID aus um clicks mitzuzählen
            $sql ="SELECT * FROM post WHERE text LIKE '%".$url."%' LIMIT 1";
            $result= mysql_query($sql);
            $row = mysql_fetch_array($result);
            $linkid = $row[id];



            ## ID vom Link trennen
            $yteiler = explode("=", $url);//zerlegt in link ban = zeichen
            $youtubeid =substr($yteiler[1],0 ,11 ); //zweiter teil vom link -> id



            ## Title von der ID
            $youtubeurl = "http://gdata.youtube.com/feeds/api/videos/". $youtubeid;
            $doc = new DOMDocument;
            $doc->load($youtubeurl);
            $title = $doc->getElementsByTagName("title")->item(0)->nodeValue;


            return '<span class="youtubetext" onclick="goVideoplayer('.$linkid.', \''.$youtubeid.'\')">'.$title.'</span><br><img id="'.$youtubeid.'" src="http://img.youtube.com/vi/'.$youtubeid.'/default.jpg" overflow:hidden width="15%" height="15%" onClick="go('.$linkid.', \''.$youtubeid.'\');"/> ';
        }
        else //normaler LInk
        {
            //lest di id aus um clicks mitzuzählen
            $sql ="SELECT * FROM post WHERE text LIKE '%".$url."%' LIMIT 1";
            $result= mysql_query($sql);
            $row = mysql_fetch_array($result);
            $linkid = $row[id];
            return '<a href="'.$url.'" target="_blank" onClick="addClick('.$linkid.')">'.$url.'</a>';   //link
        }

    }
    else //Bild wiedergeben
    {
         //lest di id aus um clicks mitzuzählen
        $sql ="SELECT * FROM post WHERE text LIKE '%".$url."%' LIMIT 1";
        $result= mysql_query($sql);
        $row = mysql_fetch_array($result);
        $linkid = $row[id];

        return'<a href="'.$url.'" title="'.str_replace('http://', '', $url).'"  target="_blank" onClick="addClick('.$linkid.')"><img src="'.$url.'" overflow:hidden width="15%" height="15%"/></a>';
    }
}

function ausgeben($string)
{
    $string = preg_replace("/#([A-Za-z0-9_]+)(?=)/", " <a href='#' onClick='LadeTagContent(0, \"$1\")'>$0</a>", $string);
    $string = preg_replace("/@([A-Za-z0-9_]+)(?=)/", " <a href='#' onClick='LadeUserContent(0, \"$1\")'>$0</a>", $string);
    $string =  preg_replace_callback('#https?://[^/\s]{4,}(/[^\s]*)?#s', 'findUrl', $string);
    $string = nl2br($string);
    echo $string;
}

?>