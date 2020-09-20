<?php

class Product {

    private $conn;
    private $table = 'products';

    //Product property
    public $id;
    public $model_number;
    public $category_id;
    public $department_id;
    public $manufacturer_name;
    public $upc;
    public $sku;
    public $regular_price;
    public $sale_price;
    public $description;
    public $url;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get All Products
    public function getAllProducts() {
        $query = 'SELECT p.*, d.department_name, c.category_name
                  FROM products p
                  INNER JOIN category c
                  ON p.category_id = c.id
                  INNER JOIN departments d
                  ON p.department_id = d.id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get categories
    public function getAllCategories() {
        $query = 'SELECT category_name FROM category';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }


    // Get Specific Products
    public function getSpecificProduct() {
        $query = 'SELECT p.*, d.department_name, c.category_name
                  FROM products p
                  INNER JOIN category c
                  ON p.category_id = c.id
                  INNER JOIN departments d
                  ON p.department_id = d.id
                  WHERE c.category_name = :category_name';


        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind Category Name
        $stmt->bindParam(':category_name',$this->category_name);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    // Update Product Category
    public function updateProductCategory() {

        //Create query
        $query = 'UPDATE category 
                  SET
                    category_name = :category_name
                  WHERE
                    id = :id';
        $stmt = $this->conn->prepare($query);


        $this->category_name = htmlspecialchars(strip_tags($this->category_name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data

        $stmt->bindParam(':category_name', $this->category_name);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }

    // Delete product
    public function deleteProduct() {
        //Query
        $query = 'DELETE FROM ' .$this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }

    // Update Product
    public function updateProduct() {

        //Create query
        $query = 'UPDATE ' . $this->table . ' 
                  SET
                    model_number = :model_number,
                    manufacturer_name = :manufacturer_name,
                    upc = :upc,
                    sku = :sku,
                    regular_price = :regular_price,
                    sale_price = :sale_price,
                    description = :description,
                    url = :url,
                    category_id = :category_id,
                    department_id = :department_id
                  WHERE
                    id = :id';
        $stmt = $this->conn->prepare($query);


        //Bind data



        $stmt->bindParam(':model_number', $this->model_number);
        $stmt->bindParam(':manufacturer_name', $this->manufacturer_name);
        $stmt->bindParam(':upc', $this->upc);
        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':regular_price', $this->regular_price);
        $stmt->bindParam(':sale_price', $this->sale_price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':url', $this->url);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':department_id', $this->department_id);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }


    public function removeCategory() {

        //Create query
        $query = 'UPDATE category 
                  SET
                    category_name = NULL
                  WHERE
                    category_name = :category_name';

        $stmt = $this->conn->prepare($query);


        $this->category_name = htmlspecialchars(strip_tags($this->category_name));


        //Bind data

        $stmt->bindParam(':category_name', $this->category_name);


        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

}