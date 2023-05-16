<?php

class ShoppingCart extends SqlDataBaseConnection {
    private $user_id = 1;
    private $cartlines = array();

    // TODO: Add id and parent_id
    public function __construct($user_id) {
        $this->user_id = $user_id;
        $this->getAllCartLinesFromUser($user_id);
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }

    // Get all cartlines belonging to particular user
    function getCartLinesCount() {
        $conn = self::connectWithDataBase();
        $user_id = $this->user_id;
        $query = "SELECT * FROM cartlines WHERE user_id = $user_id";
        $result = $conn->query($query);

        if (mysqli_num_rows($result) > 0) {
            $cartLinesCount = 0;
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $cartLinesCount += $row['amount'];
            }
            $conn->close();
            return $cartLinesCount;
        }
        $conn->close();
        return 0;
    }

    function addToCart($item_id) {
        $cartline = CartLine::findCartLine($this->user_id, $item_id);

        // Cart line does not exist. Create a new one
        if ($cartline == NULL) {
            $cartLine = new CartLine($this->user_id, $item_id, 1);
            $cartLine->saveCartLine();
        } else {
            // Cart line exists, so increment and update it,s amount (update)
            $cartline->incrementAmount();
        }
    }

    function getTotalPriceOfShoppingCart() {
        $arrlength = count($this->cartlines);
        $totalPrices = 0;
        $i = 0;
        while ($i < $arrlength) {
            $totalPrices += $this->cartlines[$i]->getTotalPrice();
            $i++;
        }
        return $totalPrices;
    }

    function updateCart($item_id, $amount) {
        $cartline = CartLine::findCartLine($this->user_id, $item_id);
        if ($cartline != NULL) {
            if ($cartline->amount != $amount) {
                $cartline->update($amount);
                return true;
            }
        }
        return false;
    }

    function removeCartLine($item_id) {
        $cartline = CartLine::findCartLine($this->user_id, $item_id);
        if ($cartline != NULL) {
            $cartline->removeCartLine();
            return true;
        }
        return false;
    }

    // TODO: Correct the following code and remove the html representation
    private function getAllCartLinesFromUser($id) {
        $conn = self::connectWithDataBase();
        $query = "SELECT * from cartlines WHERE user_id = $id";
        $result = $conn->query($query);
        $user_id = $this->user_id;
        if (mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $cartline = new CartLine($user_id, $row['item_id'], $row['amount']);
                array_push($this->cartlines, $cartline);
                unset($cartline);
            }
            $conn->close();
        } else {
            $conn->close();
        }
    }
}
?>