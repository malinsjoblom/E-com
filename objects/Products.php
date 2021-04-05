<?php

class products
{
    private $database_connection;
    private $product_id;
    private $product_name;
    private $product_desc;
    private $product_price;

    function __construct($db)
    {
        $this->database_connection = $db;
    }

    function createProduct($product_name_IN, $product_desc_IN, $product_price_IN)
    {

        if (!empty($product_name_IN) && !empty($product_desc_IN)) {

            $sql = "SELECT product_id FROM Products WHERE product = :product_name_IN";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":product_name_IN", $product_name_IN);


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


            $sql = "INSERT INTO products (product, description, price) VALUES (:product_name_IN, :product_desc_IN, :product_price_IN)";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":product_name_IN", $product_name_IN);
            $statement->bindParam(":product_desc_IN", $product_desc_IN);
            $statement->bindParam(":product_price_IN", $product_price_IN);

            if (!$statement->execute()) {
                $error = new stdClass();
                $error->message = "Could not create product, fill all fields";
                $error->code = "0007";
                print_r(json_encode($error));
                die();
            }

            $this->productname = $product_name_IN;
            $this->description = $product_desc_IN;
            $this->price = $product_price_IN;

            echo "The product is sucessfully created. Product name - $this->productname, Description - $this->description, Price - $this->price";
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

    function deleteProduct($product_id)
    {
        $sql = "DELETE FROM products WHERE id =:product_id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":product_id_IN", $product_id);
        $statement->execute();

        $message = new stdClass();
        if ($statement->rowCount() > 0) {
            $message->text = "The product with id $product_id was deleted!";
            return $message;
        } else {
            $message->text = "The id was not found, please try again";
            return $message;
        }
    }
}
