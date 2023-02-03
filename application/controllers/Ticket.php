<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model("Ticket_model"); //load model Ticket
    }

    //method pertama yang akan di eksekusi
    public function index()
    {
        $data["title"] = "List Data Ticket";
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('ticket/index', $data);
        $this->load->view('templates/footer');
    }

    //method yang digunakan untuk request data ticket
    public function ajax_list()
    {
        header('Content-Type: application/json');
        $dataTicket = $this->Ticket_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data ticket
        foreach ($dataTicket as $dt) {
            $no++;
            $row = array();
            //row pertama akan kita gunakan untuk btn edit dan delete

            $row[] = $no;
            $row[] = $dt->no_ticket;
            $row[] = $dt->content_ticket;
            $row[] = $dt->adm_loc;

            if ($dt->finished_date) {
                $row[] = $dt->finished_date;
            } elseif ($dt->process_date && !$dt->finished_date) {
                $row[] = $dt->process_date;
            } elseif (!$dt->process_date && !$dt->finished_date) {
                $row[] = $dt->created_date;
            }

            // if ($dt->handle_by) {
            //     //$row[] = $dt->handle_by;
            //     $row[] = '<h6><span class="badge badge-light">' . $dt->handle_by . '</span></h6>';
            // } else {
            //     $row[] = '<h6><span class="badge badge-warning">Waiting...</span></h6>';
            // }

            // Admin
            if ($this->session->userdata('role') !== '3') {
                if ($dt->status == 0) {
                    $row[] = '<h6><span class="badge badge-danger">Open</span></h6>';
                } elseif ($dt->status == 1) {
                    $row[] = '<h6><span class="badge badge-warning">Process</span></h6>';
                } elseif ($dt->status == 2) {
                    $row[] = '<h6><span class="badge badge-success">Done</span></h6>';
                }
                $row[] =  '<button class="btn btn-success btn-circle btn-sm" onclick=detail(' . $dt->no_ticket . ')><i class="fa fa-eye"></i></button> <button class="btn btn-primary btn-circle btn-sm" onclick=edit(' . $dt->no_ticket . ')><i class="fa fa-edit"></i> </button>
                <button class="btn btn-danger btn-circle btn-sm" onclick=hapus(' . $dt->no_ticket . ')><i class="fa fa-trash"></i></button>';
            }


            // Operator Desa
            if ($this->session->userdata('role') == '3') {
                if ($dt->status == 0) {
                    $row[] = '<h6><span class="badge badge-danger">Open</span></h6>';
                    $row[] =  '<button class="btn btn-success btn-circle btn-sm" onclick=detail(' . $dt->no_ticket . ')><i class="fa fa-eye"></i></button> <button class="btn btn-primary btn-circle btn-sm" onclick=edit(' . $dt->no_ticket . ')><i class="fa fa-edit"></i> </button>
                <button class="btn btn-danger btn-circle btn-sm" onclick=hapus(' . $dt->no_ticket . ')><i class="fa fa-trash"></i></button>';
                } elseif ($dt->status == 1) {
                    $row[] = '<h6><span class="badge badge-warning">Process</span></h6>';
                    //$row[] = '<h6><span class="badge badge-secondary">Locked</span></h6>';
                    $row[] = '<button class="btn btn-success btn-circle btn-sm" onclick=detail(' . $dt->no_ticket . ')><i class="fa fa-eye"></i></button>';
                } elseif ($dt->status == 2) {
                    $row[] = '<h6><span class="badge badge-success">Done</span></h6>';
                    $row[] = '<button class="btn btn-success btn-circle btn-sm" onclick=detail(' . $dt->no_ticket . ')><i class="fa fa-eye"></i></button>';
                }
            }

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Ticket_model->count_all(),
            "recordsFiltered" => $this->Ticket_model->count_filtered(),
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

            $data['modalTitle'] = 'Add Ticket';
            $noTicket = $this->Ticket_model->count_ticket_today();
            $data['noTicket'] = $noTicket + 1;

            if (strlen($data['noTicket']) == 1) {
                $data['noTicket'] = '000' . $data['noTicket'];
            } elseif (strlen($data['noTicket']) == 2) {
                $data['noTicket'] = '00' . $data['noTicket'];
            }

            $noTicketAgain = $this->Ticket_model->count_ticket_today_again($data['noTicket']);

            if ($noTicketAgain) {
                $data['noTicket'] = $noTicket + 2;

                if (strlen($data['noTicket']) == 1) {
                    $data['noTicket'] = '000' . $data['noTicket'];
                } elseif (strlen($data['noTicket']) == 2) {
                    $data['noTicket'] = '00' . $data['noTicket'];
                }
            }

            $msg = [
                'sukses' => $this->load->view('ticket/modaladd', $data, true)
            ];

            echo json_encode($msg);
        }
    }

    public function savedata()
    {
        if ($this->input->is_ajax_request() == true) {
            $noTicket = $this->input->post('noTicket', true);
            $content = $this->input->post('content', true);
            $this->form_validation->set_rules(
                'noTicket',
                'No Ticket',
                'required',
                [
                    'required' => '%s harus diisi'
                ]
            );

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
                        $data = array('upload_data' => $this->upload->data());
                        $dataNewTicket['file_ticket'] = $data['upload_data']['file_name'];
                    }
                }

                // $dataNewTicket = [
                //     'no_ticket' => $noTicket,
                //     'content_ticket' => $content,
                //     'file_ticket' => $data['upload_data']['file_name'],
                //     'created_by' => $this->session->userdata('id'),
                //     'created_date' => date('Y-m-d H:i:s'),
                //     'status' => '0'
                // ];

                $dataNewTicket['no_ticket'] = $noTicket;
                $dataNewTicket['content_ticket'] = $content;
                $dataNewTicket['created_by'] =  $this->session->userdata('id');
                $dataNewTicket['created_date'] =  date('Y-m-d H:i:s');
                $dataNewTicket['status'] =  '0';

                $this->Ticket_model->insertdata($dataNewTicket);

                $msg = ['sukses' => 'Data berhasil disimpan'];
            } else {
                $msg = [
                    // 'error' => validation_errors()
                    'error' => true,
                    'noTicket_invalid' => form_error('noTicket', '<div class="invalid-feedback noTicket">', '</div>'),
                    'content_invalid' => form_error('content', '<div class="invalid-feedback content">', '</div>')
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

            $que = $this->Ticket_model->getdata($id);
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
                        $que = $this->Ticket_model->getdata($this->input->post('id', true));
                        $queRow = $que->row_array();

                        if ($queRow['file_ticket']) {
                            $path = './assets/images/' . $queRow['file_ticket'];
                            unlink($path);
                        }

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

                $this->Ticket_model->updatedata($dataTicket);

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

            $que = $this->Ticket_model->getdata($id);
            $queRow = $que->row_array();

            if ($queRow['file_ticket']) {
                $path = './assets/images/' . $queRow['file_ticket'];
                unlink($path);
            }

            $delete = $this->Ticket_model->deletedata($id);

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

            $que = $this->Ticket_model->getdata($id);
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
