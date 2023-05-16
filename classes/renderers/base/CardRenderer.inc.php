<?php

require_once "Renderer.inc.php";

class CardRenderer extends Renderer {
    public function renderCard($content, $contentRenderer = null) {
        echo '<div',
        self::prepareAttribute('class', 'card border-info'), 
        // self::prepareAttribute('style', 'background: none;'),
        '>';
        if ($contentRenderer) $contentRenderer($content);
        echo '</div>';
    }

    public function renderCardBody($content, $contentRenderer = null) {
        echo '<div',
        self::prepareAttribute('class', 'card-body text-light'),
        ">";
        if ($contentRenderer) $contentRenderer($content);
        echo '</div>';
    }

    public function renderCardHeader($content, $contentRenderer = null) {
        echo '<div',
        self::prepareAttribute('class', 'card-header text-light'),
        // self::prepareAttribute('style', 'background-color: white;'),
        ">";
        if ($contentRenderer) $contentRenderer($content);
        echo '</div>';
    }

    public function renderCardFooter($content, $contentRenderer = null) {
        echo '<div',
        self::prepareAttribute('class', 'card-footer border-0'),
        // self::prepareAttribute('style', 'background-color: white;'),
        ">";
        if ($contentRenderer) $contentRenderer($content);
        echo '</div>';
    }
}
?>