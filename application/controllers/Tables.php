<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tables extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Data_mahasiswa_model"); //load model data mahasiswa
    }

    //method pertama yang akan di eksekusi
    public function index()
    {
        $data["title"] = "List Data Mahasiswa";
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('tables', $data);
        $this->load->view('templates/footer');
    }

    //method yang digunakan untuk request data mahasiswa
    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Data_mahasiswa_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $Data_mahasiswa) {
            $no++;
            $row = array();
            //row pertama akan kita gunakan untuk btn edit dan delete

            $row[] = $no;
            $row[] = $Data_mahasiswa->Nama;
            $row[] = $Data_mahasiswa->Alamat;
            $row[] = $Data_mahasiswa->Email;
            $row[] =  '<button class="btn btn-primary btn-circle btn-sm" onclick=edit(' . $Data_mahasiswa->IdMhsw . ')><i class="fa fa-edit"></i> </button>
            <button class="btn btn-danger btn-circle btn-sm" onclick=hapus(' . $Data_mahasiswa->IdMhsw . ')><i class="fa fa-trash"></i></button>';

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Data_mahasiswa_model->count_all(),
            "recordsFiltered" => $this->Data_mahasiswa_model->count_filtered(),
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
            $msg = [
                'sukses' => $this->load->view('mahasiswa/modaladd', '', true)
            ];

            echo json_encode($msg);
        }
    }

    public function savedata()
    {
        if ($this->input->is_ajax_request() == true) {
            $nama = $this->input->post('nama', true);
            $alamat = $this->input->post('alamat', true);
            $email = $this->input->post('email', true);

            $this->form_validation->set_rules(
                'nama',
                'Nama',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

            $this->form_validation->set_rules(
                'alamat',
                'Alamat',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

            $this->form_validation->set_rules(
                'email',
                'Email',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

            if ($this->form_validation->run() == true) {
                $dataNewMahasiswa = [
                    'Nama' => $nama,
                    'Alamat' => $alamat,
                    'Email' => $email
                ];

                $this->Data_mahasiswa_model->insertdata($dataNewMahasiswa);

                $msg = ['sukses' => 'Data berhasil disimpan'];
            } else {
                $msg = [
                    // 'error' => validation_errors()
                    'error' => true,
                    'nama_invalid' => form_error('nama', '<div class="invalid-feedback nama">', '</div>'),
                    'email_invalid' => form_error('email', '<div class="invalid-feedback email">', '</div>'),
                    'alamat_invalid' => form_error('alamat', '<div class="invalid-feedback alamat">', '</div>')
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

            $que = $this->Data_mahasiswa_model->getdata($id);
            if ($que->num_rows() > 0) {
                $queRow = $que->row_array();

                $data = [
                    'id' => $id,
                    'nama' => $queRow['Nama'],
                    'alamat' => $queRow['Alamat'],
                    'email' => $queRow['Email']
                ];
            }

            $msg = [
                'sukses' => $this->load->view('mahasiswa/modaledit', $data, true)
            ];

            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->input->is_ajax_request() == true) {
            $nama = $this->input->post('nama', true);
            $alamat = $this->input->post('alamat', true);
            $email = $this->input->post('email', true);

            $this->form_validation->set_rules(
                'nama',
                'Nama',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

            $this->form_validation->set_rules(
                'alamat',
                'Alamat',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

            $this->form_validation->set_rules(
                'email',
                'Email',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

            if ($this->form_validation->run() == true) {
                $dataNewMahasiswa = [
                    'Nama' => $nama,
                    'Alamat' => $alamat,
                    'Email' => $email
                ];

                $this->Data_mahasiswa_model->updatedata($dataNewMahasiswa);

                $msg = ['sukses' => 'Data berhasil diupdate'];
            } else {
                $msg = [
                    // 'error' => validation_errors()
                    'error' => true,
                    'nama_invalid' => form_error('nama', '<div class="invalid-feedback nama">', '</div>'),
                    'email_invalid' => form_error('email', '<div class="invalid-feedback email">', '</div>'),
                    'alamat_invalid' => form_error('alamat', '<div class="invalid-feedback alamat">', '</div>')
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
            $delete = $this->Data_mahasiswa_model->deletedata($id);

            if ($delete) {
                $msg = [
                    'sukses' => 'Data berhasil dihapus'
                ];

                echo json_encode($msg);
            }
        }
    }
}
