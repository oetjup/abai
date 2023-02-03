<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model("User_model"); //load model Ticket
    }

    //method pertama yang akan di eksekusi
    public function index()
    {
        if ($this->session->userdata('role') == '3') {
            if (!$this->session->userdata('is_login')) {
                redirect(base_url());
            } else {
                redirect(base_url('dashboard'));
            }
        }

        $data["title"] = "List Data User";
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    //method yang digunakan untuk request data ticket
    public function ajax_list()
    {
        header('Content-Type: application/json');
        $dataUser = $this->User_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data ticket
        foreach ($dataUser as $du) {
            $no++;
            $row = array();
            //row pertama akan kita gunakan untuk btn edit dan delete

            $row[] = $no;
            $row[] = $du->nama;
            $row[] = $du->username;
            $row[] = $du->nama_role;
            $row[] = $du->created_at;
            $row[] =  '<button class="btn btn-success btn-circle btn-sm" onclick=detailuser(' . $du->id . ')><i class="fa fa-eye"></i></button> <button class="btn btn-primary btn-circle btn-sm" onclick=edituser(' . $du->id . ')><i class="fa fa-edit"></i> </button>
                <button class="btn btn-danger btn-circle btn-sm" onclick=hapususer(' . $du->id . ')><i class="fa fa-trash"></i></button>';

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->User_model->count_all(),
            "recordsFiltered" => $this->User_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    //method insert_dummy digunakan untuk membuat data dummy mahasiswa
    public function insert_dummy()
    {
        //3ribu mahasiswa
        $jumlah_data = 3000;
        for ($i = 1; $i <= $jumlah_data; $i++) {
            $data   =   array(
                "Nama"      =>  "Mahasiswa ke" . $i,
                "Alamat"    =>  "Alamat mahasiswa ke" . $i,
                "Email"     =>  "mahasiswa$i@gmil.com"
            );
            //insert ke tabel mahasiswa
            $this->db->insert('mahasiswa', $data);
        }
        //flashdata untuk pesan success
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        ' . $jumlah_data . ' Data Mahasiswa berhasil disimpan. 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button></div>');
        redirect("mahasiswa");
    }

    public function formadd()
    {
        if ($this->input->is_ajax_request() == true) {

            $data['modalTitle'] = 'Add User';
            $data['listDesa'] = ['Desa Rancakole', 'Desa Baros', 'Desa Wargaluyu', 'Desa Jelekong', 'Desa Bojongmalaka', 'Desa Mekarjaya', 'Desa Kiangroke', 'Desa Pasirmulya', 'Desa Tegalluar', 'Desa Lengkong', 'Desa Nagrak Cangkuang', 'Desa Bandasari', 'Desa Cicalengka Wetan', 'Desa Cicalengka Kulon', 'Desa Tanjungwangi', 'Desa Ciluluk', 'Desa Hegarmanah', 'Desa Girimekar', 'Desa Jatiendah', 'Desa Cibiru Wetan', 'Desa Cileunyi Wetan', 'Desa Mekarsari', 'Desa Cikalong', 'Desa Sukamaju', 'Desa Cibeunying', 'Desa Cikadut', 'Desa Sumbersari', 'Desa Ciheulang', 'Desa Cikoneng', 'Desa Citeureup', 'Desa Sukapura', 'Desa Laksana', 'Desa Tanggulun', 'Desa Karyalaksana', 'Desa Gandasari', 'Desa Cilampeni', 'Desa Neglawangi', 'Desa Cibereum', 'Desa Buninagara', 'Desa Pemeuntasan', 'Desa Jelegong', 'Desa Padaulun', 'Desa Neglasari', 'Desa Wangisagara', 'Desa Nanjung', 'Desa Cigondewah Hilir', 'Desa Sukamenak', 'Desa Margahayu Selatan', 'Desa Ciaro', 'Desa Bojong', 'Desa Maruyung', 'Desa Nagrak Pacet', 'Desa Cikitu', 'Desa Bojongkunci', 'Desa Rancamulya', 'Desa Sukamanah', 'Desa Tribaktimulya', 'Desa Wanasuka', 'Desa Drawati', 'Desa Cipedes', 'Desa Tangsimekar', 'Desa Sugihmukti', 'Desa Cibodas', 'Desa Cukang Genteng', 'Desa Cipelah', 'Desa Sukaresmi', 'Desa Bojongsalam', 'Desa Sukamanah', 'Desa Rancaekek Kencana', 'Desa Bojong Emas', 'Desa Solokan Jeruk', 'Desa Sukagara', 'Desa Sukajadi', 'Desa Pamekaran', 'Desa Rawabogo', 'Desa Ciwidey'];

            $msg = [
                'sukses' => $this->load->view('user/modaladd', $data, true)
            ];

            echo json_encode($msg);
        }
    }

    public function savedata()
    {
        if ($this->input->is_ajax_request() == true) {
            $nama = $this->input->post('nama', true);
            $username = $this->input->post('username', true);
            $password1 = $this->input->post('password1', true);
            $password2 = $this->input->post('password2', true);
            $role = $this->input->post('role', true);
            $lokasi = $this->input->post('lokasi', true);

            $this->form_validation->set_rules(
                'nama',
                'Nama',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

            $this->form_validation->set_rules(
                'username',
                'Username',
                'required|is_unique[user.username]',
                [
                    'required' => '%s harus diisi',
                    'is_unique' => '%s sudah ada dalam database'
                ]
            );

            $this->form_validation->set_rules(
                'password1',
                'Password',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

            $this->form_validation->set_rules(
                'password2',
                'Password',
                'required|matches[password1]',
                [
                    'required' => '%s harus diisi',
                    'matches' => '%s tidak sama'
                ]
            );

            $this->form_validation->set_rules(
                'role',
                'Role',
                'required',
                [
                    'required' => '%s harus dipilih'
                ]
            );

            if ($role == '3') {
                $this->form_validation->set_rules(
                    'lokasi',
                    'Lokasi ADM',
                    'required',
                    [
                        'required' => '%s harus dipilih'
                    ]
                );

                $dataNewUser['adm_loc'] = $lokasi;
            }

            if ($this->form_validation->run() == true) {

                $password = password_hash($password1, PASSWORD_DEFAULT);

                // $dataNewUser = [
                //     'username' => $username,
                //     'password' => $password,
                //     'role' => $role,
                //     'created_at' => date('Y-m-d H:i:s'),
                //     'nama' => $nama,
                //     'adm_loc' => $lokasi
                // ];

                $dataNewUser['username'] = $username;
                $dataNewUser['password'] = $password;
                $dataNewUser['role'] = $role;
                $dataNewUser['created_at'] = date('Y-m-d H:i:s');
                $dataNewUser['nama'] = $nama;

                $this->User_model->insertdata($dataNewUser);

                $msg = ['sukses' => 'Data berhasil disimpan'];
            } else {
                $msg = [
                    // 'error' => validation_errors()
                    'error' => true,
                    'nama_invalid' => form_error('nama', '<div class="invalid-feedback nama">', '</div>'),
                    'username_invalid' => form_error('username', '<div class="invalid-feedback username">', '</div>'),
                    'password1_invalid' => form_error('password1', '<div class="invalid-feedback password1">', '</div>'),
                    'password2_invalid' => form_error('password2', '<div class="invalid-feedback password2">', '</div>'),
                    'role_invalid' => form_error('role', '<div class="invalid-feedback role">', '</div>'),
                    'lokasi_invalid' => form_error('lokasi', '<div class="invalid-feedback lokasi">', '</div>')
                ];
            }

            echo json_encode($msg);
        } else {
            echo "Z O N K";
        }
    }

    public function formedit()
    {
        if ($this->input->is_ajax_request() == true) {

            $id = $this->input->post('id', true);

            $que = $this->User_model->getdata($id);
            if ($que->num_rows() > 0) {
                $queRow = $que->row_array();

                $data = [
                    'id' => $id,
                    'noTicket' => $queRow['no_ticket'],
                    'content' => $queRow['content_ticket'],
                    'file_ticket' => $queRow['file_ticket'],
                    'status' => $queRow['status'],
                    'reply_ticket' => $queRow['reply_ticket'],
                    'adm_loc' => $queRow['adm_loc']
                ];
            }

            $msg = [
                'sukses' => $this->load->view('ticket/modaledit', $data, true)
            ];

            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->input->is_ajax_request() == true) {
            $content = $this->input->post('content', true);
            if ($this->session->userdata('role') !== '3') {
                $status = $this->input->post('status', true);
            } else {
                $status = '0';
            }

            $this->form_validation->set_rules(
                'content',
                'Permasalahan',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

            if ($this->form_validation->run() == true) {

                if (!empty($_FILES['file']['name'])) {
                    $config['upload_path'] = "./assets/images"; //path folder file upload
                    $config['allowed_types'] = 'gif|jpg|png|jpeg'; //type file yang boleh di upload
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload("file")) {
                        $que = $this->User_model->getdata($this->input->post('id', true));
                        $queRow = $que->row_array();
                        $path = './assets/images/' . $queRow['file_ticket'];
                        unlink($path);

                        $data = array('upload_data' => $this->upload->data());

                        $dataTicket['file_ticket'] = $data['upload_data']['file_name'];
                    }
                }

                if ($this->input->post('status', true)) {

                    $status = $this->input->post('status', true);

                    $dataTicket['status'] = $status;

                    if ($status == '1') {
                        $dataTicket['process_date'] = date('Y-m-d H:i:s');
                        $dataTicket['handle_by'] = $this->session->userdata('id');
                    } elseif ($status == '2') {
                        $dataTicket['finished_date'] = date('Y-m-d H:i:s');
                        $dataTicket['reply_ticket'] = $this->input->post('reply', true);
                    }
                }

                // $dataTicket = [
                //     'content_ticket' => $content,
                //     'created_date' => date('Y-m-d H:i:s'),
                //     'status' => $status
                // ];

                $dataTicket['content_ticket'] = $content;

                if ($this->session->userdata('id') == '3') {
                    $dataTicket['created_date'] = date('Y-m-d H:i:s');
                }

                $dataTicket['status'] = $status;

                $this->User_model->updatedata($dataTicket);

                $msg = ['sukses' => 'Data berhasil diupdate'];
            } else {
                $msg = [
                    // 'error' => validation_errors()
                    'error' => true,
                    'content_invalid' => form_error('content', '<div class="invalid-feedback content">', '</div>')
                ];
            }

            echo json_encode($msg);
        } else {
            echo "Z O N K";
        }
    }

    public function deletedata()
    {
        if ($this->input->is_ajax_request() == true) {
            $id = $this->input->post('id', true);

            $que = $this->User_model->getdata($id);
            $queRow = $que->row_array();

            $path = './assets/images/' . $queRow['file_ticket'];
            unlink($path);

            $delete = $this->User_model->deletedata($id);

            if ($delete) {
                $msg = [
                    'sukses' => 'Data berhasil dihapus'
                ];

                echo json_encode($msg);
            }
        }
    }

    public function hash()
    {
        $p = password_hash('123', PASSWORD_DEFAULT);
        echo $p;
    }

    public function formdetail()
    {
        if ($this->input->is_ajax_request() == true) {

            $id = $this->input->post('id', true);

            $que = $this->User_model->getdata($id);
            if ($que->num_rows() > 0) {
                $queRow = $que->row_array();

                $data = [
                    'id' => $id,
                    'noTicket' => $queRow['no_ticket'],
                    'content' => $queRow['content_ticket'],
                    'file_ticket' => $queRow['file_ticket'],
                    'status' => $queRow['status'],
                    'reply_ticket' => $queRow['reply_ticket'],
                    'adm_loc' => $queRow['adm_loc']
                ];
            }

            $msg = [
                'sukses' => $this->load->view('ticket/modaldetail', $data, true)
            ];

            echo json_encode($msg);
        }
    }
}
