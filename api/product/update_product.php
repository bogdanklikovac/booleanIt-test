
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Db.php';
include_once '../../models/Product.php';

//Instantiate DB
$database = new Db();
$db = $database->connect();

// Instantiate product object
$product = new Product($db);



$data = json_decode(file_get_contents("php://input"));


$product->id = $data->id;
$product->category_name =$data->category_name;
$product->department_name =$data->department_name;
$product->model_number =$data->model_number;
$product->manufacturer_name =$data->manufacturer_name;
$product->upc =$data->upc;
$product->sku =$data->sku;
$product->regular_price =$data->regular_price;
$product->sale_price =$data->sale_price;
$product->description =$data->description;
$product->url =$data->url;



// Update product
if($product->updateProduct()) {
    echo json_encode(
        array('message' => 'Product Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Product Not Updated')
    );
}
