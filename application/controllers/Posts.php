<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Posts Controller
 * Handles CRUD operations for blog posts
 * UPDATED: Pagination added, Admin posts auto-publish, user posts need approval
 */
class Posts extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Post_model');
        $this->load->model('Comment_model');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Please login to continue');
            redirect('login');  
        }
    }

    /**
     * Display all posts with pagination
     */
    public function index()
    {
        // Load pagination library
        $this->load->library('pagination');

        $config = array();
        $config['base_url']       = site_url('posts/index');
        $config['total_rows']     = $this->Post_model->count_all_posts();
        $config['per_page']       = 3;
        $config['uri_segment']    = 3;

        // Bootstrap 5 styled pagination
        $config['full_tag_open']   = '<nav aria-label="Posts pagination"><ul class="pagination justify-content-center mt-4">';
        $config['full_tag_close']  = '</ul></nav>';
        $config['first_link']      = '&laquo; First';
        $config['first_tag_open']  = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link']       = 'Last &raquo;';
        $config['last_tag_open']   = '<li class="page-item">';
        $config['last_tag_close']  = '</li>';
        $config['next_link']       = '&raquo;';
        $config['next_tag_open']   = '<li class="page-item">';
        $config['next_tag_close']  = '</li>';
        $config['prev_link']       = '&laquo;';
        $config['prev_tag_open']   = '<li class="page-item">';
        $config['prev_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li class="page-item">';
        $config['num_tag_close']   = '</li>';
        $config['attributes']      = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $content_data['posts']      = $this->Post_model->get_paginated_posts($config['per_page'], $page);
        $content_data['pagination'] = $this->pagination->create_links();
        $content_data['user_role']  = $this->session->userdata('role');
        $content_data['user_id']    = $this->session->userdata('user_id');

        $data['page_title']   = 'All Posts';
        $data['active_menu']  = 'posts';
        $data['content_view'] = 'posts/list';
        $data['content_data'] = $content_data;
        $this->load->view('admin/layout', $data);
    }

    /**
     * View single post with comments
     */
    public function view($post_id)
    {
        $post = $this->Post_model->get_post_by_id($post_id);

        if (!$post) {
            $this->session->set_flashdata('error', 'Post not found');
            redirect('posts');
        }

        $content_data['post']      = $post;
        $content_data['comments']  = $this->Comment_model->get_comments_by_post($post_id);
        $content_data['user_id']   = $this->session->userdata('user_id');
        $content_data['user_role'] = $this->session->userdata('role');

        $data['page_title']   = 'View Post';
        $data['active_menu']  = 'posts';
        $data['content_view'] = 'posts/view';
        $data['content_data'] = $content_data;
        $this->load->view('admin/layout', $data);
    }

    /**
     * Display create post form and handle submission
     * UPDATED: Admin posts are auto-published, user posts are pending
     */
    public function create()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[255]');
            $this->form_validation->set_rules('content', 'Content', 'required|min_length[20]');
            $this->form_validation->set_rules('category_id', 'Category', 'required|numeric');

            if ($this->form_validation->run() == TRUE) {
                $user_role = $this->session->userdata('role');
                $post_status = ($user_role == 'admin') ? 'published' : 'pending';
                
                $post_data = array(
                    'title'       => $this->input->post('title'),
                    'content'     => $this->input->post('content'),
                    'category_id' => $this->input->post('category_id'),
                    'user_id'     => $this->session->userdata('user_id'),
                    'status'      => $post_status
                );

                if ($this->Post_model->create_post($post_data)) {
                    if ($user_role == 'admin') {
                        $this->session->set_flashdata('success', 'Post created and published successfully!');
                    } else {
                        $this->session->set_flashdata('success', 'Post created successfully! Status: Pending (Awaiting admin approval)');
                    }
                    redirect('posts');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create post');
                }
            }
        }

        $content_data['categories'] = $this->Post_model->get_categories();
        $content_data['user_role']  = $this->session->userdata('role');

        $data['page_title']   = 'Create Post';
        $data['active_menu']  = 'posts';
        $data['content_view'] = 'posts/create';
        $data['content_data'] = $content_data;
        $this->load->view('admin/layout', $data);
    }

    /**
     * Display edit post form and handle submission
     */
    public function edit($post_id)
    {
        $post = $this->Post_model->get_post_by_id($post_id);

        if (!$post) {
            $this->session->set_flashdata('error', 'Post not found');
            redirect('posts');
        }

        $user_id   = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');

        if ($post->user_id != $user_id && $user_role != 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to edit this post');
            redirect('posts');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[255]');
            $this->form_validation->set_rules('content', 'Content', 'required|min_length[20]');
            $this->form_validation->set_rules('category_id', 'Category', 'required|numeric');

            if ($this->form_validation->run() == TRUE) {
                $post_data = array(
                    'title'       => $this->input->post('title'),
                    'content'     => $this->input->post('content'),
                    'category_id' => $this->input->post('category_id')
                );

                if ($this->Post_model->update_post($post_id, $post_data)) {
                    $this->session->set_flashdata('success', 'Post updated successfully!');
                    redirect('posts');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update post');
                }
            }
        }

        $content_data['post']       = $post;
        $content_data['categories'] = $this->Post_model->get_categories();

        $data['page_title']   = 'Edit Post';
        $data['active_menu']  = 'posts';
        $data['content_view'] = 'posts/edit';
        $data['content_data'] = $content_data;
        $this->load->view('admin/layout', $data);
    }

    /**
     * Delete a post
     */
    public function delete($post_id)
    {
        $post = $this->Post_model->get_post_by_id($post_id);

        if (!$post) {
            $this->session->set_flashdata('error', 'Post not found');
            redirect('posts');
        }

        $user_id   = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');

        if ($post->user_id != $user_id && $user_role != 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to delete this post');
            redirect('posts');
        }

        if ($this->Post_model->delete_post($post_id)) {
            $this->session->set_flashdata('success', 'Post deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete post');
        }

        redirect('posts');
    }
}
