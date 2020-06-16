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
        <link rel="stylesheet" href="/style.css"/>
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
        <header>
            <h2 class="nav-banner">DownloadMoreSpeed.com</h2>
            <nav class="nav-links">
                <ul>
                    <li><a href='/'>Home</a></li>
                    <li><s>Learn</s></li>
                    <li><s>Share</s></li>
                    <li><s>Leaderboard</s></li>
                </ul>
            </nav>
            <button class="nav-profile-btn">Profile</button>
        </header>
        <br>
        <div class="main-content">
            <p><h1 id="gottem-header"> Download More Speed Now! </h1></p>
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