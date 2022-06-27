<?php
include_once 'header.php';
include_once './helpers/session_helper.php';
?>

<h1 class="header">Please Signup</h1>

<?php flash('register') ?>

<form method="post" action="./controllers/Users.php">
    <input type="hidden" name="type" value="register">
    <input type="text" name="username" placeholder="username">
    <input type="password" name="pwd" placeholder="password">
    <input type="password" name="pwdRepeat" placeholder="repeat password">
    <button type="submit" name="submit">Sign Up</button>
</form>
