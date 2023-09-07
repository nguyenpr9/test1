<?php

function readFileToData($filePath)
{
    $dataJson = file_get_contents($filePath);
    return json_decode($dataJson, true);
}

function writeFileToData($filePath, $data)
{
    $dataJson = json_encode($data);
    file_put_contents($filePath, $dataJson);
}

function getOneRecordById($id) {
    $data = readFileToData("data.json");
    $record = [];
    foreach ($data as $key => $value) {
        if ($value["id"] == $id) {
            $record = $value;
        }
    }
    return $record;
}

function deleteProduct($id)
{
    $data = readFileToData("../data/product.json");
    foreach ($data as $key => $value) {
        if ($value["id"] == $id) {
            unset($data[$key]);
        }
    }
    writeFileToData("../data/product.json", $data);
}

function checkUser($users, $email, $password)
{
    foreach ($users as $index => $user) {
        if (
            $user['email'] == $email  &&
            $user['password'] == $password
        ) {
            return true;
        }
    }

    return false;
}

function getLastId($items)
{
    $lastId = 0;
    foreach ($items as $item) {
        $id = (int)$item['id'];
        if ($id > $lastId) {
            $lastId = $id;
        }
    }
    return $lastId;
}


function createUser($filePath, $name, $email, $password)
{
    // chuyen doi du lieu tu json -> array
    $users = readFileToData($filePath);

    $userRegister = [
        "name" => $name,
        "email" => $email,
        "password" => $password
    ];
    array_push($users, $userRegister);
    writeFileToData($filePath, $users);
}

function createProduct($filePath, $name, $price, $description, $status)
{
    // chuyen doi du lieu tu json -> array
    $products = readFileToData($filePath);
    $lastId = getLastId($products);
    $product = [
        "id" => $lastId + 1,
        "name" => $name,
        "price" => $price,
        "description" => $description,
        "status" => $status
    ];
    array_push($products, $product);
    writeFileToData($filePath, $products);
}
function updateProduct($filePath, $id, $name, $price, $description, $status)
{
    // chuyen doi du lieu tu json -> array
    $products = readFileToData($filePath);
    foreach ($products as $index => $product) {
        if ($product["id"] == $id) {
            $products[$index]["name"] = $name;
            $products[$index]["price"] = $price;
            $products[$index]["description"] = $description;
            $products[$index]["status"] = $status;
        }
    }
    writeFileToData($filePath, $products);
}
