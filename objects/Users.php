<?php


class User {
    private $database_connection;
    private $user_id;
    private $username;
    private $user_email;
    private $user_token;
    private $password;



    function __construct($db) {
        $this->database_connection = $db;
    }

    function CreateUser($username_IN, $user_email_IN, $user_password_IN) {
        if(!empty($username_IN) && !empty($user_email_IN) && !empty($user_password_IN)) {
        
            $sql = "SELECT id FROM users WHERE username=:username_IN OR email=:email_IN";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":username_IN", $username_IN);
            $statement->bindParam(":email_IN", $user_email_IN);

            if( !$statement->execute() ) {
                echo "Could not Create 'CreateUser', please try again!";
                die();
            }

            // Checking all rows to see if there is a user with the same username OR email 
            $num_rows = $statement->rowCount();
            if($num_rows > 0) {
                echo "The user already exists, please log in with your email and password";
            }


            echo $username_IN . "<br />" . $user_email_IN;

        }

        
    }
}



?>