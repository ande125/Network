<?php
#require_once("funktionen.php");

class Content { //mehr laden variable stimmt unten nicht...

    public $sql;
    public $anzahleinträge;
    public $mehrLaden;

    public function __construct() {
        if(isset($_GET["anzahl"]))
        {
            $this->anzahleinträge = $_GET["anzahl"];
        }
        else
        {
            $this->anzahleinträge = 0;
        }


        if(isset($_GET["random"]))
        {
            $this->setRandom();
        }
        elseif(isset($_GET["tag"]))
        {
            $this->setHastag();
        }
        elseif(isset($_GET["user"]))
        {
            $this->setUser();
        }
        elseif(isset($_GET["top"]))
        {
            $this->setTop();
        }
        elseif(isset($_GET["last"]))
        {
            $this->setLast();
        }
        elseif(isset($_GET["film"]))
        {
            $this->setMovie();
        }
        else
        {
            $this->setContent();
        }

        $this->getContent();
    }

    function setContent(){
        $this->sql = "SELECT * FROM post ORDER BY zeit DESC LIMIT $this->anzahleinträge, 10";
        $this->mehrLaden ='<p onmouseover="LadeContent('.$this->anzahleinträge.')" > ...mehr...</p>';
    }

    function setRandom(){
        $this->sql = "select * from post where text like '%youtube%' ORDER BY RAND() LIMIT $this->anzahleinträge , 10";
        $this->mehrLaden = '<p onmouseover="LadeZufallsContent('.$this->anzahleinträge.')" > ...mehr...</p>';
    }

    function setHastag(){
        $this->sql = "SELECT * FROM post WHERE `text` LIKE '%".$_GET[tag]."%' OR `titel` LIKE '%".$_GET[tag]."%' ORDER BY zeit DESC LIMIT $this->anzahleinträge, 10";
        $this->mehrLaden = '<p onmouseover="LadeTagContent('.$this->anzahleinträge.', \''.$_GET["tag"].'\')"> ...mehr...</p>';
    }

    function setMovie(){
        $this->sql = "SELECT * FROM film ORDER BY filmid DESC LIMIT $this->anzahleinträge, 10";
        $this->mehrLaden = '<p onmouseover="LadeFilmContent('.$this->anzahleinträge.', \''.$_GET["last"].'\')" > ...mehr...</p>';
    }
    function setLast(){
        $this->sql = "SELECT *  FROM linkcounter, post WHERE linkcounter.linkid = post.id ORDER BY linkcounter.zeit DESC LIMIT $this->anzahleinträge, 10";
        $this->mehrLaden = '<p onmouseover="LadeLastContent('.$this->anzahleinträge.', \''.$_GET["last"].'\')" > ...mehr...</p>';
    }
    function setUser(){
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

        $this->sql = "SELECT * FROM post WHERE `text` LIKE '%".$_GET[user]."%' OR userid = $id ORDER BY zeit DESC LIMIT $this->anzahleinträge, 10";
        $this->mehrLaden = '<p onmouseover="LadeUserContent('.$this->anzahleinträge.', \''.$_GET["user"].'\')" > ...mehr...</p>';
    }
    function setTop(){
        $this->sql =  "SELECT  *, COUNT(*) AS anzahl FROM linkcounter, post WHERE linkcounter.linkid = post.id  GROUP BY linkcounter.linkid ORDER BY anzahl DESC LIMIT $this->anzahleinträge, 10";
        $this->mehrLaden = '<p onmouseover="LadeTopContent('.$this->anzahleinträge.', \''.$_GET["top"].'\')" > ...mehr...</p>';
    }

    function getContent()
    {
        $result= mysql_query($this->sql);
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
        //naechster Aufruf
        $this->anzahleinträge += 10;

        //naechster AJAX Content der dann befüllt wird
        echo '<span id="ajaxcontent'.$this->anzahleinträge.'"></span>';
        //naechstes "mehr Laden"-Feld
        echo'<span id="mehrContent'.$this->anzahleinträge.'">';
        echo $this->mehrLaden;
        echo '</span>';
    }


}


?>