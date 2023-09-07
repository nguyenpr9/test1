<?php

function readFileToData($filePath){
    $dataJson = file_get_contents($filePath);
    return json_decode($dataJson, true);
}

function writeFileToData($filePath, $data){
    $dataJson = json_encode($data);
    file_put_contents($filePath, $dataJson);
}

function DeleteProduct($id){
    $data = readFileToData("products.json");
    foreach ($data as $key => $value) {
        if($value["id"] == $id){
            unset($data[$key]);
        }
    }
    writeFileToData("products.json", $data);
}

function checkUser($users, $email, $password) {
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

function createUser($filePath,$name, $email, $password){
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
