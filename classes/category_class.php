<?php

require_once '../settings/db_class.php';

/**
 * Category class for handling category operations
 */
class Category extends db_connection
{
    private $cat_id;
    private $cat_name;

    public function __construct($cat_id = null)
    {
        parent::db_connect();
        if ($cat_id) {
            $this->cat_id = $cat_id;
            $this->loadCategory();
        }
    }

    /**
     * Load category data by category ID
     */
    private function loadCategory($cat_id = null)
    {
        if ($cat_id) {
            $this->cat_id = $cat_id;
        }
        if (!$this->cat_id) {
            return false;
        }
        
        $sql = "SELECT * FROM categories WHERE cat_id = $this->cat_id";
        $result = $this->db_fetch_one($sql);
        
        if ($result) {
            $this->cat_id = $result['cat_id'];
            $this->cat_name = $result['cat_name'];
            return true;
        }
        return false;
    }

    /**
     * Get all categories
     * @return array|false - All categories if successful, false otherwise
     */
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories ORDER BY cat_name";
        return $this->db_fetch_all($sql);
    }

    /**
     * Get category by ID
     * @param int $cat_id - Category ID
     * @return array|false - Category data if found, false otherwise
     */
    public function getCategoryById($cat_id)
    {
        $cat_id = mysqli_real_escape_string($this->db, $cat_id);
        $sql = "SELECT * FROM categories WHERE cat_id = $cat_id";
        return $this->db_fetch_one($sql);
    }

    /**
     * Get category by name
     * @param string $cat_name - Category name
     * @return array|false - Category data if found, false otherwise
     */
    public function getCategoryByName($cat_name)
    {
        $cat_name = mysqli_real_escape_string($this->db, $cat_name);
        $sql = "SELECT * FROM categories WHERE cat_name = '$cat_name'";
        return $this->db_fetch_one($sql);
    }

    /**
     * Create a new category
     * @param string $cat_name - Category name
     * @return int|false - Category ID if successful, false otherwise
     */
    public function createCategory($cat_name)
    {
        // Check if category already exists
        if ($this->getCategoryByName($cat_name)) {
            return false; // Category already exists
        }
        
        // Sanitize input
        $cat_name = mysqli_real_escape_string($this->db, $cat_name);
        
        $sql = "INSERT INTO categories (cat_name) VALUES ('$cat_name')";
        
        if ($this->db_write_query($sql)) {
            return $this->last_insert_id();
        }
        return false;
    }

    /**
     * Update category information
     * @param int $cat_id - Category ID
     * @param string $cat_name - Updated category name
     * @return bool - True if successful, false otherwise
     */
    public function updateCategory($cat_id, $cat_name)
    {
        // Check if another category with the same name exists
        $existing = $this->getCategoryByName($cat_name);
        if ($existing && $existing['cat_id'] != $cat_id) {
            return false; // Another category with this name already exists
        }
        
        // Sanitize inputs
        $cat_id = mysqli_real_escape_string($this->db, $cat_id);
        $cat_name = mysqli_real_escape_string($this->db, $cat_name);
        
        $sql = "UPDATE categories SET cat_name = '$cat_name' WHERE cat_id = $cat_id";
        return $this->db_write_query($sql);
    }

    /**
     * Delete category
     * @param int $cat_id - Category ID
     * @return bool - True if successful, false otherwise
     */
    public function deleteCategory($cat_id)
    {
        $cat_id = mysqli_real_escape_string($this->db, $cat_id);
        $sql = "DELETE FROM categories WHERE cat_id = $cat_id";
        return $this->db_write_query($sql);
    }

    // Getter methods
    public function getCategoryId() { return $this->cat_id; }
    public function getCategoryName() { return $this->cat_name; }
}