<div class="card border-info" style="background: none;">
  <div class="card-header bg-info"><h5>Categories</h5></div>
  <div class="card-body" style="height: 100%; overflow: auto;">
    <?php
      $categoryMenu = new CategoryMenuRenderer("Categories");
      $categories = Category::getCategories();
      $categoryMenu->addItem("Categories", "All");
      foreach ($categories as $cat) {
        if ($cat->parent == null) {
          $categoryMenu->addItem("Categories", $cat->category);
          continue;
        }
        $categoryMenu->addItem($cat->parent, $cat->category);
      }
      $categoryMenu->build("showItemsByCategory");
      $categoryMenu->display();
    ?>
  </div>
  
  <div class="card-footer bg-info border-info">
      <?php 
      $isAdmin = false;
      if (isset($_SESSION['user_info'])) {
          $user = unserialize($_SESSION['user_info']);
          if ($user->user_type == "admin") $isAdmin = true;
      }
      if ($isAdmin) {
          $categoryModalRenderer = new OptionsModalRenderer();
          $buttonRenderer = new ButtonRenderer();
          echo '<div class="btn-group d-flex" role="group" aria-label="Basic example">';
          $buttonRenderer->renderButton(
              array(
                  'type' => "button",
                  'class' => "btn border flex-fill",
                  'style' => "background-color: white;",
                  'data-toggle' => "modal",
                  'data-target' => "#addNewCategoryModal",
              ), function() { echo "Create new category";}
          );
          $buttonRenderer->renderButton(
              array(
                  'type' => "button",
                  'class' => "btn border flex-fill",
                  'style' => "background-color: white;",
                  'data-toggle' => "modal",
                  'data-target' => "#updateCategoryModal",
              ), function() { echo "Update";}
          );
          $buttonRenderer->renderButton(
              array(
                  'type' => "button",
                  'class' => "btn border flex-fill",
                  'style' => "background-color: white;",
                  'data-toggle' => "modal",
                  'data-target' => "#deleteCategoryModal",
              ), function() { echo "Delete";}
          );
          echo '</div>';
          $categoryModalRenderer->renderCreateNewCategoryModal("addNewCategoryModal");
          $categoryModalRenderer->renderUpdateCategoryModal("updateCategoryModal");
          $categoryModalRenderer->renderDeleteCategoryModal("deleteCategoryModal");
      }
      ?>                        
  </div>
</div>

<script>
  function setCategoryParentInInput(event) {
    let categoryInput = document.getElementById('categoryParent_create');
    categoryInput.value = event.target.innerHTML;
  }

  function chooseCategoryToDelete(event) {
    let categoryInput = document.getElementById('category_to_delete');
    categoryInput.value = event.target.innerHTML;
  }

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
      enableInput(parentInput);
  }

  function promptDeleteCategory() {
    let confirmation = confirm("Are you sure?");
    let form = document.getElementById('deleteCategoryForm');
    if (confirmation) {
      let input = document.getElementById('category_to_delete');
      input.name = "category_to_delete";
      form.appendChild(input);
      form.submit();
    }
  }
</script>

