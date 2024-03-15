<?php

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        if ($this->Employee->is_logged_in())
        {
            redirect('home');
        } else
        {
            $this->form_validation->set_rules('username', 'lang:login_undername', 'callback_login_check');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('login');
            } else
            {
                redirect('home');
            }
        }
    }

    function login_check($username)
    {
        $password = $this->input->post("password");

        if (!$this->Employee->login($username, $password))
        {
            $this->form_validation->set_message('login_check', $this->lang->line('login_invalid_username_and_password'));
            return false;
        }
        return true;
    }
    
    function signup()
    {
        $username = $this->input->post("reg_username");
        $password = $this->input->post("reg_password");
        $first_name = $this->input->post("reg_first_name");
        $last_name = $this->input->post("reg_last_name");
        $email = $this->input->post("reg_email");
        $password = $this->input->post("reg_password");
        $contact = $this->input->post("reg_contact_number");
        
        $return["status"] = "OK";
        echo json_encode($return);
    }
}
?>