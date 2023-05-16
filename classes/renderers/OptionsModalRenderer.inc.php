<?php


spl_autoload_register(function($class) {
    $sources = array(
        "classes/renderers/base/$class.inc.php"
    );
    foreach ($sources as $source) { if (file_exists($source)) { require_once $source; } }
});

class OptionsModalRenderer extends Renderer {
    private $buttonRenderer;
    private $modalRenderer;
    private $formRenderer;

    public function __construct() {
        $this->modalRenderer = new ModalRenderer();
        $this->buttonRenderer = new ButtonRenderer();
        $this->formRenderer = new FormRenderer();
    }

    public function renderCloseButton() {
        $this->buttonRenderer->renderButton(
            array(
                'type' => "button",
                'class' => "btn border",
                'style' => "background-color: white;",
                'data-dismiss' => "modal",
            ), function() { echo "close";}
        );
    }

    public function renderTitle($title) {
        echo '<h5 class="modal-title" id="modal-title">'.$title.'</h5>';
    }

    public function renderItemInfoModal($prepend, $item) {
        $this->modalRenderer->renderModal($prepend.$item->name.$item->id, $item, function($item) {
            $this->modalRenderer->renderModalContent($item, function($item) {
                $this->modalRenderer->renderModalHeader($item, function($item) {
                    self::renderTitle($item->name);
                });
                $this->modalRenderer->renderModalBody($item, function($item) {
                    echo $item->description;
                });
                $this->modalRenderer->renderModalFooter($item, function($item) {
                    self::renderCloseButton();
                });
            });
        });
    }

    private function renderCategoryMenu($onclickAction = null) {
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
        $categoryMenu->build($onclickAction);
        $categoryMenu->display();
    }

    public function renderCreateNewCategoryModal($modalId) {
        $this->modalRenderer->renderModal($modalId, null, function() {
            $this->modalRenderer->renderModalContent(null, function() {
                $this->modalRenderer->renderModalHeader(null, function() {
                    self::renderTitle("Create new category");
                });
                $this->modalRenderer->renderModalBody(null, function() {
                    echo '<div class="rounded p-2 mb-3" style="height: 300px; overflow: auto;">';
                    $this->renderCategoryMenu("setCategoryParentInInput");
                    echo '</div>';
                    echo '<form method="POST" id="createCategoryForm" action="validations/category_form_validation.php">';
                    echo '<label>Parent</label>';
                    echo '<input class="form-control" type="text" placeholder="Category parent" name="category_parent" id="categoryParent_create" readonly="readonly">';
                    echo '<input class="form-control" type="text" placeholder="New Category" name="new_category" required>';
                    echo '</form>';
                });
                $this->modalRenderer->renderModalFooter(null, function() {
                    $this->buttonRenderer->renderButton(
                        array(
                            'form' => "createCategoryForm",
                            'type' => "submit",
                            'class' => "btn border",
                            'style' => "background-color: white;",
                            'name' => "btn_mutate",
                        ), 
                        function() { echo "Create";}
                    );
                    self::renderCloseButton();
                });
            });
        });
    }

    public function renderUpdateCategoryModal($modalId) {
        $this->modalRenderer->renderModal($modalId, null, function() {
            $this->modalRenderer->renderModalContent(null, function() {
                $this->modalRenderer->renderModalHeader(null, function() {
                    self::renderTitle("Update category");
                });
                $this->modalRenderer->renderModalBody(null, function() {
                    echo '<div class="rounded p-2 mb-3" style="height: 300px; overflow: auto;">';
                    $this->renderCategoryMenu("setCategoryToUpdate");
                    echo '</div>';

                    echo '<form method="POST" id="updateCategoryForm" action="validations/category_form_validation.php">';
                    echo '<input id="previous_category_name" name="previous_category_name" type=text hidden />';

                    echo '<label>Parent</label>';
                    echo '<select class="form-control" name="parent" id="parent" disabled>';
                        $categories = Category::getCategories();
                        echo '<option value ="No parent">No Parent</option>';
                        foreach($categories as $category) {
                            echo '<option value ="'.$category->category.'">'.$category->category.'</option>';
                        }
                    echo '</select>';

                    $this->formRenderer->renderInput(array(
                        'id' => "categoryToUpdate",
                        'name' => "category",
                        'type' => "text",
                        'class' => "form-control",
                        'placeholder' => "Category",
                        'readonly' => "readonly",
                    ));
                    echo '</form>';
                });
                $this->modalRenderer->renderModalFooter(null, function() {
                    $this->buttonRenderer->renderButton(
                        array(
                            'form' => "updateCategoryForm",
                            'type' => "submit",
                            'class' => "btn border",
                            'style' => "background-color: white;",
                            'name' => "btn_update",
                        ), 
                        function() { echo "Update";}
                    );
                    self::renderCloseButton();
                });
            });
        });
    }

    public function renderDeleteCategoryModal($modalId) {
        $this->modalRenderer->renderModal($modalId, null, function() {
            $this->modalRenderer->renderModalContent(null, function() {
                $this->modalRenderer->renderModalHeader(null, function() {
                    self::renderTitle("Delete category");
                });
                $this->modalRenderer->renderModalBody(null, function() {
                    echo '<div class="rounded p-2 mb-3" style="height: 300px; overflow: auto;">';
                    $this->renderCategoryMenu("chooseCategoryToDelete");
                    echo '</div>';

                    echo '<form method="POST" id="deleteCategoryForm" action="validations/category_form_validation.php">';
                    $this->formRenderer->renderInput(array(
                        'id' => "category_to_delete",
                        'name' => "category_to_delete",
                        'type' => "text",
                        'class' => "form-control",
                        'placeholder' => "Category",
                        'readonly' => "readonly",
                    ));
                    echo '</form>';
                });
                $this->modalRenderer->renderModalFooter(null, function() {
                    // <button type="button" class="btn btn-outline-danger" name="btn_delete" onclick="promptDeleteCategory()">Delete</button>
                    $this->buttonRenderer->renderButton(
                        array(
                            'type' => "button",
                            'class' => "btn border",
                            'style' => "background-color: white;",
                            'name' => "btn_delete",
                            'onclick' => "promptDeleteCategory()",
                        ), 
                        function() { echo "Delete";}
                    );
                    self::renderCloseButton();
                });
            });
        });
    }

    public function renderLoginModal($modalId) {
        $this->modalRenderer->renderModal($modalId, null, function() {
            $this->modalRenderer->renderModalContent(null, function() {
                $this->modalRenderer->renderModalHeader(null, function() {
                    self::renderTitle("Login");
                });
                $this->modalRenderer->renderModalBody(null, function() {
                    echo '<form id=loginForm action="validations/login_validation.php" method="POST">';
                    echo '<div class="form-group">';
                    $this->formRenderer->renderInput(array(
                        'name' => "email",
                        'type' => "email",
                        'class' => "form-control",
                        'placeholder' => "Email",
                    ));
                    echo '</div>';
                    echo '<div class="form-group">';
                    $this->formRenderer->renderInput(array(
                        'name' => "password",
                        'type' => "password",
                        'class' => "form-control",
                        'placeholder' => "Password",
                    ));
                    echo '</div>';
                    echo '</form>';
                });
                $this->modalRenderer->renderModalFooter(null, function() {
                    $this->buttonRenderer->renderButton(
                        array(
                            'form' => "loginForm",
                            'type' => "submit",
                            'class' => "btn border",
                            'style' => "background-color: white;",
                            'name' => 'btn_login',
                        ), 
                        function() { echo "Login";}
                    );
                    self::renderCloseButton();
                });
            });
        });
    }

    public function renderSignUpModal($modalId) {
        $this->modalRenderer->renderModal($modalId, null, function() {
            $this->modalRenderer->renderModalContent(null, function() {
                $this->modalRenderer->renderModalHeader(null, function() {
                    self::renderTitle("Sign up");
                });
                $this->modalRenderer->renderModalBody(null, function() {
                    echo '<form id=signUpForm action="validations/login_validation.php" method="POST">';
                    echo '<div class="form-group">';
                    $this->formRenderer->renderInput(array(
                        'name' => "email",
                        'type' => "email",
                        'class' => "form-control",
                        'placeholder' => "Email",
                    ));
                    echo '</div>';
                    echo '<div class="form-group">';
                    $this->formRenderer->renderInput(array(
                        'name' => "password",
                        'type' => "password",
                        'class' => "form-control",
                        'placeholder' => "password",
                    ));
                    echo '</div>';
                    echo '<div class="form-group">';
                    $this->formRenderer->renderInput(array(
                        'name' => "secondPassword",
                        'type' => "password",
                        'class' => "form-control",
                        'placeholder' => "Re-enter password",
                    ));
                    echo '</div>';
                    echo '</form>';
                });
                $this->modalRenderer->renderModalFooter(null, function() {
                    $this->buttonRenderer->renderButton(
                        array(
                            'form' => "signUpForm",
                            'type' => "submit",
                            'class' => "btn border",
                            'style' => "background-color: white;",
                            'name' => 'btn_signUp',
                        ), 
                        function() { echo "Sign up";}
                    );
                    self::renderCloseButton();
                });
            });
        });
    }
    
    public function renderItemUpdateModal($prepend, $item) {
        $this->modalRenderer->renderModal("updateModal", null, function() {
            $this->modalRenderer->renderLargeModalContent(null, function() {
                $this->modalRenderer->renderModalHeader(null, function() {
                    self::renderTitle("Update");
                });
                $this->modalRenderer->renderModalBody(null, function() {
                    $this->formRenderer->renderForm(array(
                        "method" => "POST",
                        "name" => "mutateResourceForm",
                        "id" => "mutateResourceForm",
                        "action" => "validations/process_resource.php",
                    ), null, function() {
                        echo "<input type='number' name='id' hidden />";
                        echo "<div class='form-group'>";
                        $this->formRenderer->renderInput(array(
                            'type' => "text",
                            'name' => "name",
                            'class' => "form-control",
                            'placeholder' => "Name",
                        ));
                        echo "</div>";
                        echo "<div class='form-group'>";
                        $this->formRenderer->renderInput(array(
                            'type' => "text",
                            'name' => "category_id",
                            'class' => "form-control",
                            'placeholder' => "Category",
                        ));
                        echo "</div>";
                        echo "<div class='form-group form-check'>";
                        $this->formRenderer->renderInput(array(
                            'type' => "checkbox",
                            'class' => "form-check-input",
                            'name' => "is_sale",
                        ));
                        echo "<label>Sale</label>";
                        echo "</div>";

                        echo "<div class='form-group'>";
                        $this->formRenderer->renderInput(array(
                            'type' => "number",
                            'name' => "stock",
                            'class' => "form-control",
                            'placeholder' => "Stock",
                        ));
                        echo "</div>";

                        echo "<div class='form-group'>";
                        $this->formRenderer->renderInput(array(
                            'type' => "number",
                            'name' => "price",
                            'class' => "form-control",
                            'placeholder' => "Price",
                        ));
                        echo "</div>";

                        echo "<div class='form-group'>";
                        $this->formRenderer->renderTextArea(array(
                            'name' => "description",
                            'class' => "form-control",
                            'placeholder' => "Description",
                            'rows' => 5,
                        ), null);
                        echo "</div>";
                    });
                });
                $this->modalRenderer->renderModalFooter(null, function() {
                    echo '<div class="btn-group float-right">';
                    $this->buttonRenderer->renderButton(
                        array(
                            'type' => "submit",
                            'class' => "btn border",
                            'style' => "background-color: white;",
                            'name' => 'btn_update',
                        ), 
                        function() { echo "update";}
                    );
                    self::renderCloseButton();
                    echo "</div>";
                });
            });
        });
    } 
}

?>