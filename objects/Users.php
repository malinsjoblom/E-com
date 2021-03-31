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

    function CreateUser($username_IN, $user_email_IN, $password_IN) {
        if(!empty($username_IN) && !empty($user_email_IN) && !empty($password_IN)) {
        
            $sql = "SELECT id FROM users WHERE username=:username_IN OR email=:user_email_IN";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":username_IN", $username_IN);
            $statement->bindParam(":user_email_IN", $user_email_IN);

            if( !$statement->execute() ) {
                echo "Could not Create 'CreateUser', please try again!";
                die();
            }

            // Checking all rows to see if there is a user with the same username OR email 
            $num_rows = $statement->rowCount();
            if($num_rows > 0) {
                $error = new stdClass();
                $error->message = "The user already exists, please log in with your email and password <br />";
                return $error;
                print_r(json_encode($error));
                die();
            }

            $password_IN = $password_IN;
            $password_IN = password_hash($password_IN, PASSWORD_DEFAULT);

            echo "<br /> USERNAME: $username_IN  <br /> EMAIL: $user_email_IN";


        $sql = "INSERT INTO users (username, email, password, role) VALUES(:username_IN, :user_email_IN, :password_IN, 'user')";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":username_IN", $username_IN);
        $statement->bindParam(":user_email_IN", $user_email_IN);
        $statement->bindParam(":password_IN", $password_IN);

         if(!$statement->execute() ) {
            echo "Something went wrong, please try again!";
            die();
        } 

        $this->username = $username_IN;
        $this->user_email = $user_email_IN;
        die();
    
    } else {
        echo "All fields are required!";
        die();
        }   

    }

    function GetAllUsers() {
    $sql = "SELECT username, email, password FROM users";
    $statement = $this->database_connection->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(); 
}
    
    function GetUser ($user_id) {
    $sql = "SELECT id, username, email, password FROM users WHERE id=:user_id_IN";
    $statement = $this->database_connection->prepare($sql);
    $statement->bindParam(":user_id_IN", $user_id);
    
    

    if( !$statement->execute() || $statement->rowCount() < 1) {
        $error = new stdClass();
        $error->message = "This user does not exist, try register your email";
        $error->code = "0001";
        print_r(json_encode($error));
        die();
    }

    $row = $statement->fetch();

    $this->username = $row['username'];
    $this->user_email = $row['email'];
    $this->password = $row['password'];
    $this->user_id = $row['id'];

    return $row;

}

    function Login($username_IN, $password_IN) {

        $sql = "SELECT id, username, email, role FROM users WHERE username=:username_IN AND password=:password_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":username_IN", $username_IN);
        $statement->bindParam(":password_IN", $password_IN);
        $statement->execute();

        // If the right username and password has been provided a token is created
        if($statement->rowCount() == 1) { 
            $row = $statement->fetch();
            return $this->CreateToken($row['id'], $row['username']);
        }
    }

    function CreateToken($id, $username) {
        $checked_token = $this->CheckToken($id);

        if($checked_token != false) {
            return $checked_token;
        }

        $token = md5(time() . $id . $username);

        $sql = "INSERT INTO sessions (user_id, token, last_used) VALUES(:user_id_IN, :token_IN, :last_used_IN)";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam("user_id_IN", $id);
        $statement->bindParam(":token_IN", $token);
        $time = time();
        $statement->bindParam(":last_used_IN", $time);

        $statement->execute();

        return $token;
    }

    function CheckToken($id) {
        $sql = "SELECT token, last_used FROM sessions WHERE user_id=:user_id_IN AND last_used > :active_time_IN LIMIT 1";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":user_id_IN", $id);
        $active_time = time() - (60*60);

        $statement->bindParam(":active_time_IN", $active_time);

        $statement->execute();

        $return = $statement->fetch();

        if(isset($return['token'])) {
            return $return['token'];
        } else {
            return false;
        }

    }
function isTokenValid($token) {
    $sql = "SELECT token, last_used FROM sessions WHERE token=:token_IN AND last_used > :active_time_IN LIMIT 1";
    $statement = $this->database_connection->prepare($sql);
    $statement->bindParam(":token_IN", $token);
    $active_time = time() - (60*60);

    $statement->bindParam(":active_time_IN", $active_time);

    $statement->execute();

    $return = $statement->fetch();
}



}
