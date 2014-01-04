<?php
# nicht in verwendung!
mysql_connect("mysqlsvr22.world4you.com", "odomainorg","v!ePm93") or die ("Keine Verbindung moeglich");
mysql_select_db("odomainorgdb23") or die ("Die Datenbank existiert nicht.");
session_start();

$sqluser ="SELECT * FROM user WHERE id ='$_SESSION[userid]' LIMIT 1";
		$resultuser= mysql_query($sqluser);
		$rowuser = mysql_fetch_array($resultuser);	
		$mention = $rowuser["mention"];
		
		echo "$mention Benachrichtigungen";
?>