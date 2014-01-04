<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?

?>

<script>
    function LadeTitel()
    {
        xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("areapost").innerHTML=xmlhttp.responseText;
            }
        }
        var textarea = document.getElementById("postarea").value;
        xmlhttp.open("POST","title.php?youtubelink="+textarea,true);
        xmlhttp.send();

    }

</script>



<textarea name="text" id="postarea" onkeyup="LadeTitel()" cols='60'>
    http://www.youtube.com/watch?v=Zq_fmPxJ5cg
</textarea>
<button >vorschau</button>

<div id="areapost"></div>
<!-- document.Testformular.Eingabe.value = "Unsinn"; -->