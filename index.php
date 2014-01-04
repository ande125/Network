<?php
mysql_connect("mysqlsvr22.world4you.com", "odomainorg","v!ePm93") or die ("Keine Verbindung moeglich");
mysql_select_db("odomainorgdb23") or die ("Die Datenbank existiert nicht.");
session_start();

function doAutoLogin(){
    if(isset($_COOKIE["rememberMe"]))
    {


        $sql="SELECT * FROM user";
        $result=mysql_query($sql);
        $row = mysql_fetch_assoc($result);

        while($row)
        {
            if($_COOKIE["rememberMe"] == $row["passwort"].md5($row["id"]))
            {

               $_SESSION['userid']= $row["id"]; //speichert die ID in die Session userid
                $_SESSION['myusername']= $row["name"];

               header("location:hashtag.php");
               exit();
            }
            $row = mysql_fetch_assoc($result);
        }
    }

}

doAutoLogin();

?>

<html>
	<head>
		<title>Network - OISRAM</title>
		<link rel="stylesheet" type="text/css" href="css/login.css">
	</head>
	<body>
		<div id="gesammt">
			<h1>Login</h1>
			<table id="tabelle">
				<form name="form1" method="post" action="index.php">
					<tr><td>user:</td><td><input name="myusername" type="text" id="myusername"></td></tr>
					<tr><td>pw:</td><td><input name="mypassword" type="password" id="mypassword"></td></tr>
					<tr><td>merken?</td><td><input type="checkbox" name="rememberMe" value="1"></td></tr>
					<tr><td></td><td><input type="submit" name="Submit" value="Login"></td></tr>
				</form>
			</table>
		</div>
	</body>
</html>

<?php


 //kein cookie vorhanden

    // username and password sent from form
    $rememberMe=$_POST['rememberMe'];
    $mypassword=$_POST['mypassword'];
    $myusername=$_POST['myusername'];
    $mypassword = (md5($mypassword));

    if(!empty($myusername) && !empty($mypassword))
    {
    $sql="SELECT * FROM user WHERE name='$myusername' and passwort='$mypassword'";
    $result=mysql_query($sql);
    $count = mysql_num_rows($result);// Zeilen zählen

    //User mit dem PW gefunden = $count = 1
    if($count==1)
    {
            //Lest die ID des eingeloggten Users aus!
            $idauslesen = "SELECT id FROM user WHERE name='$myusername'";
            $bab =mysql_query($idauslesen);
            $row = mysql_fetch_assoc($bab);

            while ($row)
            {
                $userid =$row["id"];
                $row = mysql_fetch_assoc($bab);
            }

            $_SESSION['userid']= $userid; //speichert die ID in die Session userid
            $_SESSION['myusername']= $myusername;

            //Speichert das Aktuelle Datum + Zeit in die User Tabelle
            $datum = date("Y.m.d H:i:s");
            mysql_query("UPDATE user SET lastlogin = '".$datum."' WHERE id=".$userid."");

            if($rememberMe == 1)
            {
                $expire = time() + 3600 * 24 * 60; //Verfalldatum in 60 Tagen
                $usercookie = $mypassword.md5($userid);
               setcookie("rememberMe", $usercookie, $expire);
            }


            header("location:hashtag.php");
            exit();
    }
    else
    {
        echo "Falscher Username oder Passwort";
    }
    }

?>