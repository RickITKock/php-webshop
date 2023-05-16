<?php

$items = Item::getItems();
$itemCardRenderer = new ItemCardRenderer();
$itemModalRenderer = new OptionsModalRenderer();
$linkRenderer = new LinkRenderer();

$isAdmin = false;
if (isset($_SESSION['user_info'])) {
    $user = unserialize($_SESSION['user_info']);
    if ($user->user_type == "admin") $isAdmin = true;
}


/*if ($isAdmin) {
    foreach($items as $item): ?>
        <div class="col-lg-12">
        <? $itemCardRenderer->renderForAdmin($item);?>
        </div>
        <?php $itemModalRenderer->renderItemInfoModal("info", $item); ?>
<? endforeach;
} else {*/
    

/*if ($isAdmin) {
    foreach($items as $item): ?>
        <div class="col-lg-12">
        <? $itemCardRenderer->renderForAdmin($item);?>
        </div>
        <?php $itemModalRenderer->renderItemInfoModal("info", $item); ?>
<? endforeach;
} else {*/
    foreach($items as $item) {
        echo '<div class="col-lg-4">';
        $itemCardRenderer->renderForUser($item);
        echo '</div>';
        $itemModalRenderer->renderItemInfoModal("info", $item);
    }
// }
    
?>

<script>
    function promptDeleteItem(id) {
        let confirmation = confirm("Are you sure?");        
        if (confirmation == true) {
            const form = document.createElement('form');
            form.method = "POST";
            form.action = "validations/process_resource.php";

            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = "id";
            hiddenField.value = id;
            form.appendChild(hiddenField);

            const deleteMessage = document.createElement('input');
            deleteMessage.name="btn_delete";
            deleteMessage.value = "delete";
            form.appendChild(deleteMessage);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>