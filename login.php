<?php
include_once 'header.php';
include_once './helpers/session_helper.php';
?>
<h1 class="header">Please Login</h1>

<?php flash('login') ?>

<form method="post" action="./controllers/Users.php">
    <input type="hidden" name="type" value="login">
    <input type="text" name="username" placeholder="username...">
    <input type="password" name="pwd" placeholder="password">
    <button type="submit" name="submit">Log In</button>
</form>