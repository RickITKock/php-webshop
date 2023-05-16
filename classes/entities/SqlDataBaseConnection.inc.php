<?php

// TODO: Rename repository to connection
class SqlDataBaseConnection {
    protected static function connectWithDataBase() {
        $SERVER_NAME = "localhost";
        $USER_NAME = "root";
        $PASSWORD = "";
        $DATABASE_NAME = "dbwebshop";
        return new mysqli($SERVER_NAME, $USER_NAME, $PASSWORD, $DATABASE_NAME);
    }
}

?>