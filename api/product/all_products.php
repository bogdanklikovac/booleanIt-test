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

$result = $product->getAllProducts();

$num = $result->rowCount();

if($num > 0) {
    $product_arr = array();
    $product_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $product = array(
            'category_name' => $category_name,
            'id'=> $id,
            'model_number'=> $model_number,
            'department_name'=> $department_name,
            'manufacturer_name'=> $manufacturer_name,
            'upc'=> $upc,
            'sku'=> $sku,
            'regular_price'=> $regular_price,
            'sale_price'=> $sale_price,
            'description'=> $description,
            'url'=> $url,
        );

        array_push($product_arr['data'],$product);
    }
    //Turn to JSON
    echo json_encode($product_arr);
} else {
    echo json_encode(
        array('message'=>'No Data Found')
    );
}