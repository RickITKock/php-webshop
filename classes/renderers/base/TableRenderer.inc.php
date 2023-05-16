<?php

require_once "Renderer.inc.php";

class TableRenderer extends Renderer {
    public function renderTable($content, $contentRenderer = null) {
        echo '<table',
        self::prepareAttribute('class', 'table table-borderless'),
        '>';
        if ($contentRenderer) $contentRenderer($content);
        echo '</table>';
    }

    public function renderTableHeader($cols) {
        echo '<tr>';
        foreach ($cols as $col) {
            self::renderHeaderColumn($col, function($col) {
                echo $col;
            });
        }
        echo'</tr>';
    }

    public function renderTableRow($content = null, $contentRenderer = null) {
        echo '<tr>';
        if ($contentRenderer) $contentRenderer($content);
        echo '</tr>';
    }

    public function renderTableData($content, $contentRenderer = null) {
        echo '<td>';
        if ($contentRenderer) $contentRenderer($content);
        echo '</td>';
    }

    //////////////////////////////////////////////////////////////////////////

    private function renderHeaderColumn($content, $contentRenderer = null) {
        echo '<th',
        self::prepareAttribute('scope', 'col'),
        '>';
        if ($contentRenderer) $contentRenderer($content);
        echo '</th>';
    }
}
?>