<?php

class User extends SqlDataBaseConnection {
    private $user_id;
    private $user_email;
    private $user_password;
    private $user_type;

    // TODO: Add id and parent_id
    public function __construct($id, $email, $password, $user_type) {
        $this->user_id = $id;
        $this->user_email = $email;
        $this->user_password = $password;
        $this->user_type = $user_type;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function login($email, $password) {
        $query = "SELECT user_id, user_email, user_password, user_type ";
        $query.= "FROM dbusers ";
        $query.= "WHERE user_email = '$email';";
        $conn = self::connectWithDataBase();
        $res = $conn->query($query);
        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {        
                if (password_verify($_POST['password'], $row['user_password'])) {
                    $conn->close();
                    // TODO: Rename in databas the following attributes
                    return new User($row['user_id'], $row['user_email'], $row['user_password'], $row['user_type']);
                }
            }
        }
        $conn->close();
        return null;
    }

    // TODO: sign up -> check to see if user does not exist
    public function signUp($email, $password, $isUser) {
        $conn = self::connectWithDataBase();
        $password = crypt($password, 'st');
        $type = "user";
        if (!$isUser) { $type = "admin"; }
        $query = "INSERT INTO dbusers (user_email, user_password, user_type) VALUES ('$email', '$password', '$type');";
        $conn->query($query);
        $conn->close();
        return $result;
    }
}
?>