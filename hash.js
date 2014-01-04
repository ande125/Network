
// 2. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
//ende

function addClick(linkid)
{
  	xmlhttp=new XMLHttpRequest();
	url = 'addClick.php?id=' + linkid;  	
	xmlhttp.open("GET", url ,true);
	xmlhttp.send();
}

function videoladen(id)
{
    var player = new YT.Player(id, {
        height: '20%',
        width: '40%',
        videoId: id
    });
}

function go(linkid, id)
{
    addClick(linkid);
    videoladen(id);
}

function videoplayerstarten(id)
{   //mit flash
     var previousInnerHTML = new String();
     previousInnerHTML = previousInnerHTML.concat("<object width='296' height='300'  data='http://www.youtube.com/v/"+id+"?version=3&loop=1&autoplay=1' type='application/x-shockwave-flash'><param name='src' value='http://www.youtube.com/v/"+id+"?version=3&loop=1' /></param></object>");
     document.getElementById('videoplayerfix').innerHTML = previousInnerHTML;
}

function goVideoplayer(linkid, id)
{
    addClick(linkid);
    videoplayerstarten(id);
}

function handleKeyPress(event)
{
	if (event.which == 13 || event.keyCode == 13)
	{
	newEntry();
	}
}
/*
function LadeChat()
{
  	xmlhttpp=new XMLHttpRequest();
	xmlhttpp.onreadystatechange=function()
 	{
  		if (xmlhttpp.readyState==4 && xmlhttpp.status==200)
    	{
    		document.getElementById("chat").innerHTML=xmlhttpp.responseText;
    	}
  	}
xmlhttpp.open("GET","chat.php",true);
xmlhttpp.send();

}

function newEntry()
{
var nachricht = document.getElementById("chattext").value;
xmlhttp=new XMLHttpRequest();

url = 'chat.php?nachricht=' + nachricht;  	
xmlhttp.open("GET", url ,true);
xmlhttp.send();

	var previousInnerHTML = new String(); 
    previousInnerHTML = previousInnerHTML.concat("<input name='chattext' id='chattext' type='text' onkeydown='handleKeyPress(event)'>");
    document.getElementById("chatfeld").innerHTML = previousInnerHTML;
    document.getElementById("chattext").focus();
}
var aktiv = window.setInterval("LadeChat()", 1500);
*/

function newEntry()
{
    var nachricht = document.getElementById("chattext").value;
    LadeTagContent(0, nachricht);
}


function LadeContent(anzahl)
{
  	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
 	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    		document.getElementById("ajaxcontent"+anzahl).innerHTML=xmlhttp.responseText;
    	}
  	}
xmlhttp.open("POST","content.php?anzahl="+anzahl,true);
xmlhttp.send();
	
	var previousInnerHTML = new String(); 
    previousInnerHTML = previousInnerHTML.concat("");
    document.getElementById("mehrContent"+anzahl).innerHTML = previousInnerHTML;


}

function LadeZufallsContent(anzahl)
{
	document.getElementById("laden").innerHTML="<img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/>";
	
  	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
 	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    		document.getElementById("ajaxcontent"+anzahl).innerHTML=xmlhttp.responseText;
				document.getElementById("laden").innerHTML="";
    	}
  	}
xmlhttp.open("POST","content.php?random=0&anzahl="+anzahl,true);
xmlhttp.send();
	
	var previousInnerHTML = new String(); 
    previousInnerHTML = previousInnerHTML.concat("");
    document.getElementById("mehrContent"+anzahl).innerHTML = previousInnerHTML;
}

function LadeTopContent(anzahl)
{
    document.getElementById("laden").innerHTML="<img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/>";

    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("ajaxcontent"+anzahl).innerHTML=xmlhttp.responseText;
            document.getElementById("laden").innerHTML="";
        }
    }
    xmlhttp.open("POST","content.php?top=0&anzahl="+anzahl,true);
    xmlhttp.send();

    var previousInnerHTML = new String();
    previousInnerHTML = previousInnerHTML.concat("");
    document.getElementById("mehrContent"+anzahl).innerHTML = previousInnerHTML;
}

function LadeLastContent(anzahl)
{
    document.getElementById("laden").innerHTML="<img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/>";

    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("ajaxcontent"+anzahl).innerHTML=xmlhttp.responseText;
            document.getElementById("laden").innerHTML="";
        }
    }
    xmlhttp.open("POST","content.php?last=0&anzahl="+anzahl,true);
    xmlhttp.send();

    var previousInnerHTML = new String();
    previousInnerHTML = previousInnerHTML.concat("");
    document.getElementById("mehrContent"+anzahl).innerHTML = previousInnerHTML;
}

function LadeTagContent(anzahl, tag)
{
    document.getElementById("laden").innerHTML="<img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/>";

    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("ajaxcontent"+anzahl).innerHTML=xmlhttp.responseText;
            document.getElementById("laden").innerHTML="";
        }
    }
    xmlhttp.open("POST","content.php?tag="+tag+"&anzahl="+anzahl,true);
    xmlhttp.send();

    var previousInnerHTML = new String();
    previousInnerHTML = previousInnerHTML.concat("");
    document.getElementById("mehrContent"+anzahl).innerHTML = previousInnerHTML;

}

function LadeUserContent(anzahl, user)
{
	document.getElementById("laden").innerHTML="<img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/><img src='76.GIF'/>";
	
  	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
 	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    		document.getElementById("ajaxcontent"+anzahl).innerHTML=xmlhttp.responseText;
			document.getElementById("laden").innerHTML="";
    	}
  	}
xmlhttp.open("POST","content.php?user="+user+"&anzahl="+anzahl,true);
xmlhttp.send();
	
	var previousInnerHTML = new String(); 
    previousInnerHTML = previousInnerHTML.concat("");
    document.getElementById("mehrContent"+anzahl).innerHTML = previousInnerHTML;
}

function LadeTitel()
{
    LadeVorschau();

    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {

           // document.getElementById("areapost").innerHTML=xmlhttp.responseText;
            document.getElementById("youtubetitel").value=xmlhttp.responseText;

        }
    }
    var textarea = document.getElementById("postarea").value;
    xmlhttp.open("POST","title.php?youtubelink="+textarea,true);
    xmlhttp.send();


}

function LadeOnlineUser()
{

    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("useronline").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("POST","online.php",true);
    xmlhttp.send();
}

var Userladen = window.setInterval("LadeOnlineUser()", 240000);


function LadeVorschau()
{

    xmlhttpp=new XMLHttpRequest();
    xmlhttpp.onreadystatechange=function()
    {
        if (xmlhttpp.readyState==4 && xmlhttpp.status==200)
        {
            document.getElementById("preview").innerHTML=xmlhttpp.responseText;
        }
    }

    var textarea = document.getElementById("postarea").value;

    xmlhttpp.open("GET","ajax/preview.php?youtubelink="+ encodeURIComponent(textarea),true);
    xmlhttpp.send();

}