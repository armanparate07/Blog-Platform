<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Model
 * Handles all database operations related to users
 */
class User_model extends CI_Model {

    /**
     * Register a new user
     * @param array $data User data (username, email, password, role)
     * @return bool
     */
    public function register($data)
    {
        // Hash the password
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        // Insert user into database
        return $this->db->insert('users', $data);
    }

    /**
     * Authenticate user login
     * @param string $email
     * @param string $password
     * @return object|bool User object if successful, false otherwise
     */
    public function login($email, $password)
    {
        // Query database for user with given email
        $this->db->where('email', $email);
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            $user = $query->row();

            // Verify password
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

    /**
     * Get user by ID
     * @param int $user_id
     * @return object|null
     */
    public function get_user_by_id($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            return $query->row();
        }

        return null;
    }

    /**
     * Check if email exists
     * @param string $email
     * @return bool
     */
    public function email_exists($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return ($query->num_rows() > 0);
    }

    /**
     * Check if username exists
     * @param string $username
     * @return bool
     */
    public function username_exists($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return ($query->num_rows() > 0);
    }
}
