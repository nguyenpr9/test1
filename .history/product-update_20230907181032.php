<?php
include_once "./handle/funtion.php";
$product = null;
if (!empty($_GET['id'])) {
    $product = getOneRecordById($_GET['id']);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $isInvalid = false;

    // validate
    if (empty($name)) {
        $errname = "name is required";
        $isInvalid = true;
    }
    if (empty($price)) {
        $errprice = "price is required";
        $isInvalid = true;
    }

    if (empty($description)) {
        $errdescription = "description is required";
        $isInvalid = true;
    }

    if (empty($status)) {
        $errstatus = "status is required";
        $isInvalid = true;
    }

    if ($isInvalid == false) {
        updateProduct("./data/product.json", $_GET['id'], $name, $price, $description, $status);
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
        Name: <input type="text" value="<?= isset($product['name']) ? $product['name'] : '' ?>" name="name" />
        <br>
        <?php if (isset($errname)) : ?>
            <span style="color: red;">
                <?php echo $errname ?>
            </span>
            <br>
        <?php endif ?>
        price: <input type="number" value="<?= isset($product['']) ? $product[''] : '' ?>" name="price" />
        <br>
        <?php if (isset($errprice)) : ?>
            <span style="color: red;">
                <?php echo $errprice ?>
            </span>
            <br>
        <?php endif ?>
        description: <input type="text" value="<?= isset($product['']) ? $product[''] : '' ?>" name="description" />
        <br>
        <?php if (isset($errdescription)) : ?>
            <span style="color: red;">
                <?php echo $errdescription ?>
            </span>
            <br>
        <?php endif ?>
        status: <select name="status">
            <option value="New">New</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
        <br>
        <?php if (isset($errstatus)) : ?>
            <span style="color: red;">
                <?php echo $errstatus ?>
            </span>
            <br>
        <?php endif ?>
        <br>
        <button type="submit">Save</button>
    </form>
</body>

</html>