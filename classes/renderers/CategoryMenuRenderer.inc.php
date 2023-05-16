<?php

class CategoryMenuRenderer extends Renderer {
    private $mainMenu;
    private $buffer;

    public function __construct($menuName) {
        $this->mainMenu = new MenuRenderer($menuName);
        $this->mainMenu->isMainMenu = true;
        $this->buffer = array();
    }

    public function addItem($parent, $menuItemOrMenu) {
        $parentObject = $this->getParent($parent, $this->buffer);
        if ($parentObject == null) $this->buffer[$parent] = array();
        array_push($this->buffer[$parent], $menuItemOrMenu);
    }

    // It is assumed that the category string is selected when using the onclick method
    public function build($onclick = null) {
        $mainMenuItems = $this->buffer[(string) $this->mainMenu];
        foreach ($mainMenuItems as $item) {
        $this->mainMenu->addItem($this->constructMenu($item, $this->buffer, $onclick));
        }
    }

    private function constructMenu($parent, $arr, $onclick=null) {
        $children = $this->getParent($parent, $arr);
        $menuItemType = null;
        if ($children != null) {
            $menuItemType = new MenuRenderer($parent);
            foreach ($children as $par)
                $menuItemType->addItem($this->constructMenu($par, $this->buffer, $onclick));
        } else { $menuItemType = new MenuItemRenderer($parent);}
        $menuItemType->attachOnclickMethod($onclick);
        return $menuItemType;
    }

    public function getParent($parent, $arr) {
        return (array_key_exists($parent, $arr) ? $arr[$parent] : null);
    }

    public function display() { $this->mainMenu->display();}
}

Class MenuRenderer {
    private $mainMenuItem;
    private $menuItems;
    private $isMainMenu;
  
    public function __construct($menuName, $menuItems = null) {
      $this->mainMenuItem = new MenuItemRenderer($menuName);
      $this->menuItems = ($menuItems == null) ? array() : $menuItems;
    }
  
    public function __set($name, $value) {
      $this->$name = $value;
    }
  
    public function __get($name) {
      return $this->$name;
    }
  
    public function attachOnclickMethod($onclick) {
      $this->mainMenuItem->attachOnclickMethod($onclick);
    }
  
    public function addItem($menuItem) {
      array_push($this->menuItems, $menuItem);
    }
  
    public function display() {
      if (!$this->isMainMenu) {
        $this->mainMenuItem->display();
        echo '<ul>';
        foreach ($this->menuItems as $item) {
          $item->display();
        }
        echo "</ul>";
      } else {
        echo "<ul>";
        foreach ($this->menuItems as $item) {
          $item->display();
        }
        echo "</ul>";
      }
    }
  
    public function isEmpty() {
      return count($this->menuItems) == 0;
    }
  
    public function __toString() {
      return (string) $this->mainMenuItem;
    }
}


class MenuItemRenderer {
    private $category;
    private $onclickAction;
    private $buttonRenderer;
  
    public function __construct($category) {
        $this->buttonRenderer = new ButtonRenderer();
        $this->category = $category;
    }
    
    public function __set($name, $value) { $this->$name = $value;}
    public function __get($name) {return $this->$name;}
    public function __toString() { return $this->category;}
  
    public function attachOnclickMethod($onclick) { $this->onclickAction = $onclick; }
  
    public function display() {
        $this->buttonRenderer->renderButton(
            array(
                'name' => $this->category,
                'type' => "button",
                'class' => "btn btn-outline-info shadow btn-sm px-5",
                // 'style' => "background-color: white;",
                'onclick' => $this->onclickAction."(event)",
            ), function() { echo $this->category;}
        );
        echo "<br />";
    }
}

?>