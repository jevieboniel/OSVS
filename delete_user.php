<?php
include 'db_connect.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $delete_query = $conn->query("DELETE FROM users WHERE id = $id");

    if($delete_query){
        echo "success";
    } else {
        echo "error";
    }
}
?>
