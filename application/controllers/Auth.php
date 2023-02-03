<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->session->userdata('is_login')) {
            redirect(base_url('dashboard'));
        }
        $this->load->view('auth/index');
    }

    public function login()
    {
        if ($this->input->is_ajax_request() == true) {
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);

            $this->form_validation->set_rules(
                'username',
                'Username',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

            $this->form_validation->set_rules(
                'password',
                'Password',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

            if ($this->form_validation->run() == true) {
                $cek  = $this->db->get_where('user', ['username' => $username]);

                if ($cek->num_rows() > 0) {

                    $hasil = $cek->row();
                    if (password_verify($password, $hasil->password)) {
                        // membuat session
                        $this->session->set_userdata('id', $hasil->id);
                        $this->session->set_userdata('role', $hasil->role);
                        $this->session->set_userdata('nama', $hasil->nama);
                        $this->session->set_userdata('adm_loc', $hasil->adm_loc);
                        $this->session->set_userdata('is_login', TRUE);

                        $url = base_url('dashboard');
                        $msg = ['sukses' => 'Berhasil login', 'url' => $url];
                    } else {
                        $msg = ['failed' => 'Password not match'];
                    }
                } else {
                    $msg = ['failed' => 'Username not found'];
                }
            } else {
                $msg = [
                    // 'error' => validation_errors()
                    'error' => true,
                    'username_invalid' => form_error('username', '<div class="invalid-feedback username">', '</div>'),
                    'password_invalid' => form_error('password', '<div class="invalid-feedback password">', '</div>')
                ];
            }

            echo json_encode($msg);
        } else {
            echo "Z O N K";
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $url = base_url();
        $msg = ['sukses' => 'Berhasil logout', 'url' => $url];
        echo json_encode($msg);
    }
}
