<?php
include_once "./handle/funtion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $isInvalid = false;

    // validate
    if (empty($name)) {
        $errName = "name is required";
        $isInvalid = true;
    }
    if (empty($price)) {
        $errName = "price is required";
        $isInvalid = true;
    }

    if (empty($description)) {
        $errEmail = "description is required";
        $isInvalid = true;
    }

    if (empty($status)) {
        $errPassword = "status is required";
        $isInvalid = true;
    }

    if ($isInvalid == false) {
        createProduct("./data/product.json", $name, $price, $description, $status);
        header("Location: product-list.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        Name: <input type="text" name="name" />
        <br>
        <?php if (isset($errName)) : ?>
            <span style="color: red;">
                <?php echo $errName ?>
            </span>
            <br>
        <?php endif ?>
        Email: <input type="email" name="email" />
        <br>
        Password: <input type="password" name="password" />
        <br>
        <button type="submit">Save</button>
    </form>
</body>

</html>