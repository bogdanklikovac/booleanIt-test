<?php

include_once 'config/Db.php';



//Instantiate DB
$database = new Db();
$db = $database->connect();

if(isset($_POST["import"])){
    $fileName = explode(".",$_FILES["file"]["name"]);

    if($_FILES["file"]["tmp_name"]) {
        if(end($fileName) == "csv") {
            $file = fopen($_FILES["file"]["tmp_name"], "r");

            while(($column = fgetcsv($file, 1000, ",")) != FALSE) {
                if($row > 0) {
                    $prep = $db->prepare("INSERT into products (model_number, category_name, departmant_name, manufacturer_name, upc, sku, regular_price, sale_price, description, url) values (:model_number, :category_name, :departmant_name, :manufacturer_name, :upc, :sku, :regular_price, :sale_price, :description, :url)");
                    $prep->bindParam(':model_number', $column[0]);
                    $prep->bindParam(':category_name', $column[1]);
                    $prep->bindParam(':departmant_name', $column[2]);
                    $prep->bindParam(':manufacturer_name', $column[3]);
                    $prep->bindParam(':upc', $column[4]);
                    $prep->bindParam(':sku', $column[5]);
                    $prep->bindParam(':regular_price', $column[6]);
                    $prep->bindParam(':sale_price', $column[7]);
                    $prep->bindParam(':description', $column[8]);
                    $prep->bindParam(':url', $column[9]);

                    $prep->execute();
                    header('Location: api/product/all_products.php');

                }
                $row++;
            }
        } else {
            echo "Please Select CSV File";
        }
    } else {
        echo "Please Select File";
    }
}

?>
