<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="../css/index.css">
	</head>
	<body>
		<div id="alles">
			<div id="profil">
				<h1>Valentin Dorfer</h1>
			</div>
			
			<div id="home">HOME <img height="45" width="45" src="../img/home.png"></div>
			<div id="tags">TAG <img height="45" width="45" src="../img/raute.png"> </div>
			<div id="extras">EXTRA <img height="45" width="45" src="../img/star.png"> </div>
			
			<div id="context">
			<!DOCTYPE html>
<body align="center">
<?php
mysql_connect("mysqlsvr22.world4you.com", "odomainorg","v!ePm93") or die ("Keine Verbindung moeglich");
mysql_select_db("odomainorgdb23") or die ("Die Datenbank existiert nicht.");
session_start();
$userid = $_SESSION['userid'];
#if(!isset($_SESSION['userid'])){header("Location:index.php");}
include("online.php");
echo"<hr>";
if(isset($_GET["tag"]) || isset($_GET["user"]))
{
	echo"<a href='hashtag.php'>zur&uuml;ck</a><br>";	
}
if(isset($_POST["text"]))
{
	$text =$_POST["text"]." "; $datum = date("Y.m.d H:i:s");
	mysql_query("INSERT INTO post (userid, text, iwas, zeit) VALUES ('$userid', '$text','1', '$datum')");
}
//Profil:
$sql ="SELECT * FROM user WHERE id = $userid LIMIT 1";
$result= mysql_query($sql);
$row = mysql_fetch_array($result);	
echo "hi $row[name]";
echo "<br/>";

//Status Form
echo"Schreib an Status:";
echo'<form action="hashtag.php" method="post">';
echo "<textarea name='text'cols='60'></textarea>";
echo '<input type="submit" value="eintragen" />
</form>';
echo"<hr>";
//funktonen anfang
function isImage( $url ){
  $pos = strrpos( $url, ".");
    if ($pos === false)
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
function findUrl($u){
  $url = $u[0];
  $afterUrl = ''; // Zeichenkette am Ende der URL, die nicht zur URL gehört
  while(preg_match('#[[:punct:]]$#', $url, $found)){
    $chr = $found[0]; // letztes Zeichen
    if($chr==='.' || $chr===',' || $chr==='!' || $chr==='?' || $chr===':' || $chr===';' || $chr==='>' || $chr==='<'){
      // Ein Satzzeichen, das nicht zur URL gehört
      $afterUrl = $chr.$afterUrl;
      $url = substr($url, 0, -1);
    }
    elseif($chr===')' && strpos($url, '(')!==false || $chr===']' && strpos($url, '[')!==false || $chr==='}' && strpos($url, '{')!==false)
      break; // Klammer gehört nur zur URL, wenn auch öffnende Klammer vorkommt.
    elseif($chr===')' || $chr===']' || $chr==='}'){
      // .. Klammer gehört nicht zur URL
      $afterUrl = $chr.$afterUrl;
      $url = substr($url, 0, -1);
    }
    elseif($chr==='(' || $chr==='[' || $chr==='{'){
      // öffnende Klammer am Ende gehört nicht zur URL
      $afterUrl = $chr.$afterUrl;
      $url = substr($url, 0, -1);
    }
    else
      break; // Zeichen gehört zur URL
  }
  // URL mit HTML-Code zurückgeben
  if(!isImage($url))
  {
  return '<a href="'.$url.'" title="'.str_replace('http://', '', $url).'" target="_blank">'.$url.'</a>'.$afterUrl;
  }
  else {
      return'<a href="'.$url.'" title="'.str_replace('http://', '', $url).'"  target="_blank"><img src="'.$url.'" width="10%" height="10%"/></a>';
  }
}
function ausgeben($string)
{
$string = preg_replace("/#([A-Za-z0-9_]+)(?= )/", "<a href='hashtag.php?tag=$1'>$0</a>", $string);
$string = preg_replace("/@([A-Za-z0-9_]+)(?= )/", "<a href='hashtag.php?user=$1'>$0</a>", $string);
$result =  preg_replace_callback('#https?://[^/\s]{4,}(/[^\s]*)?#s', 'findUrl', $string);
echo $result;
}
//funtktion ende


// Schleifenausgabe
if(isset($_GET["tag"]))
{
	$sql = "SELECT * FROM post WHERE `text` LIKE '%".$_GET[tag]."%' ORDER BY zeit DESC";
}
else if(isset($_GET["user"]))
{
	$sql3 ="SELECT * FROM user WHERE name ='$_GET[user]' LIMIT 1";
	$result3= mysql_query($sql3);
	$row3 = mysql_fetch_array($result3);	
	$poserid = $row3[id];
	$sql = "SELECT * FROM post WHERE userid ='$poserid' ORDER BY zeit DESC";
}
else 
{
	if(isset($_GET["anzahl"]))
	{
		$anzahleinträge += $_GET["anzahl"];
	}
	else
		{
			$anzahleinträge = 10;	
		}
	
	$sql = "SELECT * FROM post ORDER BY zeit DESC LIMIT $anzahleinträge";
	#SELECT * FROM post, freunde WHERE 1= freunde.benutzerid AND (post.userid = freunde.freundid or post.userid = freunde.benutzerid)
	#$userid = 1;
	#$sql = "SELECT * FROM post, freunde WHERE '$userid'= freunde.benutzerid AND (post.userid = freunde.freundid or post.userid = freunde.benutzerid) ORDER BY zeit DESC LIMIT $anzahleinträge";
}
		$result= mysql_query($sql);
		while ($row = mysql_fetch_array($result)) 
		{
			//name
			$sql2 ="SELECT * FROM user WHERE id = $row[userid] LIMIT 1";
			$result2= mysql_query($sql2);
			$row2 = mysql_fetch_array($result2);	
			echo "<b><a href='hashtag.php?user=$row2[name]'>$row2[name]:</a></b><br>";
			//post selber
			 ausgeben($row['text']); echo " <br>$row[zeit]";
			 #echo "<br><input type='text' size='20'/> <input type='submit' value='kommentiern'>";
			 echo "<br>";
			 echo"<br/>";
		}
		$add = $anzahleinträge+10;
		if(mysql_num_rows($result)>=$anzahleinträge && mysql_num_rows($result) > 9)
		echo "<a href='hashtag.php?anzahl=$add'>mehr anzeigen </a><br><br>";
		
		
echo "<a href='logout.php'>logout </a>";
?>
</body>
	
			</div>
			
			
			<div id="online">
				<h1>ONLINE</h1><hr>
				<ul>
					<li>Valentin Dorfer</li>
					<li>Andreas Drexler</li>
					<li>Andreas Kehrer</li>
				</ul>
			</div>
			
			<div id="extern">	
					<div class="icon"><img height="30" width="30" src="../img/facebook.png"></div>
					<div class="icon"><img height="30" width="30" src="../img/youtube.png"></div>
					<div class="icon"><img height="30" width="30" src="../img/twitter.png"></div>
					<div class="icon"><img height="30" width="30" src="../img/google.png"></div>
					<div class="icon"><img height="30" width="30" src="../img/kinoto.png"></div>
			</div>
			
		</div>
	</body>
</html>