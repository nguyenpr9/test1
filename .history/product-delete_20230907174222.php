<?php
include_once("./handle/funtion.php");
$users = readFileToData("./data/user.json");
// kiem tra method request
// $_SERVER bien toan cuc, chua thong tin server
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get data tu request
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $checkUser = checkUser($users, $email, $password);
    if ($checkUser) {
        header('Location: home.php');
    } else {
        $errMsg = 'Account not exist';
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form action="" method="post">
        Email: <input id="email" type="email" name="email">
        Password: <input type="password" name="password">
        <button type="submit">Login</button>
        <?php
        // isset ham kiem tra ton tai
        if (isset($errMsg)) {
            echo $errMsg;
        }
        ?>
    </form>
    <p>Create new account? <a href="register.php">Register</a></p>
</body>

</html>