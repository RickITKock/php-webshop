<?php

    class CartLine extends SqlDataBaseConnection {
        private $user_id;
        private $item_id;
        private $amount;

        // TODO: Add id and parent_id
        public function __construct($user_id, $item_id, $amount) {
            $this->user_id = $user_id;
            $this->item_id = $item_id;
            $this->amount = $amount;
        }

        public function __set($name, $value) {
            $this->$name = $value;
        }

        public function __get($name) {
            return $this->$name;
        }

        public function __toString() {
            $output = "user_id: " . $this->user_id . "<br />";
            $output .= "item_id: " . $this->item_id . "<br />";
            $output .= "amount: " . $this->amount . "<br />";
            return $output;
        }

        function getTotalPrice() {
            $conn = self::connectWithDataBase();
            $query = "SELECT * FROM items WHERE id = $this->item_id";
            $result = $conn->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if ($row) {
                $price = ($row['price'] * $this->amount);
                $conn->close();
                return $price;
            } else {
                $conn->close();
                return NULL;
            }
        }

        function saveCartLine() {
            $conn = self::connectWithDataBase();
            $query = "INSERT INTO cartlines (user_id, item_id, amount) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iii", $this->user_id, $this->item_id, $this->amount);
            $result = $stmt->execute();
            $conn->close();
            return $result;
        }

        function incrementAmount() {
            $conn = self::connectWithDataBase();
            $user_id = $this->user_id;
            $item_id = $this->item_id;
            $amount = $this->amount;

            $newAmount = $amount + 1;

            if (!$this->reachedStockAmount($item_id, $newAmount)) {
                $query = "UPDATE cartlines SET amount = amount + 1  WHERE user_id=$user_id AND item_id=$item_id";
                $conn->query($query);
            } else {
                echo "Something went wrong";
            }
            $conn->close();
        }

        function reachedStockAmount($id, $amount) {
            $item = Item::getItemById($id);
            return ($amount > $item->stock);
        }

        function update($amount) {
            $conn = self::connectWithDataBase();
            $user_id = $this->user_id;
            $item_id = $this->item_id;
            if (!$this->reachedStockAmount($item_id, $amount)) {
                if ($amount >= 1) {
                    $query = "UPDATE cartlines SET amount=$amount WHERE user_id=$user_id AND item_id=$item_id";
                    $conn->query($query);
                }
            }
            $conn->close();
        }

        function removeCartLine() {
            $conn = self::connectWithDataBase();
            $user_id = $this->user_id;
            $item_id = $this->item_id;
            $query = "DELETE FROM cartlines WHERE user_id=$user_id AND item_id=$item_id";
            $result = $conn->query($query);
            $conn->close();
            return $result;
        }

        // TODO: Check what this is fore
        static function getCartLines() {
            // $servername = "localhost";
            // $username = "root";
            // $password = "";
            // $db = "dbwebshop";
            // $conn = new mysqli($servername, $username, $password, $db);
            // $query = "SELECT * FROM categories";
            // $result = $conn->query($query);

            // if (mysqli_num_rows($result) > 0) {

            //     $categories = array();
            //     while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            //         $category = new Category($row['id'], $row['category']);
            //         array_push($categories, $category);
            //         unset($category);
            //     }
            //     $conn->close();
            //     return $categories;
            // } else {
            //     $conn->close();
            //     return NULL;
            // }
        }

        static function findCartLine($user_id, $item_id) {
            $conn = self::connectWithDataBase();
            $query = "SELECT * FROM cartlines WHERE user_id = $user_id AND item_id = $item_id";
            $result = $conn->query($query);

            $row = $result->fetch_array(MYSQLI_ASSOC);

            if ($row) {
                $cartline = new CartLine($row['user_id'], $row['item_id'], $row['amount']);
                $conn->close();
                return $cartline;
            } else {
                $conn->close();
                return NULL;
            }
        }
    }
?>