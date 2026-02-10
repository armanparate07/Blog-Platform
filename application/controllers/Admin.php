<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Post_model');
        $this->load->model('User_model');
        
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Please login to continue');
            redirect('login');
        }
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Access denied! Admin only.');
            redirect('posts');
        }
    }

    public function index()
    {
        $content_data['total_posts']     = count($this->Post_model->get_all_posts());
        $content_data['pending_posts']   = count($this->Post_model->get_posts_by_status('pending'));
        $content_data['published_posts'] = count($this->Post_model->get_posts_by_status('published'));
        $content_data['draft_posts']     = count($this->Post_model->get_posts_by_status('draft'));
        $content_data['posts']           = $this->Post_model->get_all_posts();

        $data['page_title']   = 'Dashboard';
        $data['active_menu']  = 'dashboard';
        $data['content_view'] = 'admin/dashboard';
        $data['content_data'] = $content_data;
        $this->load->view('admin/layout', $data);
    }

    public function pending_posts()
    {
        $content_data['posts']     = $this->Post_model->get_posts_by_status('pending');
        $content_data['user_role'] = $this->session->userdata('role');
        $content_data['user_id']   = $this->session->userdata('user_id');

        $data['page_title']   = 'Pending Posts';
        $data['active_menu']  = 'dashboard';
        $data['content_view'] = 'admin/pending_posts';
        $data['content_data'] = $content_data;
        $this->load->view('admin/layout', $data);
    }

    public function approve_post($post_id)
    {
        $post = $this->Post_model->get_post_by_id($post_id);
        if (!$post) { $this->session->set_flashdata('error', 'Post not found'); redirect('admin'); }
        if ($this->Post_model->update_post($post_id, array('status' => 'published'))) {
            $this->session->set_flashdata('success', 'Post approved and published!');
        } else {
            $this->session->set_flashdata('error', 'Failed to approve post');
        }
        redirect('admin');
    }

    public function reject_post($post_id)
    {
        $post = $this->Post_model->get_post_by_id($post_id);
        if (!$post) { $this->session->set_flashdata('error', 'Post not found'); redirect('admin'); }
        if ($this->Post_model->update_post($post_id, array('status' => 'draft'))) {
            $this->session->set_flashdata('success', 'Post rejected and moved to draft');
        } else {
            $this->session->set_flashdata('error', 'Failed to reject post');
        }
        redirect('admin');
    }

    public function delete_post($post_id)
    {
        $post = $this->Post_model->get_post_by_id($post_id);
        if (!$post) { $this->session->set_flashdata('error', 'Post not found'); redirect('admin'); }
        if ($this->Post_model->delete_post($post_id)) {
            $this->session->set_flashdata('success', 'Post deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete post');
        }
        redirect('admin');
    }
}
