<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Categories Controller
 * Handles category CRUD operations
 */
class Categories extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category_model');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Please login to continue');
            redirect('login');
        }
        
        // Only admin can manage categories
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Access denied! Admin only.');
            redirect('posts');
        }
    }

    /**
     * Display all categories
     */
    public function index()
    {
        $content_data['categories'] = $this->Category_model->get_all_categories();

        $data['page_title']   = 'Categories';
        $data['active_menu']  = 'categories';
        $data['content_view'] = 'categories/list';
        $data['content_data'] = $content_data;
        $this->load->view('admin/layout', $data);
    }

    /**
     * Create new category
     */
    public function create()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Category Name', 'required|min_length[3]|max_length[100]|is_unique[categories.name]');

            if ($this->form_validation->run() == TRUE) {
                $cat_data = array(
                    'name' => $this->input->post('name'),
                    'slug' => url_title($this->input->post('name'), 'dash', TRUE)
                );

                if ($this->Category_model->create_category($cat_data)) {
                    $this->session->set_flashdata('success', 'Category created successfully!');
                    redirect('categories');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create category');
                }
            }
        }

        $data['page_title']   = 'Create Category';
        $data['active_menu']  = 'categories';
        $data['content_view'] = 'categories/create';
        $data['content_data'] = array();
        $this->load->view('admin/layout', $data);
    }

    /**
     * Edit category
     */
    public function edit($category_id)
    {
        $category = $this->Category_model->get_category_by_id($category_id);

        if (!$category) {
            $this->session->set_flashdata('error', 'Category not found');
            redirect('categories');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Category Name', 'required|min_length[3]|max_length[100]');

            if ($this->form_validation->run() == TRUE) {
                $cat_data = array(
                    'name' => $this->input->post('name'),
                    'slug' => url_title($this->input->post('name'), 'dash', TRUE)
                );

                if ($this->Category_model->update_category($category_id, $cat_data)) {
                    $this->session->set_flashdata('success', 'Category updated successfully!');
                    redirect('categories');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update category');
                }
            }
        }

        $content_data['category'] = $category;

        $data['page_title']   = 'Edit Category';
        $data['active_menu']  = 'categories';
        $data['content_view'] = 'categories/edit';
        $data['content_data'] = $content_data;
        $this->load->view('admin/layout', $data);
    }

    /**
     * Delete category
     */
    public function delete($category_id)
    {
        $category = $this->Category_model->get_category_by_id($category_id);

        if (!$category) {
            $this->session->set_flashdata('error', 'Category not found');
            redirect('categories');
        }

        if ($this->Category_model->delete_category($category_id)) {
            $this->session->set_flashdata('success', 'Category deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete category');
        }

        redirect('categories');
    }
}
