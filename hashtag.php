<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
<head>
	<title>Network</title>
	<script src="hash.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
<?php
mysql_connect("mysqlsvr22.world4you.com", "odomainorg","v!ePm93") or die ("Keine Verbindung moeglich");
mysql_select_db("odomainorgdb23") or die ("Die Datenbank existiert nicht.");
session_start();
$userid = $_SESSION['userid'];
if(!isset($_SESSION['userid'])){header("Location:index.php");}
require_once("funktionen.php");
echo "<div id='useronline'>";
include("online.php");
echo "</div>";
?>


<div id="sidebar">
    <div id="ue">
        SUCHE
    </div>
    <div id="verlauf">
    </div>
    <span id="chatfeld">
    <input name="chattext" id="chattext" type ="text" onkeydown="handleKeyPress(event)"">
    </span>
</div>

<!--Fixer Videoplayer rechts-->
<div id="videoplayerfix"></div>

<?php
if(isset($_POST["text"]))
{
	$text =$_POST["text"]." "; $datum = date("Y.m.d H:i:s");
	$text = htmlspecialchars($text, ENT_QUOTES);
	/*$von = array("ä","ö","ü","ß","Ä","Ö","Ü");
	$zu  = array("&auml;","&ouml;","&uuml;","&szlig;","&Auml;","&Ouml;","&Uuml;"); 
	$text = str_replace($von, $zu, $text); */
    $titel = htmlspecialchars($_POST["titel"], ENT_QUOTES);

	mysql_query("INSERT INTO post (userid, text, titel, zeit) VALUES ('$userid', '$text','$titel', '$datum')");
	
	$sqluser ="SELECT * FROM user";
	$resultuser= mysql_query($sqluser);
	$rowuser = mysql_fetch_array($resultuser);	
			
	$userliste = array();
	$zahl = 0;
	while($rowuser)
	{	
		$name = $rowuser["name"];
		$userliste[$zahl] = $name;
		$zahl++;
		$rowuser = mysql_fetch_array($resultuser);
	}

	$meinString = $text;

	foreach($userliste AS $name)
	{
		$findMich = "@".$name;
		$pos = strpos($meinString, $findMich);
		if ($pos !== false) {
		    mysql_query("UPDATE user SET mention=mention+1 WHERE name='$name'");
		}
	}
}
		



echo'	<div id="menu">
			<ul>';
			
			if($_GET)
			{
			echo '<li><a href="hashtag.php">home</a></li>';
			}
			else
			{
			 echo '<li><a href="#" onClick="LadeContent(0)">home</a></li>';
			}						
				echo'<!--<li><a href="series.php">series</a></li>-->
		        <li><a href="#" onClick="LadeLastContent(0)">Last</a></li>
				<li><a href="#" onClick="LadeZufallsContent(0)">random</a></li>
		        <li><a href="#" onClick="LadeTopContent(0)">top</a></li>
			</ul>
		</div>';

	
echo'<div id="content">';

	//Status Form
	echo'<form action="hashtag.php" method="post">';
	echo "<textarea name='text'cols='60' id='postarea' onkeyup='LadeTitel()'></textarea>";
    echo '<input type="hidden" name="titel" id="youtubetitel" />';
	echo '<input type="submit" value="eintragen" />
	</form><div id="areapost"></div><div id="preview"></div><hr>';
	echo'<span id="laden"></span>';		
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
		$sql = "SELECT * FROM post WHERE userid ='$poserid' OR `text` LIKE '%@".$_GET[user]."%' ORDER BY zeit DESC";
		
	}
	else if(isset($_GET["top"]))
	{
		$sql ="SELECT  *, COUNT(*) AS anzahl FROM linkcounter, post WHERE linkcounter.linkid = post.id  GROUP BY linkcounter.linkid ORDER BY anzahl DESC LIMIT 10";	
	}
	
	 if(isset($_GET["top"]) || isset($_GET["user"]) || isset($_GET["tag"]))
	{
			$result= mysql_query($sql);
			while ($row = mysql_fetch_array($result)) 
			{
				echo'<div id="eintrag">';
				//name
				$sql2 ="SELECT * FROM user WHERE id = $row[userid] LIMIT 1";
				$result2= mysql_query($sql2);
				$row2 = mysql_fetch_array($result2);	
				echo "<h1><a href='hashtag.php?user=$row2[name]'>$row2[name]:</h1></a>";
				//post selber
				echo '<p>';
				ausgeben($row['text']); echo " <br>", date('H:i d.m.Y',strtotime($row[zeit]));
				
				if(isset($_GET["top"]))//wenn top 10 anzeigt wern soin
				{
					echo " Clicks: <b>" ,$row["anzahl"], "</b>";
				}
				echo '</p></div>';	
				 
			}
			
			$add = $anzahleinträge+10;
			if(mysql_num_rows($result)>=$anzahleinträge && mysql_num_rows($result) > 9)
			echo "<a href='hashtag.php?anzahl=$add'>mehr anzeigen </a> | ";

			
			$sqlalleposts = "SELECT * FROM post;";
			$resultposts= mysql_query($sqlalleposts);
			echo mysql_num_rows($resultposts), " Posts |";
			
						echo "<a href='logout.php'> logout </a>";
	}
	else if(isset($_GET["random"]))
	{
		echo'<script>LadeZufallsContent(0)</script>';
echo'<span id="ajaxcontent0">';
	echo'</span>';
	}
else {
	echo'<script>LadeContent(0)</script>';
echo'<span id="ajaxcontent0">';
	echo'</span>';
}	

	
	

	
	
	
		
echo'</div>';
	
?>
</body>
