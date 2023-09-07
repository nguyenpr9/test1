<?php
include_once("./handle/funtion.php");
if(!empty($_GET('id'))) {
    deleteProduct($_GET('id'));
}
?>