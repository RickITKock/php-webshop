<?php
spl_autoload_register(function($class) {
    include "../classes/entities/$class.inc.php";
});

if (isset($_POST['btn_mutate'])) {
    $categoryParent = $_POST['category_parent'];
    $newCategory = $_POST['new_category'];

    // Allthough we want to check forms in javascript,
    // we want to make sure the necessary form inputs are set.
    if ($newCategory == null || $categoryParent == null || $newCategory == $categoryParent) {
        header("Location: ../index.php");
    }

    echo $categoryParent."<br />";
    echo $newCategory."<br />";

    if ($categoryParent == "No parent") {
        $categoryParent = null;
    }
    Category::createCategory($newCategory, $categoryParent);
} else if (isset($_POST['btn_update'])) {
    $previousCategoryName = isset($_POST['previous_category_name']) ? $_POST['previous_category_name'] : null;
    $category = isset($_POST['category']) ? $_POST['category'] : null;
    $parent = isset($_POST['parent']) ? $_POST['parent'] : null;


    if ($category == null ) {
        echo "No category selected to update.<br />";
    } else {
        echo "Category selected to update: $category.<br />";
    }
    if ($parent == null ) {
        echo "No category selected to update.<br />";
    } else {
        echo "Parent selected: $parent.<br />";
    }
    if ($previousCategoryName == null ) {
        echo "No previous category selected to update.<br />";
    } else {
        echo "Previous category selected to update: $previousCategoryName.<br />";
    }

    if ($parent == "No parent") $parent = null;

    echo "<br />";
    echo "Checking to see if parent is not child at the same time...";
    echo "<br />";


    // Logically, the parent category would be the precedent.
    // BUT we want to know if the parent of the updated category will also be the child
    // after the update has taken place. We want to avoid this of course.
    // Therefor, we must check the logic before proceeding.
    $parentIsChildOfParent  = Category::isPrecededBy($parent, $previousCategoryName);
    if ($parentIsChildOfParent) {
        echo "The parent will also be child of the category.<br />"; // Unfavorable!
    } else {
        echo "The parent will NOT be child of the category.<br />";
        if ($parent != $category) {
            Category::updateCategory($previousCategoryName, $category, $parent);
        } else {
            echo "Category cannot be the same as the parent!";
        }
    }
    echo "<br />";

} else if (isset($_POST['category_to_delete'])) {
    $categoryToDelete = $_POST['category_to_delete'];
    echo "Pressed delete button and the category to delete is: $categoryToDelete <br />";
    echo "Now attempting to delete category... <br />";
    Category::deleteCategory($categoryToDelete);
    echo "Did it work? <br />";
}

header("Location: ../index.php");

?>