
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



$product->category_name =$data->category_name;



// Update product
if($product->removeCategory()) {
    echo json_encode(
        array('message' => 'Category Removed')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Removed')
    );
}
