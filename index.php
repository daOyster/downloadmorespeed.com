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
		$config = parse_ini_file('../env.ini');
		$servername = $config['servername'];
		$username = $config['username'];
		$password = $config['password'];
	}
	
	$conn = db_connect($servername, $username, $password);
	
	$userIP = $_SERVER['REMOTE_ADDR'];
	
	$prev_conn = db_select($conn, 'SELECT * FROM Connections WHERE IP_ADDRESS = ?',[$userIP],1);
	if(!empty($prev_conn))
		echo "<p>I've seen you before.</p>";
	else
		db_select($conn, 'INSERT INTO connections (IP_ADDRESS, Visits) VALUES (?,?)',[$userIP,1],1);
	
	header('Location: '.$uri.'/index.html');
	exit;
?>
Something is wrong with the XAMPP installation :-(
