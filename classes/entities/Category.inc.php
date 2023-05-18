<?php
    class Category extends SqlDataBaseConnection {
        private $id;
        private $category;
        private $parent;

        public function __construct($id, $category, $parent) {
            $this->id = $id;
            $this->category = $category;
            $this->parent = $parent;
        }

        public function __set($name, $value) {
            $this->$name = $value;
        }

        public function __get($name) {
            return $this->$name;
        }

        public function __toString() {
            $output = "Category: " . $this->category . "<br>\n";
            return $output;
        }

        function saveCategory() {
            $conn = self::connectWithDataBase();
            $query = "INSERT INTO categories (category) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $this->category);
            $result = $stmt->execute();
            $conn->close();
            return $result;
        }

        function createCategory($category, $parent) {
            $conn = self::connectWithDataBase();
            $query = "INSERT INTO categories (category, parent) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $category, $parent);
            $result = $stmt->execute();
            $conn->close();
            return $result;
        }

        function updateCategory($previousCategoryName, $category, $parent) {
            $conn = self::connectWithDataBase();
            $query = "UPDATE categories SET category = ?, parent = ? WHERE category = ?";
            $stmt = $conn->prepare($query);            
            $stmt->bind_param("sss", $category, $parent, $previousCategoryName);
            $result = $stmt->execute();
            $conn->close();
            return $result;
        }

        function isPrecededBy($category, $precedent) {
            $conn = self::connectWithDataBase();
            $query = "SELECT * FROM categories";
            $result = $conn->query($query);
            $categories = array();
            $child = null;
            if (mysqli_num_rows($result) > 0) {
                while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $categoryCreated = new Category($row['id'], $row['category'], $row['parent']);
                    $categories[$categoryCreated->category] = $categoryCreated; 
                    unset($categoryCreated);
                }
                $conn->close();
            } else {
                $conn->close();
            }
            if (count($categories) < 1) return false;
            if (array_key_exists($category, $categories)) $child = $categories[$category];
            $nextParent = $child->parent;

            if (is_null($nextParent)) return false;
            while ($nextParent != $precedent) {
                $nextParent = $categories[$nextParent]->parent;
                if (is_null($nextParent)) {
                    return false;   // Child is NOT related to precedent.
                }
                echo $nextParent."<br />";
            }
            return true; // Child is related to precedent.
        }

        static function deleteCategory($category) {
            $conn = self::connectWithDataBase();
            $query = "DELETE FROM categories WHERE category = '$category';";
            $query .= "UPDATE categories set parent = null WHERE parent = '$category'";
            if ($conn->multi_query($query)) {
                do {
                    if ($result = $conn->store_result()) {
                        while ($row = $result->fetch_row())
                            printf("%s\n", $row[0]);
                        $result->free();
                    } 
                } while ($conn->next_result());
            } $conn->close();
        }

        // TODO: Implement a method that could delete all the children
        // of a particular parent
        static function deleteChildrenOf($parent) {}

        static function childrenCount($parent) {
            $conn = self::connectWithDataBase();
            $query = "SELECT COUNT(*) as childrenCount FROM categories WHERE parent = '$parent'";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            $conn->close();
            return $row['childrenCount'];
        }

        // TODO: Change the following function to push items using their category as key
        static function getCategories() {
            $conn = self::connectWithDataBase();
            $query = "SELECT * FROM categories";
            $result = $conn->query($query);
            if (mysqli_num_rows($result) > 0) {
                $categories = array();
                while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $category = new Category($row['id'], $row['category'], $row['parent']);
                    array_push($categories, $category);
                    unset($category);
                }
                $conn->close();
                return $categories;
            } else {
                $conn->close();
                return NULL;
            }
        }

        static function getCategoryParent($category) {
            $conn = self::connectWithDataBase();
            $query = "SELECT parent FROM categories WHERE category = '$category'";
            $result = $conn->query($query);
            $parent = $result->fetch_object()->parent;
            if ($parent != null) {
                $conn->close();
                return $parent;
            } else {
                $conn->close();
                return NULL;
            }           
        }

        static function findCategory($categoryId) {
            $conn = self::connectWithDataBase();
            $query = "SELECT * FROM categories WHERE id = $categoryId";
            $result = $conn->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row) {
                $category = new Category($row['id'], $row['category'], $row['parent']);
                $conn->close();
                return $category;
            } else {
                $conn->close();
                return NULL;
            }
        }

        static function findCategoryByCategory($category) {
            $conn = self::connectWithDataBase();
            $query = "SELECT * FROM categories WHERE category = '$category'";
            $result = $conn->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row) {
                $category = new Category($row['id'], $row['category'], $row['parent']);
                $conn->close();
                return $category;
            } else {
                $conn->close();
                return NULL;
            }
        }
    }
?>