<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
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
        $this->load->view('mahasiswa_view', $data);
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
            $row[] =  '<a class="btn btn-success btn-sm"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-danger btn-sm "><i class="fa fa-trash"></i> </a>';
            $row[] = $Data_mahasiswa->Nama;
            $row[] = $Data_mahasiswa->Alamat;
            $row[] = $Data_mahasiswa->Email;
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
}