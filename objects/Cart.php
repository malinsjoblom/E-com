<?php 

class Cart {

private $database_connection;
private $user_id;
private $product_id;
private $quantity;

function __construct($db){
    $this->database_connection= $db;
}

function addToCart($product_id_IN, $user_id_IN, $token_IN, $quantity_IN){

    $sql = "SELECT * FROM cart WHERE user_id = :user_id_IN AND product_id = :product_id_IN";
    $statement = $this->database_connection->prepare($sql);
    $statement->bindParam(":user_id_IN", $user_id_IN);
    $statement->bindParam(":product_id_IN", $product_id_IN);
    $statement->execute();
    if($statement->rowCount() > 0) {
        $error = new stdClass();
        $error->message = "This product is already in your cart!";
        $error->code = "0009";
        print_r(json_encode($error));
        die();
        die();


    }

    $sql = "SELECT * FROM users WHERE id = :user_id_IN";
    $statement = $this->database_connection->prepare($sql);
    $statement->bindParam("user_id_IN", $user_id_IN);
    $statement->execute();
    $userCount = $statement->rowCount();
    if($userCount < 1) {
        $error = new stdClass();
        $error->message = "This user does not exist!";
        $error->code = "0001";
        print_r(json_encode($error));
        die();
    }

    $sql = "SELECT * FROM products WHERE product_id = :product_id_IN";
    $statement = $this->database_connection->prepare($sql);
    $statement->bindParam(":product_id_IN", $product_id_IN);
    $statement->execute();
    $productCount = $statement->rowCount();
    if($productCount < 1) {
        $error = new stdClass();
        $error->message = "This product does not exist!";
        $error->code = "0010";
        print_r(json_encode($error));
        die();
    }

    $sql = "INSERT INTO cart (product_id, user_id, token, quantity) VALUES(:product_id_IN, :user_id_IN, :token_IN, :quantity_IN)";
    $statement = $this->database_connection->prepare($sql);
    $statement->bindParam(":product_id_IN", $product_id_IN);
    $statement->bindParam(":user_id_IN", $user_id_IN);
    $statement->bindParam(":quantity_IN", $quantity_IN);
    $statement->bindParam(":token_IN", $token_IN);

    if($statement->execute()) {
        $return = new stdClass();
        $return->text= "The product $product_id_IN was succesfully added to your cart";
        return $return;
    }
}

function deleteProduct($user_id_IN, $product_id_IN) {
    $sql = "SELECT * FROM cart WHERE user_id = :user_id_IN AND product_id = :product_id_IN";
    $statement = $this->database_connection->prepare($sql);
    $statement->bindParam(":product_id_IN", $product_id_IN);
    $statement->bindParam(":user_id_IN", $user_id_IN);
    $statement->execute();
    if($statement->rowCount() < 1) {
        $error = new stdClass();
        $error->message = "This product with id $product_id_IN is not in the cart";
        $error->code = "0012";
        print_r(json_encode($error));
        die();
    }

    $sql = "DELETE FROM cart WHERE user_id = :user_id_IN AND product_id = :product_id_IN";
    $statement= $this->database_connection->prepare($sql);
    $statement->bindParam(":user_id_IN", $user_id_IN);
    $statement->bindParam(":product_id_IN", $product_id_IN);
    
    if($statement->execute()) {
        $return = new stdClass();
        $return->text = "The product $product_id_IN was removed from your cart";
        return $return;
    }
}

function checkout($token_IN) {
    $sql = "DELETE FROM cart WHERE token = :token_IN";
    $statement=$this->database_connection->prepare($sql);
    $statement->bindParam(":token_IN", $token_IN);

    if($statement->execute()) {
        $return = new stdClass();
        $return->text = "Thank you for your order!";
        return $return;
    }
}

}
