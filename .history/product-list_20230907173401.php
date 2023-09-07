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
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $data = readProduct();
            foreach ($data as $value) {?>
                <tr>
                    <td><?= $value['id']?></td>
                    <td><?= $value['name']?></td>
                    <td><?= $value['email']?></td>
                    <td><?= $value['password']?></td>
                    <td>
                        <a href="edit.php?id=<?= $value['id']?>">Edit</a>
                        <a href="delete.php?id=<?= $value['id']?>">Delete</a>
                    </td>
                </tr>
            <?php }?>
    </table>
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