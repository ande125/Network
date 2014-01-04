<html>
<head>
<script src="hash.js" type="text/javascript">
</script>
<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
	<div id="sidebar">
		<div id="ue">
		CHAT
		</div>
		<div id="verlauf">	
			<div id="test" onclick="showHint()" >Lade Chat....</div>			
		</div>
		<input name="chattext" id="chattext" type ="text" onkeydown="handleKeyPress(event)" onfocus="this.value=''" onblur="this.value=''">
	</div>	
<?php
mysql_connect("mysqlsvr22.world4you.com", "odomainorg","v!ePm93") or die ("Keine Verbindung moeglich");
mysql_select_db("odomainorgdb23") or die ("Die Datenbank existiert nicht.");
session_start();
$userid = $_SESSION['userid'];
#if(!isset($_SESSION['userid'])){header("Location:index.php");}
include("online.php");

 echo'	<div id="menu">
			<ul>
				<li><a href="hashtag.php">home</a></li>
				<li><a href="series.php">series</a></li>
				<li><a href="hashtag.php?random">random</a></li>
				<li><a href="hashtag.php?top">top</a></li>
			</ul>
		</div>';
echo'<div id="content">';

mysql_connect("mysqlsvr22.world4you.com", "odomainorg","v!ePm93") or die ("Keine Verbindung moeglich");
mysql_select_db("odomainorgdb23") or die ("Die Datenbank existiert nicht.");

session_start();
$userid = $_SESSION['userid'];


	if(isset($_GET["addstaffel"]))
	{
		mysql_query("Update series SET staffel=$_GET[addstaffel] WHERE id=$_GET[id]");
	}
	else if(isset($_GET["minstaffel"]))
	{
		mysql_query("Update series SET staffel=$_GET[minstaffel] WHERE id=$_GET[id]");
	}
	else if(isset($_GET["minepisode"]))
	{
		mysql_query("Update series SET episode=$_GET[minepisode] WHERE id=$_GET[id]");
	}
	else if(isset($_GET["addepisode"]))
	{
		mysql_query("Update series SET episode=$_GET[addepisode] WHERE id=$_GET[id]");
	}
	else if($_GET["delete"])
	{
			mysql_query("DELETE FROM series WHERE id='$_GET[delete]' AND userid=$userid");		
	}
	
	if(isset($_POST["serie"]))
	{
		mysql_query("INSERT INTO series (serie, userid) VALUES ('$_POST[serie]', $userid)");
	}
	

	$sql ="SELECT * FROM series WHERE userid='$userid'";
	$result= mysql_query($sql);
	
	echo'<table id="serien"><tr><th>Serie</th><th>Staffel</th><th>Episode</th></tr>';
	
	while ($row = mysql_fetch_array($result)) 
	{
		$addstaffel = $row[staffel]+1;
		$minstaffel = $row[staffel]-1;
		$addepisode = $row[episode]+1;
		$minepisode = $row[episode]+-1;
		echo'<tr>
		<td class="sname"><a href="series.php?delete='.$row["id"].'">X</a> '.$row["serie"].' </td>
		<td class="szahl">
		<a href="series.php?addstaffel='.$addstaffel.'&id='.$row["id"].'"> + </a>'.$row["staffel"].' 
		<a href="series.php?minstaffel='.$minstaffel.'&id='.$row["id"].'"> - </a>
		</td>
		<td class="szahl"> 
		<a href="series.php?minepisode='.$minepisode.'&id='.$row["id"].'"> - </a> '.$row["episode"].' 
		<a href="series.php?addepisode='.$addepisode.'&id='.$row["id"].'"> + </a>
		</td>
		</tr>';	
	}
	
	echo '</table>';

	
		if(isset($_GET["add"]))
		{
			echo'<form action="series.php" method="POST">
			<input type="text" name="serie">
			<input type="submit" value="hinzuf&uuml;gen">
			</form>';
		}
		else 
		{
				echo"<a href='series.php?add'>Serie +</a>";
		}
	echo '</div>';


?>

 
