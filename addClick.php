<?php
mysql_connect("mysqlsvr22.world4you.com", "odomainorg","v!ePm93") or die ("Keine Verbindung moeglich");
mysql_select_db("odomainorgdb23") or die ("Die Datenbank existiert nicht.");



if(isset($_GET["id"]))

{

	$text = htmlspecialchars($_GET["id"], ENT_QUOTES);

	session_start();

	$userid = $_SESSION['userid'];

	$datum = date("Y.m.d H:i:s");

	if(!$text =="")

	mysql_query("INSERT INTO linkcounter (userid, linkid, zeit) VALUES ('$userid', '$text', '$datum')");	

}
?>