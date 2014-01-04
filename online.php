<?php

mysql_connect("mysqlsvr22.world4you.com", "odomainorg","v!ePm93") or die ("Keine Verbindung moeglich");
mysql_select_db("odomainorgdb23") or die ("Die Datenbank existiert nicht.");

    //Eigene Zeit updaten
    $sql = "SELECT COUNT(*) as Anzahl FROM online WHERE IP = '".$_SERVER['REMOTE_ADDR']."'";
    $result = mysql_query($sql) OR die(mysql_error());
    $row = mysql_fetch_assoc($result);
    if($row['Anzahl']) {
        // Nur Datum Updaten
        $sql = "UPDATE
                    online
                SET
                    Datum = NOW()
                WHERE
                    IP = '".$_SERVER['REMOTE_ADDR']."'";
        mysql_query($sql) OR die(mysql_error());
    }
    else // Neuen Eintrag adden
    {
		session_start();
        if(!isset($_SESSION['myusername'])){
            #header("location:index.php");
            exit();
        }

        $username = $_SESSION['myusername'];
        $sql = "INSERT INTO online (IP, Datum, user) VALUES ('".$_SERVER['REMOTE_ADDR']."', NOW(),'".$username."')";
        mysql_query($sql) OR die(mysql_error());
    }


    // alte Datensatze loschen
    $sql = "DELETE FROM online WHERE DATE_SUB(NOW(), INTERVAL 4 MINUTE) > Datum";
    mysql_query($sql) OR die(mysql_error());

    // Anzahl Ausgeben
    $sql = "SELECT COUNT(*) as Anzahl FROM online";
    $result = mysql_query($sql) OR die(mysql_error());
    $row = mysql_fetch_assoc($result);
    echo "User online: ".$row['Anzahl']."<br />";

    //Alle online User ausgeben
	function namenlesen ()
	{
        $sql = "SELECT user FROM online";
        $result = mysql_query($sql) OR die(mysql_error());
        $row = mysql_fetch_assoc($result);
        while($row)
        {
            echo $row['user'];
            echo "<br>";
            $row = mysql_fetch_assoc($result);
        }
	}

	namenlesen();
?>