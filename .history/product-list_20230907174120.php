<?php
include_once "./handle/funtion.php";
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