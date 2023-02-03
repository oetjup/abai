<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("Ticket_model"); //load model Ticket
    }

    public function index()
    {
        $data['ticketOpen'] = $this->Ticket_model->count_ticket_by_status('0');
        $data['ticketProcess'] = $this->Ticket_model->count_ticket_by_status('1');
        $data['ticketDone'] = $this->Ticket_model->count_ticket_by_status('2');

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}
