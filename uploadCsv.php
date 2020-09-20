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

            $categories = [];
            $products = [];
            while(($column = fgetcsv($file, 1000, ",")) != FALSE) {
                if($row > 0) {

                    $products[$row] = [$column[0],$column[1],$column[2],$column[3],$column[4],$column[5],$column[6],$column[7],$column[8],$column[9]];
                    $categories[] = $column[1];
                    $departments[] = $column[2];

                    header('Location: api/product/all_products.php');

                }
                $row++;
            }
            $categories = array_values(array_unique($categories));
            $departments = array_values(array_unique($departments));
            foreach ($categories as $keys=>$values) {
                $statement = $db->prepare("INSERT INTO category (category_name) VALUE ('".$values."')");
                $statement->execute();
            }

            foreach ($departments as $keys=>$values) {
                $statement = $db->prepare("INSERT INTO departments (department_name) VALUE ('".$values."')");
                $statement->execute();
            }

            $categories = $db->query("SELECT * FROM category")->fetchAll(PDO::FETCH_ASSOC);
            $departments = $db->query("SELECT * FROM departments")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $value) {
                foreach ($categories as $category) {
                    foreach ($departments as $department) {
                        if (($value[1] == $category['category_name'])&&($value[2] == $department['department_name'])) {
                            $prep = $db->prepare("INSERT into products (model_number, manufacturer_name, upc, sku, regular_price, sale_price, description, url, category_id, department_id) values (:model_number, :manufacturer_name, :upc, :sku,:regular_price, :sale_price, :description, :url, " . $category['id'] . ", ".$department['id'].")");
                            $prep->bindParam(':model_number', $value[0]);
                            $prep->bindParam(':manufacturer_name', $value[3]);
                            $prep->bindParam(':upc', $value[4]);
                            $prep->bindParam(':sku', $value[5]);
                            $prep->bindParam(':regular_price', $value[6]);
                            $prep->bindParam(':sale_price', $value[7]);
                            $prep->bindParam(':description', $value[8]);
                            $prep->bindParam(':url', $value[9]);
                            $prep->execute();
                        }
                    }
                }
            }
        } else {
            echo "Please Select CSV File";
        }
    } else {
        echo "Please Select File";
    }
}

?>
