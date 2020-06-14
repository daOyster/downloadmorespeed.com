<?php
    function db_connect($server, $user, $pass){
        $conn = null;
        try {
            $conn = new PDO("mysql:host=$server;dbname=dlmsdb", $user, $pass);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
            return $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
    }
    
    function db_close(){
        $conn = null;
    }

    function db_select($conn, $sql, $vals,$multi){
        $stmt = $conn->prepare($sql);
        $stmt->execute($vals);
        if($multi)
            $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        else    
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    }
?>