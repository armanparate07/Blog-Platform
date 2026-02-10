<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function get_all_categories()
    {
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('categories');
        return $query->result();
    }

    public function get_category_by_id($category_id)
    {
        $this->db->where('id', $category_id);
        $query = $this->db->get('categories');

        if ($query->num_rows() == 1) {
            return $query->row();
        }

        return null;
    }

    public function create_category($data)
    {
        return $this->db->insert('categories', $data);
    }

    public function update_category($category_id, $data)
    {
        $this->db->where('id', $category_id);
        return $this->db->update('categories', $data);
    }

    public function delete_category($category_id)
    {
        $this->db->where('id', $category_id);
        return $this->db->delete('categories');
    }

    public function get_categories_with_count()
    {
        $this->db->select('categories.*, COUNT(posts.id) as post_count');
        $this->db->from('categories');
        $this->db->join('posts', 'posts.category_id = categories.id', 'left');
        $this->db->group_by('categories.id');
        $this->db->order_by('categories.name', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
}