<?php session_start();
if(isset($_SESSION['user'])){
    if($_SESSION['role'] == 'HR Manager' || $_SESSION['role'] == 'BOSS')
       header('location: /public/manager/showEmployees/');
    else{
        header('location: /public/employee/markAttendanceForm/'.$_SESSION['emp']);
    }
}?>
<!DOCTYPE html>
<html lang="eng-us">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/views/style.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
</head>
<body>
<div class="center">
    <form method="post" action="/public/login/loginUser" class="loginForm">
        <h1>Login Form</h1>
        <img src="/app/views/logo.png" width="200" height="200"><br>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
<!--        <i class="fa fa-sign-in" aria-hidden="true"></i>-->
        <input type="submit" value="Log In">
    </form>
</div>
</body>
</html>