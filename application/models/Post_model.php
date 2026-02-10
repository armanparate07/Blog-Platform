<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

    // ─── EXISTING METHODS (unchanged) ───

    public function get_all_posts()
    {
        $this->db->select('posts.*, users.username, categories.name as category_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.user_id', 'left');
        $this->db->join('categories', 'categories.id = posts.category_id', 'left');
        $this->db->order_by('posts.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_post_by_id($post_id)
    {
        $this->db->select('posts.*, users.username, categories.name as category_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.user_id', 'left');
        $this->db->join('categories', 'categories.id = posts.category_id', 'left');
        $this->db->where('posts.id', $post_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return null;
    }

    public function create_post($data)
    {
        $data['slug'] = url_title($data['title'], 'dash', TRUE);
        return $this->db->insert('posts', $data);
    }

    public function update_post($post_id, $data)
    {
        $data['slug'] = url_title($data['title'], 'dash', TRUE);
        $this->db->where('id', $post_id);
        return $this->db->update('posts', $data);
    }

    public function delete_post($post_id)
    {
        $this->db->where('id', $post_id);
        return $this->db->delete('posts');
    }

    public function get_categories()
    {
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('categories');
        return $query->result();
    }

    public function get_posts_by_user($user_id)
    {
        $this->db->select('posts.*, categories.name as category_name');
        $this->db->from('posts');
        $this->db->join('categories', 'categories.id = posts.category_id', 'left');
        $this->db->where('posts.user_id', $user_id);
        $this->db->order_by('posts.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_posts_by_category($category_id)
    {
        $this->db->select('posts.*, users.username');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.user_id', 'left');
        $this->db->where('posts.category_id', $category_id);
        $this->db->order_by('posts.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_posts_by_status($status)
    {
        $this->db->select('posts.*, users.username, categories.name as category_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.user_id', 'left');
        $this->db->join('categories', 'categories.id = posts.category_id', 'left');
        $this->db->where('posts.status', $status);
        $this->db->order_by('posts.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // ─── NEW: PAGINATION METHODS ───

    /**
     * Count all posts (for pagination total_rows)
     * @return int
     */
    public function count_all_posts()
    {
        return $this->db->count_all('posts');
    }

    /**
     * Get paginated posts with user and category info
     * @param int $limit  Posts per page (default 10)
     * @param int $offset Starting row
     * @return array
     */
    public function get_paginated_posts($limit, $offset)
    {
        $this->db->select('posts.*, users.username, categories.name as category_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.user_id', 'left');
        $this->db->join('categories', 'categories.id = posts.category_id', 'left');
        $this->db->order_by('posts.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
}
