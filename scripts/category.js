function setCategoryParentInInput(event) {
    let categoryInput = document.getElementById('categoryParent_create');
    categoryInput.value = event.target.innerHTML;
}

// TODO: Check to see if the parent set is no the child of the category
function setCategoryToUpdate(event) {
    setCategoryParent(event.target.innerHTML);
    let categoryInput = document.getElementById("categoryToUpdate");
    let previousCategoryNameInput =  document.getElementById("previous_category_name");
    document.getElementById("categoryToUpdate").readOnly = false;
    document.getElementById("parent").disabled = false;
    let parentInput = document.getElementById("parent");
    categoryInput.value = event.target.innerHTML;
    previousCategoryNameInput.value = event.target.innerHTML;
    let categoryValue = categoryInput.value;

    // TODO: Consideration - should I remove the line above?
    enableInput(parentInput);
}

function chooseCategoryToDelete(event) {
    let categoryInput = document.getElementById('category_to_delete');
    categoryInput.value = event.target.innerHTML;
}

function promptDeleteCategory() {
    let confirmation = confirm("Are you sure?");
    let form = document.getElementById('deleteCategoryForm');
    if (confirmation)
        form.submit();
}