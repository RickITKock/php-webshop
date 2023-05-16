<?php

include_once "classes/entities/Item.inc.php";

class ShoppingCartRenderer extends Renderer {
    private $buttonRenderer;
    private $tableRenderer;

    public function __construct() {
        $this->buttonRenderer = new ButtonRenderer();
        $this->tableRenderer = new TableRenderer();
    }

    public function renderShoppingCart($cartlines) {
        $this->tableRenderer->renderTable($cartlines, function($cartlines) {
            $cartCount = 0;
            $totalPrice = 0;
            echo "<tbody>";
            $this->tableRenderer->renderTableHeader(array("Item", "Price", "Amount", "Total price", ""));
            foreach ($cartlines as $cartline) {
                $item = Item::getItemById($cartline->item_id);
                $data = array();
                $data["item"] = $item;
                $data["cartline"] = $cartline;

                $cartCount += $data['cartline']->amount;
                $totalPrice += $data["cartline"]->amount * $data["item"]->price;
                $this->tableRenderer->renderTableRow($data, function ($data) {

                    
                    echo '<form method="POST" action="validations/shoppingcart_form_validation.php">';
                    echo '<input name="id" value="'.$data["item"]->id.'" hidden>';
                    $this->tableRenderer->renderTableData($data, function($data) {
                        echo $data["item"]->name;
                    });
                    $this->tableRenderer->renderTableData($data, function($data) {
                        echo $data["item"]->price;
                    });
                    $this->tableRenderer->renderTableData($data, function($data) {
                        echo '<div class="input-group">';
                        echo '<input class="form-control form-control-sm" min="1" max="'.$data["item"]->stock.'" name="amount" type="number" value="'.$data["cartline"]->amount.'"/>';
                        echo '<div class="input-group-append">';
                        echo '<button type="submit" class="btn btn-light border btn-sm" style="background-color: white;" name="update_cart">Update</button>';
                        echo '</div>';
                        echo '</div>';
                    });
                    $this->tableRenderer->renderTableData($data, function($data) {
                        echo $data["cartline"]->getTotalPrice();
                    });
                    $this->tableRenderer->renderTableData(null, function() {
                        $this->buttonRenderer->renderButton(
                            array(
                                'name' => "remove_cart",
                                'type' => "submit",
                                'class' => "btn border",
                                'style' => "background-color: white;",
                            ), function() { echo "Delete";}
                        );
                    });
                    echo "</form>";
                });
            }
            echo '</tbody>';
            echo '<tfoot>';
            echo '<tr>';
            echo '<td colspan="3"><i class="float-right">Subtotal (<b class="text-primary">'.$cartCount.'</b> items):</i></td>';
            echo '<td colspan="2">';
            echo $totalPrice;
            echo '</td>';
            echo '</tr>';
            echo '</tfoot>';
        });
    }
}