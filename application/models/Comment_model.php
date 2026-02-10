<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends CI_Model {

    public function get_comments_by_post($post_id)
    {
        $this->db->select('comments.*, users.username');
        $this->db->from('comments');
        $this->db->join('users', 'users.id = comments.user_id', 'left');
        $this->db->where('comments.post_id', $post_id);
        $this->db->order_by('comments.created_at', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_comment_by_id($comment_id)
    {
        $this->db->select('comments.*, users.username');
        $this->db->from('comments');
        $this->db->join('users', 'users.id = comments.user_id', 'left');
        $this->db->where('comments.id', $comment_id);
        
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        }

        return null;
    }

    public function create_comment($data)
    {
        return $this->db->insert('comments', $data);
    }

    public function delete_comment($comment_id)
    {
        $this->db->where('id', $comment_id);
        return $this->db->delete('comments');
    }

    public function get_comments_by_user($user_id)
    {
        $this->db->select('comments.*, posts.title as post_title');
        $this->db->from('comments');
        $this->db->join('posts', 'posts.id = comments.post_id', 'left');
        $this->db->where('comments.user_id', $user_id);
        $this->db->order_by('comments.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_comment_count($post_id)
    {
        $this->db->where('post_id', $post_id);
        return $this->db->count_all_results('comments');
    }
}