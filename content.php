<?php
mysql_connect("mysqlsvr22.world4you.com", "odomainorg","v!ePm93") or die ("Keine Verbindung moeglich");
mysql_select_db("odomainorgdb23") or die ("Die Datenbank existiert nicht.");
session_start();
$userid = $_SESSION['userid'];
if(!isset($_SESSION['userid'])){header("Location:index.php");}
require_once("funktionen.php");
include_once("classes/Content.php");



	// Schleifenausgabe
	if(isset($_GET["anzahl"]))
	{
		$anzahleinträge = $_GET["anzahl"]; //+= ??
	}
	else
	{
		$anzahleinträge = 0;
	}

    if(isset($_GET["random"]))
    {
        $sql = "select * from post where text like '%youtube%' ORDER BY RAND() LIMIT $anzahleinträge , 10";
    }
        elseif(isset($_GET["tag"]))
    {
        $sql = "SELECT * FROM post WHERE `text` LIKE '%".$_GET[tag]."%' OR `titel` LIKE '%".$_GET[tag]."%' ORDER BY zeit DESC LIMIT $anzahleinträge, 10";
    }
    elseif(isset($_GET["user"]))//Gibt zurzeit nur die Makierungen aus + posts selber
    {
        $sqluser ="SELECT * FROM user WHERE id ='$_SESSION[userid]' LIMIT 1";
        $resultuser= mysql_query($sqluser);
        $rowuser = mysql_fetch_array($resultuser);
        $name = $rowuser["name"];
        if($name==$_GET["user"])
        {
            mysql_query("UPDATE user SET mention=0 WHERE name='$name'");
        }

        $username = $_GET["user"];
        $sqluser ="SELECT * FROM user WHERE name ='$username' LIMIT 1";
        $resultuser= mysql_query($sqluser);
        $rowuser = mysql_fetch_array($resultuser);
        $id = $rowuser["id"];


        $sql = "SELECT * FROM post WHERE `text` LIKE '%".$_GET[user]."%' OR userid = $id ORDER BY zeit DESC LIMIT $anzahleinträge, 10";
    }
    elseif(isset($_GET["film"]))
    {
        $sql = "SELECT * FROM film ORDER BY filmid DESC LIMIT $anzahleinträge, 10";
    }
    else if(isset($_GET["top"]))
    {
        $sql ="SELECT  *, COUNT(*) AS anzahl FROM linkcounter, post WHERE linkcounter.linkid = post.id  GROUP BY linkcounter.linkid ORDER BY anzahl DESC LIMIT $anzahleinträge, 10";
    }
    else if(isset($_GET["last"]))
    {
        $sql="SELECT *  FROM linkcounter, post WHERE linkcounter.linkid = post.id ORDER BY linkcounter.zeit DESC LIMIT $anzahleinträge, 10";
        #$sql ="SELECT *  FROM linkcounter, post WHERE linkcounter.linkid = post.id  GROUP BY linkcounter.linkid ORDER BY linkcounter.zeit DESC LIMIT $anzahleinträge, 10";
    }
    else
    {
        $sql = "SELECT * FROM post ORDER BY zeit DESC LIMIT $anzahleinträge, 10";
    }


/*
 *
 * Anzeige mention
$sqluser ="SELECT * FROM user WHERE id ='$_SESSION[userid]' LIMIT 1";
$resultuser= mysql_query($sqluser);
$rowuser = mysql_fetch_array($resultuser);
$mention = $rowuser["mention"];
if($mention > 0)
echo'<span id="mention" >'.$mention.' Makierungen <span onClick="deleteMention()" style="font-size:0.6em">(ausblenden)</span></span>';
*/

    //SQL-Befehl ausführen
    $result= mysql_query($sql);
    while ($row = mysql_fetch_array($result))
    {
        echo'<div id="eintrag">';
            //name
            $sql2 ="SELECT * FROM user WHERE id = $row[userid] LIMIT 1";
            $result2= mysql_query($sql2);
            $row2 = mysql_fetch_array($result2);

            //Namen mit js-funktion ausgeben
            echo '<h1><a href="#" onclick="LadeUserContent(0,\''.$row2["name"].'\')">'.$row2[name].':</h1></a>';

            //post selber
            echo '<p>';
              $text = $row['text'];
              #  $text = nl2br($row['text']);
                ausgeben($text);
                echo " <br> ", date('H:i d.m.Y',strtotime($row[zeit]));

                if(isset($_GET["top"]))//wenn top 10 anzeigt wern soin
                {
                    echo " Clicks: <b>" ,$row["anzahl"], "</b>";
                }elseif(isset($_GET["film"]))
                {
                    echo "<br/>";
                    echo "IMDB-Raiting: ", $row["imdbrating"], "<br/>";
                    echo "<a href='" , $row["imdblink"], "' target='_blank'>IMDB-Link</a><br/>";
                    echo "Eignes Raiting:", $row["selfrating"], "<br/>";
                }
            echo '</p>';
        echo '</div>';
    }

    //nächsten 10 Einträge sollen beim nächsten mal laden, geladen werden
    $anzahleinträge += 10;

    //nächster AJAX Content der dann befüllt wird
    echo '<span id="ajaxcontent'.$anzahleinträge.'"></span>';
    //span für das laden weiteren contents
    echo'<span id="mehrContent'.$anzahleinträge.'">';
        if(isset($_GET["random"]))
        {
            echo'<p onmouseover="LadeZufallsContent('.$anzahleinträge.')" > ...mehr...</p>';
        }
        elseif(isset($_GET["tag"]))
        {
            echo'<p onmouseover="LadeTagContent('.$anzahleinträge.', \''.$_GET["tag"].'\')"> ...mehr...</p>';
        }
        elseif(isset($_GET["user"]))
        {
            echo'<p onmouseover="LadeUserContent('.$anzahleinträge.', \''.$_GET["user"].'\')" > ...mehr...</p>';
        }
        elseif(isset($_GET["top"]))
        {
            echo'<p onmouseover="LadeTopContent('.$anzahleinträge.', \''.$_GET["top"].'\')" > ...mehr...</p>';
        }
        elseif(isset($_GET["last"]))
        {
            echo'<p onmouseover="LadeLastContent('.$anzahleinträge.', \''.$_GET["last"].'\')" > ...mehr...</p>';
        }
        else
        {
            echo'<p onmouseover="LadeContent('.$anzahleinträge.')" > ...mehr...</p>';
        }
    echo '</span>';


?>