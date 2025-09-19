<?php

require_once '../settings/db_class.php';

/**
 * Customer class for handling customer operations
 */
class Customer extends db_connection
{
    private $customer_id;
    private $customer_name;
    private $customer_email;
    private $customer_pass;
    private $customer_country;
    private $customer_city;
    private $customer_contact;
    private $customer_image;
    private $user_role;

    public function __construct($customer_id = null)
    {
        parent::db_connect();
        if ($customer_id) {
            $this->customer_id = $customer_id;
            $this->loadCustomer();
        }
    }

    /**
     * Load customer data by customer ID
     */
    private function loadCustomer($customer_id = null)
    {
        if ($customer_id) {
            $this->customer_id = $customer_id;
        }
        if (!$this->customer_id) {
            return false;
        }
        
        $sql = "SELECT * FROM customer WHERE customer_id = $this->customer_id";
        $result = $this->db_fetch_one($sql);
        
        if ($result) {
            $this->customer_name = $result['customer_name'];
            $this->customer_email = $result['customer_email'];
            $this->customer_pass = $result['customer_pass'];
            $this->customer_country = $result['customer_country'];
            $this->customer_city = $result['customer_city'];
            $this->customer_contact = $result['customer_contact'];
            $this->customer_image = $result['customer_image'];
            $this->user_role = $result['user_role'];
            return true;
        }
        return false;
    }

    /**
     * Get customer by email address with password verification
     * @param string $email - Customer email
     * @param string $password - Plain text password to verify
     * @return array|false - Customer data if login successful, false otherwise
     */
    public function getCustomerByEmail($email, $password = null)
    {
        // Sanitize email input
        $email = mysqli_real_escape_string($this->db, $email);
        
        $sql = "SELECT * FROM customer WHERE customer_email = '$email'";
        $result = $this->db_fetch_one($sql);
        
        if ($result && $password !== null) {
            // Verify password if provided
            if (password_verify($password, $result['customer_pass'])) {
                return $result;
            } else {
                return false;
            }
        } elseif ($result && $password === null) {
            // Return customer data without password verification
            return $result;
        }
        
        return false;
    }

    /**
     * Create a new customer
     * @param array $customer_data - Customer information
     * @return int|false - Customer ID if successful, false otherwise
     */
    public function createCustomer($customer_data)
    {
        // Hash the password
        $hashed_password = password_hash($customer_data['password'], PASSWORD_DEFAULT);
        
        // Sanitize inputs
        $name = mysqli_real_escape_string($this->db, $customer_data['name']);
        $email = mysqli_real_escape_string($this->db, $customer_data['email']);
        $country = mysqli_real_escape_string($this->db, $customer_data['country']);
        $city = mysqli_real_escape_string($this->db, $customer_data['city']);
        $contact = mysqli_real_escape_string($this->db, $customer_data['contact']);
        $role = isset($customer_data['role']) ? (int)$customer_data['role'] : 2; // Default role 2 for customer
        
        $sql = "INSERT INTO customer (customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, user_role) 
                VALUES ('$name', '$email', '$hashed_password', '$country', '$city', '$contact', $role)";
        
        if ($this->db_write_query($sql)) {
            return $this->last_insert_id();
        }
        return false;
    }

    /**
     * Update customer information
     * @param array $customer_data - Updated customer information
     * @return bool - True if successful, false otherwise
     */
    public function updateCustomer($customer_data)
    {
        if (!$this->customer_id) {
            return false;
        }
        
        $updates = array();
        
        if (isset($customer_data['name'])) {
            $name = mysqli_real_escape_string($this->db, $customer_data['name']);
            $updates[] = "customer_name = '$name'";
        }
        
        if (isset($customer_data['email'])) {
            $email = mysqli_real_escape_string($this->db, $customer_data['email']);
            $updates[] = "customer_email = '$email'";
        }
        
        if (isset($customer_data['password'])) {
            $hashed_password = password_hash($customer_data['password'], PASSWORD_DEFAULT);
            $updates[] = "customer_pass = '$hashed_password'";
        }
        
        if (isset($customer_data['country'])) {
            $country = mysqli_real_escape_string($this->db, $customer_data['country']);
            $updates[] = "customer_country = '$country'";
        }
        
        if (isset($customer_data['city'])) {
            $city = mysqli_real_escape_string($this->db, $customer_data['city']);
            $updates[] = "customer_city = '$city'";
        }
        
        if (isset($customer_data['contact'])) {
            $contact = mysqli_real_escape_string($this->db, $customer_data['contact']);
            $updates[] = "customer_contact = '$contact'";
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $sql = "UPDATE customer SET " . implode(', ', $updates) . " WHERE customer_id = $this->customer_id";
        return $this->db_write_query($sql);
    }

    /**
     * Validate customer login credentials
     * @param string $email - Customer email
     * @param string $password - Plain text password
     * @return array|false - Customer data if valid, false otherwise
     */
    public function validateLogin($email, $password)
    {
        return $this->getCustomerByEmail($email, $password);
    }

    // Getter methods
    public function getCustomerId() { return $this->customer_id; }
    public function getCustomerName() { return $this->customer_name; }
    public function getCustomerEmail() { return $this->customer_email; }
    public function getCustomerCountry() { return $this->customer_country; }
    public function getCustomerCity() { return $this->customer_city; }
    public function getCustomerContact() { return $this->customer_contact; }
    public function getCustomerImage() { return $this->customer_image; }
    public function getUserRole() { return $this->user_role; }
}