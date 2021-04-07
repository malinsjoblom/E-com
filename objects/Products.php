<?php

class products
{
    private $database_connection;
    private $product_id;
    private $product;
    private $description;
    private $price;

    function __construct($db)
    {
        $this->database_connection = $db;
    }

    function createProduct($product_IN, $description_IN, $price_IN)
    {

        if (!empty($product_IN) && !empty($description_IN)) {

            $sql = "SELECT product_id FROM Products WHERE product = :product_IN";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":product_IN", $product_IN);


            if (!$statement->execute()) {
                $error = new stdClass();
                $error->message = "Could not create product";
                $error->code = "0005";
                print_r(json_encode($error));
                die();
            }

             $num_rows = $statement->rowCount();
            if ($num_rows > 0) {
                $error = new stdClass();
                $error->message = "This product is already created";
                $error->code = "0006";
                print_r(json_encode($error));
                die();
            } 


            $sql = "INSERT INTO products (product, description, price) VALUES (:product_IN, :description_IN, :price_IN)";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":product_IN", $product_IN);
            $statement->bindParam(":description_IN", $description_IN);
            $statement->bindParam(":price_IN", $price_IN);

            if (!$statement->execute()) {
                $error = new stdClass();
                $error->message = "Could not create product, fill all fields";
                $error->code = "0007";
                print_r(json_encode($error));
                die();
            }

            $this->product = $product_IN;
            $this->description = $description_IN;
            $this->price = $price_IN;

            echo "The product is sucessfully created. Product name - $this->product, Description - $this->description, Price - $this->price";
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
        $sql = "SELECT * FROM products";
        $statement = $this->database_connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    function deleteProduct($product_id) {
        $sql = "DELETE FROM products WHERE product_id=:product_id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":product_id_IN", $product_id);
        $statement->execute();

        $message = new stdClass();
        if($statement->rowCount() > 0) {
            $message = new stdClass();
            $message->text = "Product with id $product_id was removed!";
            return $message;
        } 
        $message->text = "No product with id $product_id was found, please try again!";
        return $message;
    }

    function updateProducts($product_id, $product = "", $description = "", $price = "") {
     

        if(!empty($product)) {
            $this->updateProduct($product_id, $product);
        }
        if(!empty($description)) {
            $this->updateDescription($product_id, $description);
        }
        if(!empty($price)) {
            $this->updatePrice($product_id, $price);
        }

        return $product_id;
    }

    private function updateProduct($product_id, $product) {
        $sql = "UPDATE products SET product= :product_IN WHERE product_id=:product_id";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":product_IN", $product);
        $statement->bindParam(":product_id", $product_id);
        $statement->execute();
    }

    function updateDescription($product_id, $description) {
        $sql = "UPDATE products SET description= :description_IN WHERE product_id=:product_id";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":description_IN", $description);
        $statement->bindParam(":product_id", $product_id);
        $statement->execute();
    }

    function updatePrice($product_id, $price) {
        $sql = "UPDATE products SET price= :price_IN WHERE product_id=:product_id";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":price_IN", $price);
        $statement->bindParam(":product_id", $product_id);
        $statement->execute();
    }



}
