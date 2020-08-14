<?php
	require_once('inc/db.inc.php');

	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	
	$devMode = 0;
	if($_SERVER['HTTP_HOST'] == '127.0.0.1')
		$devMode = 1;

	$servername = "127.0.0.1";
	$username = "dlmsdev";
	$password = "dev1234";

	if($devMode == 0){
		$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/../env.ini');
		$servername = $config['server'];
		$username = $config['username'];
		$password = $config['password'];
	}

	$conn = db_connect($servername, $username, $password);
	
	$userIP = $_SERVER['REMOTE_ADDR'];
	$prev_conn = db_select($conn, 'SELECT * FROM connections WHERE IP_ADDRESS = ?',[$userIP],1);
	if(!empty($prev_conn)){
        db_select($conn, 'UPDATE connections SET Last_Connect = NOW(), Visits = ? WHERE ID = ?',[($prev_conn['Visits']+1),$prev_conn['ID']],2);
    }else{
		$newID = db_select($conn, 'INSERT INTO connections (IP_ADDRESS, Visits) VALUES (?,?)',[$userIP,1],1);
    }

    $totalVistsDb = db_select($conn, 'SELECT COUNT(*) AS Total, SUM(Visits) AS TotalVisits FROM connections',[],1);
    $totalVisits = $totalVistsDb['Total'];
    $totalVisitsSum = $totalVistsDb['TotalVisits'];
?>
<html prefix="og: https://ogp.me/ns#">
    <head>
        <script src="https://kit.fontawesome.com/2979d6c829.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/style.css"/>
        <link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet'>
        <title>Download More Speed</title>
        <meta property="og:title" content="Download More Speed Now" />
        <meta property="og:description" content="Yes you can download faster internet speeds on this totally legit website. It's not a prank, you can be sure of that!" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://www.downloadmorespeed.com/" />
        <meta property="og:image" content="https://www.downloadmorespeed.com/img/dmssquarelogo.jpg"/>
    </head>
    <body>
        <script data-ad-client="ca-pub-7569282496002679" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            function btnClicked(){
                console.log("Btn clicked");
                let gottemImg = document.getElementById("gottem-image");
                let gottemTxt = document.getElementById("gottem-text");
                let gottemBtn = document.getElementById("gottem-button");
                let gottemHdr = document.getElementById("gottem-header");
                gottemImg.src = "https://media.giphy.com/media/55SfA4BxofRBe/giphy.gif";
                gottemHdr.innerHTML = "Gotcha!";
                gottemTxt.innerHTML = "<?= $totalVisits ?> people including you have been tricked by daOyster, you can't download faster internet silly!";
                gottemBtn.disabled = true;
                //alert("You've been tricked by daOyster!");
            }
        </script>
        <?php include('header.php'); ?>
        <div style="background-image:url('img/backgroundRepeat_medium.png'); background-repeat:repeat; background-color:#152517;">
            <p id="gottem-header" class="impact-xl" style="margin-top:0; padding-top:100px; margin-bottom:0;  font-size:36px; background-image:url('img/backgroundRepeat_medium.png'); background-repeat:repeat; text-align:center;">
                <span class="gottem-text" style="margin-left:auto; padding:100; margin-right:auto; text-align:center">Download more speed and save time in your life!</span><br>
                <button id="gottem-button" class="button button-green" onclick="btnClicked()">Download More Speed!</button>
            </p>
        </div>    
        <div class="as-seen-on-container" style="margin-top:0px; padding-left:80px; padding-right:80px">
            <div >
                <p class="" style="margin-top:0px">As seen on: </p><br>
                <div style="display:flex; flex-direction:horizontal" >
                    <div style="display:inline">
                        <i class="fas fa-air-freshener" style="font-size:48px; margin:20px;"></i>
                        <p style="font-size:18px;">Green Tree Stuff</p>
                    </div>
                    <div style="display:block">
                        <i class="fab fa-fly" style="font-size:48px; margin:20px;"></i>
                        <p style="font-size:18px;">Up High</p>
                    </div>
                    <div style="display:block">
                        <i class="fas fa-tachometer-alt" style="font-size:48px; margin:20px;"></i>
                        <p style="font-size:18px;">Moe Speed</p>
                    </div>
                    <div style="display:block">
                        <i class="fas fa-tape" style="font-size:48px; margin:20px;"></i>
                        <p style="font-size:18px;">Roll Out</p>
                    </div>
                    <div style="display:block">
                        <i class="fas fa-kiwi-bird" style="font-size:48px; margin:20px;"></i>
                        <p style="font-size:18px;">Early Bird</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content">
            <img id="gottem-image" src="https://media.giphy.com/media/6JB4v4xPTAQFi/giphy.gif"/>
            <h2><p id="gottem-text"> Yes, this is totally legit! Please click the button below.</p></h2>
            <button id="gottem-button" class="button button-green" onclick="btnClicked()">Download More Speed</button>
        </div>
        <div class="footer">
            <h4><?= $totalVisitsSum ?> People have visited this site.</h4>
            <h4>This website was created as a fun joke and to prevent any potential bad actors from getting control of the domain.</h4>
            <h4>Nothing is actually downloaded and the website is completely safe, please share the <a href="https://www.downloadmorespeed.com/">link</a> and try to trick your friends!</h4>
        </div>
    </body>
</html>