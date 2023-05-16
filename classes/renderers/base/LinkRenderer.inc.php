<?php

require_once "Renderer.inc.php";

class LinkRenderer extends Renderer {
    public function renderLink($attributes, $contentRenderer = null) {
        self::createHTML_element("a", $attributes, null, $contentRenderer);
    }
}

?>