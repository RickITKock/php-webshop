<?php

// require_once "SqlDataBaseConnection.inc.php";

class Item extends SqlDataBaseConnection {
    private $id;
    private $name;
    private $category;
    private $description;
    private $isSale;
    private $stock;
    private $price;

    public function __construct($id, $name, $category, $description, $isSale, $stock, $price) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->description = $description;
        $this->isSale = $isSale;
        $this->stock = $stock;
        $this->price = $price;
    }

    public function __set($name, $value) { $this->$name = $value;}

    public function __get($name) { return $this->$name;}

    public function __toString() {
        $output = "<p>Name: " . $this->name . "<br>\n";
        $output .= "<p>Description: " . $this->description;
        return $output;
    }

    function saveItem() {
        $conn = self::connectWithDataBase();
        $query = "INSERT INTO items(name, description, is_sale, stock, price, category_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiidi", $this->name, $this->description, $this->isSale, $this->stock, $this->price, $this->category);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }

    function createNewItem($name, $description, $isSale, $stock, $price, $categoryId) {
        $conn = self::connectWithDataBase();
        $query = "INSERT INTO items(name, description, is_sale, stock, price, category_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiidi", $name, $description, $isSale, $stock, $price, $categoryId);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }

    function updateItem($item_id, $name, $description, $isSale, $stock, $price, $categoryId) {
        $conn = self::connectWithDataBase();
        $query = "UPDATE items SET name = ?, description = ?, is_sale = ?, stock = ?, price = ?, category_id = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiidii", $name, $description, $isSale, $stock, $price, $categoryId, $item_id);
        $result = $stmt->execute();
        $conn->close();
        return $result;
    }

    function getItemById($id) {
        $conn = self::connectWithDataBase();
        $query = "SELECT * FROM items WHERE id = $id";
        if ($result = $conn->query($query)) {
            $obj = mysqli_fetch_object($result);
            $conn->close();
            return $obj;
        }
        $conn->close();
        return NULL;
    }

    // TODO: Update the following code to delete itself, not using the id param
    function deleteItem($id) {
        $conn = self::connectWithDataBase();
        $query = "DELETE FROM items WHERE id = $id";
        $result = $conn->query($query);
        $conn->close();
        return $result;
    }

    public function getItems() {
        $conn = self::connectWithDataBase();
        $query = "SELECT * FROM items ORDER BY is_sale desc";
        $result = $conn->query($query);
        if (mysqli_num_rows($result) > 0) {
            $items = array();
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $item = new Item($row['id'], $row['name'], $row['category_id'], 
                $row['description'], $row['is_sale'], $row['stock'], $row['price']);
                $items[$item->id] = $item;
                unset($item);
            }
            $conn->close();
            return $items;
        } else {
            $conn->close();
            return NULL;
        }
    }

    // Change to category
    static function getItemsByCategoryId($categoryId) {
        $conn = self::connectWithDataBase();
        $query = "SELECT * FROM items WHERE category_id = $categoryId";
        $result = $conn->query($query);

        if (mysqli_num_rows($result) > 0) {
            $items = array();
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $item = new Item($row['id'], $row['name'], $row['category_id'], $row['description'], 
                $row['is_sale'], $row['stock'], $row['price']);
                array_push($items, $item);
                unset($item);
            }
            $conn->close();
            return $items;
        } else {
            $conn->close();
            return NULL;
        }
    }

    static function findItems($searchString) {
        $conn = self::connectWithDataBase();
        $sql = "SELECT * FROM items WHERE name LIKE '%$searchString%'";
        $result = $conn->query($sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $items = array();
                while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $item = new Item($row['id'], $row['name'], $row['category_id'], $row['description'], 
                    $row['is_sale'], $row['stock'], $row['price']);
                    array_push($items, $item);
                    unset($item);
                }
                $conn->close();
                return $items;
            }
        }
        else {
            $conn->close();
            return NULL;
        }
    }
}
?>