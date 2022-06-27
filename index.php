<?php 
    include_once 'header.php';

?>
    <h1 id="index-text">Welcome, <?php if(isset($_SESSION['uuidUser'])){
        echo explode(" ", $_SESSION['username'])[0];
    }else{
        echo 'Guest';
    } 
    ?> </h1>