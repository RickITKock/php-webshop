<?php

require_once "Renderer.inc.php";

class ModalRenderer extends Renderer {
    public function renderModal($id, $content, $contentRenderer = null) {
        echo '<div',
        self::prepareAttribute('class', 'modal fade'),
        self::prepareAttribute('id', preg_replace('/\s+/', '', $id)),
        self::prepareAttribute('tabindex', '-1'),
        self::prepareAttribute('aria-hidden', 'true'),
        '>';
        if ($contentRenderer) $contentRenderer($content);
        echo '</div>';
    }

    public function renderModalContent($content, $contentRenderer = null) {
        echo '<div class="modal-dialog" role="document">';
        echo '<div class="modal-content">';
        if ($contentRenderer) $contentRenderer($content);
        echo '</div>';
        echo '</div>';
    }

    public function renderLargeModalContent($content, $contentRenderer = null) {
        echo '<div class="modal-dialog modal-lg" role="document">';
        echo '<div class="modal-content">';
        if ($contentRenderer) $contentRenderer($content);
        echo '</div>';
        echo '</div>';
    }

    public function renderModalHeader($content, $contentRenderer = null) {
        echo '<div',
        self::prepareAttribute('class', 'modal-header'),
        ">";
        if ($contentRenderer) $contentRenderer($content);
        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
    }

    public function renderModalBody($content, $contentRenderer = null) {
        echo '<div',
        self::prepareAttribute('class', 'modal-body'),
        ">";
        if ($contentRenderer) $contentRenderer($content);
        echo '</div>';
    }

    public function renderModalFooter($content, $contentRenderer = null) {
        echo '<div',
        self::prepareAttribute('class', 'modal-footer'),
        ">";
        if ($contentRenderer) $contentRenderer($content);
        echo '</div>';
    }
}
?>