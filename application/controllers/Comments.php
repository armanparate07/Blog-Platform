<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comments Controller
 * Handles comment CRUD operations
 */
class Comments extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Comment_model');
        $this->load->model('Post_model');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Please login to continue');
            redirect('login');
        }
    }

    /**
     * Add a comment to a post
     */
    public function add($post_id)
    {
        // Verify post exists
        $post = $this->Post_model->get_post_by_id($post_id);
        
        if (!$post) {
            $this->session->set_flashdata('error', 'Post not found');
            redirect('posts');
        }

        if ($this->input->post()) {
            // Set validation rules
            $this->form_validation->set_rules('comment', 'Comment', 'required|min_length[3]');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'post_id' => $post_id,
                    'user_id' => $this->session->userdata('user_id'),
                    'comment' => $this->input->post('comment')
                );

                if ($this->Comment_model->create_comment($data)) {
                    $this->session->set_flashdata('success', 'Comment added successfully!');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add comment');
                }
            }
        }

        redirect('posts/view/' . $post_id);
    }

    /**
     * Delete a comment
     */
    public function delete($comment_id)
    {
        $comment = $this->Comment_model->get_comment_by_id($comment_id);

        if (!$comment) {
            $this->session->set_flashdata('error', 'Comment not found');
            redirect('posts');
        }

        // Only admin or comment owner can delete
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');

        if ($comment->user_id != $user_id && $user_role != 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to delete this comment');
            redirect('posts/view/' . $comment->post_id);
        }

        if ($this->Comment_model->delete_comment($comment_id)) {
            $this->session->set_flashdata('success', 'Comment deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete comment');
        }

        redirect('posts/view/' . $comment->post_id);
    }
}