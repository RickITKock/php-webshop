<?php

require_once "Renderer.inc.php";

class ButtonRenderer extends Renderer {
    public function renderButton($attributes, $contentRenderer = null) {
        self::createHTML_element("button", $attributes, null, $contentRenderer);
    }
}

?>