<?php

class Renderer {
    protected function prepareAttribute($name, $value = '', $is_mandatory = true) {
        $attribute = '';
        if ($is_mandatory || $value || $value === 0 || $value === '0') {
            $attribute = ' '.$name.'="'.htmlspecialchars($value).'"';
        } return $attribute;
    }

    public function createHTML_element($elementType, $attributes, $content, $contentRenderer = null) {
        echo '<'.$elementType;
        foreach ($attributes as $key=>$value) {
            echo self::prepareAttribute($key, $value);
        }
        echo ">";
        if ($contentRenderer) $contentRenderer();
        echo "</$elementType>";
    }
}

?>