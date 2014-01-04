<?php
mysql_connect("mysqlsvr22.world4you.com", "odomainorg","v!ePm93") or die ("Keine Verbindung moeglich");
mysql_select_db("odomainorgdb23") or die ("Die Datenbank existiert nicht.");

if(isset($_GET["nachricht"]))
{
	$text = htmlspecialchars($_GET["nachricht"], ENT_QUOTES);
	
	session_start();
	$userid = $_SESSION['userid'];
	$datum = date("Y.m.d H:i:s");
	if(!$text =="")
	mysql_query("INSERT INTO chat (userid, text, zeit) VALUES ('$userid', '$text', '$datum')");	
}
else {
	$sql ="SELECT * FROM chat, user  WHERE chat.userid = user.id ORDER BY zeit DESC  LIMIT 9";
	$result= mysql_query($sql);
	while ($row = mysql_fetch_array($result)) 
	{
		echo '<div id="chateintrag">';
		echo '	<div id="name">';
		echo $row["name"], ":</div> <div id='text'>", $row["text"], " </div>"; #, date("H:i",strtotime($row["zeit"]));
		echo"</div>";
	}
}


?>