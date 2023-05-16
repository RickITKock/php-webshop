<?php

// spl_autoload_register(function($class) {
//     include_once "base/". $class . ".inc.php";
// });

class ItemCardRenderer extends Renderer {
    private $cardRenderer;
    private $buttonRenderer;

    public function __construct() {
        $this->cardRenderer = new CardRenderer();
        $this->buttonRenderer = new ButtonRenderer();
    }

    public function renderForUser($item) {
        echo '<div class="card mb-2 border-info shadow" style="width: 100%;  background: none;">';
        $this->cardRenderer->renderCardHeader($item, function($item) {
            echo "<h5>$item->name</h5>";
        });
        $this->cardRenderer->renderCardBody($item, function($item) {
            if ($item->isSale) {
                echo "<span class='badge badge-danger badge-pill px-3'>Sale</span>&nbsp;";
            }
            self::renderStockInformation($item->stock);
            self::renderPriceInformation($item->price);
        });
        $this->cardRenderer->renderCardFooter($item, function($item) {
            echo '<form id="resourceForm" action="validations/process_resource.php" method="POST">';
            echo '<input name="id" type="number" value="'.$item->id.'" hidden />';
            echo '<input name="btn_pressed" type="text" hidden/>';
            echo '<div class="btn-group float-right">';
             $this->buttonRenderer->renderButton(
                array(
                    'type' => "button",
                    'class' => "btn btn-outline-info",
                    // 'style' => "background-color: white;",
                    'data-toggle' => "modal",
                    'data-target' => '#info'.preg_replace('/\s+/', '',  $item->name.$item->id),
                ), function() { echo "Info";}
            );
            $this->buttonRenderer->renderButton(
                array(
                    'name' => 'btn_add_to_cart',
                    'type' => "submit",
                    'class' => "btn btn-outline-info",
                    // 'style' => "background-color: white;",
                ), function() { echo "+ Add to cart";}
            );
            echo '</div>';
            echo'</form>';
        });
        echo '</div>';
    }

    private function renderStockInformation($stock) {
        if ($stock > 2) {
            echo "<span class='badge badge-success badge-pill px-3'>stock: $stock</span>";
        } else if ($stock == 2) {
            echo "<span class='badge badge-warning badge-pill px-3'>stock: $stock</span>";
        } else {
            echo "<span class='badge badge-danger badge-pill px-3'>stock: $stock</span>";
        }
    }

    private function renderPriceInformation($price) {
        echo '<h5 class="lead">Price: &euro;'.$price.'</h5>';
    }

    public function renderForAdmin($item) {
        $this->cardRenderer->renderCard($item, function($item) {
            $this->cardRenderer->renderCardHeader($item, function($item) {
                echo "<h5>$item->name</h5>";
            });
            $this->cardRenderer->renderCardBody($item, function($item) {
                if ($item->isSale) {
                    echo "<span class='badge badge-danger badge-pill px-3'>Sale</span>&nbsp;";
                }
                self::renderStockInformation($item->stock);
                self::renderPriceInformation($item->price);
                
                echo "<hr />";
                echo "<p>$item->description</p>";
            });
            $this->cardRenderer->renderCardFooter($item, function($item) {
                echo '<form id="updateItemForm" action="mutate_item_page.php" method="POST">';
                echo '<input name="id" type="number" value="'.$item->id.'" hidden />';
                echo '<input name="btn_pressed" type="text" hidden />';
                echo '<div class="btn-group float-right">';
                $this->buttonRenderer->renderButton(
                    array(
                        'type' => "button",
                        'class' => "btn border",
                        'style' => "background-color: white;",
                        'data-toggle' => "modal",
                        'data-target' => '#info'.preg_replace('/\s+/', '',  $item->name.$item->id),
                    ), function() { echo "Info";}
                );
                $this->buttonRenderer->renderButton(
                    array(
                        'type' => "submit",
                        'class' => "btn border",
                        'style' => "background-color: white;",
                    ), function() { echo "Update";}
                );
                $this->buttonRenderer->renderButton(
                    array(
                        'onclick' => "promptDeleteItem($item->id)",
                        'type' => "button",
                        'class' => "btn border",
                        'style' => "background-color: white;",
                    ), function() { echo "Delete";}
                );
                echo '</div>';
                echo "</form>";
            });
        });
    }
}

?>