<?
include_once("funktionen.php");
error_reporting(0);
$url = $_GET['youtubelink'];

#ausgeben($url);

$istyoutube = strpos($url, "v=");
if($istyoutube)
{$yteiler = explode("=", $url);//zerlegt in link ban = zeichen
$vidID = substr($yteiler[1],0 ,11 ); //zweiter teil vom link -> id

$url = "http://gdata.youtube.com/feeds/api/videos/". $vidID;
$doc = new DOMDocument;
$doc->load($url);
$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
#if(!$title == 'Videos')
#$title == "";


echo $title;
}



?>
