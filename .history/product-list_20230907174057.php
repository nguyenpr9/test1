<?php
include_once "./handle/funtion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $isInvalid = false;

    // validate
    if (empty($name)) {
        $errName = "Name is required";
        $isInvalid = true;
    }

    if (empty($email)) {
        $errEmail = "Email is required";
        $isInvalid = true;
    }

    if (empty($password)) {
        $errPassword = "Password is required";
        $isInvalid = true;
    }

    if ($isInvalid == false) {
        createUser("./data/user.json", $name, $email, $password);
        // quy lai login
        header("Location: login.php");
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
    <h1>Product list</h1>
    <a href="product-add.php">Add</a>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>price</th>
                <th>description</th>
                <th>status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $data = readFileToData("./data/product.json");
            foreach ($data as $value) {?>
                <tr>
                    <td><?= $value['id']?></td>
                    <td><?= $value['name']?></td>
                    <td><?= $value['price']?></td>
                    <td><?= $value['description']?></td>
                    <td><?= $value['status']?></td>
                    <td>
                        <a href="product-edit.php?id=<?= $value['id']?>">Edit</a>
                        <a href="product-delete.php?id=<?= $value['id']?>">Delete</a>
                    </td>
                </tr>
            <?php }?>
    </table>
</body>

</html>