<?php

class Products {
    private $database_connection;
    private $product_id;
    private $product_name;
    private $product_description;
    private $product_price;
    
    function __construct($db) {
    $this->database_connection = $db;
    }

    function createProduct($product_name_IN, $product_description_IN, $product_price_IN) {
        if (!empty($product_name_IN) && !empty($product_description_IN)) {

        $sql = "SELECT id FROM Products WHERE product_name = :product_name_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":product_name_IN", $product_name_IN);

        
        if(!$statement->execute()) {
            $error = new stdClass();
            $error->message = "Could not execute query";
            $error->code = "0005";
            print_r(json_encode($error));
            die();
        }

        $all_rows = $statement->rowCount();
        if($all_rows > 0) {
            $error = new stdClass();
            $error->message = "This product is already created";
            $error->code = "0006";
            print_r(json_encode($error));
            die();
        }

        $sql = "INSERT INTO products (ProductName, description, price) VALUES (:product_name_IN, :product_description_IN, :product_price_IN)";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":product_name_IN", $product_name_IN);
        $statement->bindParam(":product_description_IN", $product_description_IN);
        $statement->bindParam(":product_price_IN", $product_price_IN);

        if(!$statement->execute()) {
            $error = new stdClass();
            $error->message = "Could not create product";
            $error->code = "0007";
            print_r(json_encode($error));
            die();
        }

        $this->productname = $product_name_IN;
        $this->description = $product_description_IN;
        $this->price = $product_price_IN;

        echo "The product is sucessfully created. Product name - $this->procutname, Description - $this->description, Price - $this->price";
        die();

    } else {
        $error = new stdClass();
        $error->message = "All fields are required!";
        $error->code = "0007";
        print_r(json_encode($error));
        die();
    }
}

function getAllProducts() {
    $sql = "SELECT id, ProductName FROM products";
    $statement = $this->database_connection->prepare($sql);
}
    



}
?>