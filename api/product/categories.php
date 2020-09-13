<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include_once '../../config/Db.php';
include_once '../../models/Product.php';


//Instantiate DB
$database = new Db();
$db = $database->connect();

// Instantiate product object
$product = new Product($db);

$result = $product->getAllCategories();

// Get row count
$num = $result->rowCount();


if($num > 0) {
    $categories_arr = array();
    $categories_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $categories_name = array(
            'category_name' => $category_name
        );

        array_push($categories_arr['data'],$categories_name);
    }
    //Turn to JSON
    echo json_encode($categories_arr);
} else {
    echo json_encode(
        array('message'=>'No Data Found')
    );
}
