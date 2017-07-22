<?php
session_start ();
function loginForm() {
    echo '
    <h2>Hackers Shoutbox By AE</h2>
    <div id="loginform">
    <form action="index.php" method="post">
        <p>Please enter your name to continue:</p>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" />
        <input type="submit" name="enter" id="enter" value="Submit" />
    </form>
    </div>
    ';
}

if (isset ( $_POST ['enter'] )) {
    if ($_POST ['name'] != "") {
        $_SESSION ['name'] = stripslashes ( htmlspecialchars ( $_POST ['name'] ) );
        $fp = fopen ( "chatlog.html", 'a' );
        fwrite ( $fp, "<div class='msgln'><i>User " . $_SESSION ['name'] . " has joined the chat session.</i><br></div>" );
        fclose ( $fp );
    } else {
        echo '<span class="error">Please type in a name</span>';
    }
}

if (isset ( $_GET ['logout'] )) {
    
    // Simple exit message
    $fp = fopen ( "chatlog.html", 'a' );
    fwrite ( $fp, "<div class='msgln'><i>User " . $_SESSION ['name'] . " has left the chat session.</i><br></div>" );
    fclose ( $fp );
    
    session_destroy ();
    header ( "Location: index.php" ); // Redirect the user
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style> 
@import url('https://fonts.googleapis.com/css?family=Titillium+Web'); 
</style>
<style>
body {
    font: 15px ;
    color: #0ED095;
    text-align: center;
    padding: 35px;
    background-color:#03192A;
    font-family: 'Titillium Web', sans-serif;
}

form,p,span {
    margin: 0;
    padding: 0;
}

input {
    font: 17px arial;
}

a {
    color: #0BCBD7;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

#wrapper,#loginform {
    margin: 0 auto;
    padding-bottom: 25px;
    background: #1e2b35;
    width: 100%;
    border: 1px solid #142e3d;
}

#loginform {
    padding-top: 18px;
}

#loginform p {
    margin: 5px;
}

#chatbox {
    text-align: left;
    margin: 0 auto;
    margin-bottom: 25px;
    padding: 10px;
    background: #494949;
    height: 270px;
    width: 95%;
    border: 1px solid #0AC875;
    overflow: auto;
}

#usermsg {
    width: 80%;
    border: 1px solid #ACD8F0;
}

#submit {
    width: 60px;
}

.error {
    color: #ff0000;
}

#menu {
    padding: 12.5px 25px 12.5px 25px;
}

.welcome {
    float: left;
}

.logout {
    float: right;
}

.msgln {
    margin: 0 0 2px 0;
}
</style>
<title>Hackers Shoutbox BY AE</title>
</head>
<body>
    <?php
    if (! isset ( $_SESSION ['name'] )) {
        loginForm ();
    } else {
        ?>
    <h2>Hackers Shoutbox By AE</h2>
<div id="wrapper">
        <div id="menu">
            <p class="welcome">
                Welcome, <b><?php echo $_SESSION['name']; ?></b>
            </p>
            <p class="logout">
                <a id="exit" href="#">Log Out</a>
            </p>
            <div style="clear: both"></div>
        </div>
        <div id="chatbox"><?php
        if (file_exists ( "chatlog.html" ) && filesize ( "chatlog.html" ) > 0) {
            $handle = fopen ( "chatlog.html", "r" );
            $contents = fread ( $handle, filesize ( "chatlog.html" ) );
            fclose ( $handle );
            
            echo $contents;
        }
        ?></div>

        <form name="message" action="">
            <input name="usermsg" type="text" id="usermsg" size="63" /> <input
                name="submitmsg" type="submit" id="submitmsg" value="Send" />
        </form>
    </div>
    <script type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
// jQuery Document
$(document).ready(function(){
});

//jQuery Document
$(document).ready(function(){
    //If user wants to end session
    $("#exit").click(function(){
        var exit = confirm("Are you sure you want to end the session?");
        if(exit==true){window.location = 'index.php?logout=true';}       
    });
});

//If user submits the form
$("#submitmsg").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("post.php", {text: clientmsg});               
        $("#usermsg").attr("value", "");
        loadLog;
    return false;
});

function loadLog(){       
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
    $.ajax({
        url: "chatlog.html",
        cache: false,
        success: function(html){       
            $("#chatbox").html(html); //Insert chat log into the #chatbox div   
            
            //Auto-scroll           
            var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
            if(newscrollHeight > oldscrollHeight){
                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
            }               
          },
    });
}

setInterval (loadLog, 2500);
</script>
<?php
    }
    ?>
    <script type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
</script>
</body>
<footer>
    <br></br>
    <span class="copyright">Copyright © <a href="https://github.com/akalankauk/" target="_blank">AE Developers</a>
</footer>
</html>
