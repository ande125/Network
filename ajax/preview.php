<?php
mysql_connect("mysqlsvr22.world4you.com", "odomainorg","v!ePm93") or die ("Keine Verbindung moeglich");
mysql_select_db("odomainorgdb23") or die ("Die Datenbank existiert nicht.");

include_once("../funktionen.php");
#error_reporting(0);

$url = urldecode($_GET['youtubelink']);
#echo $url;
#$url = "http://www.youtube.com/watch?v=j5-yKhDd64s Video posten verbessert! #test Vorschau kommt vl. moang ;) ";

if($url)
{
    echo "<h3>Vorschau:</h3><p>";
    ausgeben($url);
    echo "</p>";
    }
?>