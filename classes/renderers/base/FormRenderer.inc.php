<?php

require_once "Renderer.inc.php";

class FormRenderer extends Renderer {

    public function renderForm($attributes, $content, $contentRenderer = null) {
        self::createHTML_element("form", $attributes, $content, $contentRenderer);
    }

    public function renderInput($attributes) {
        self::createHTML_element("input", $attributes, null);
    }

    public function renderTextArea($attributes, $content) {
        $element = "<textarea ";
        foreach ($attributes as $key => $value) {
            $element.=self::prepareAttribute($key, $value);
        }
        $element.=" >";
        echo $element;
        echo $content;
        echo "</textarea>";
    }
}

?>