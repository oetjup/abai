<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticket_model extends CI_Model
{
    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'ticket';

    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array('no_ticket', 'content_ticket', 'created_by', 'created_date', 'status', null);

    var $column_search = array('no_ticket', 'content_ticket', 'adm_loc');
    // default order 
    var $order = array('no_ticket' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        // if ($this->input->post('no_ticket')) {
        //     $this->db->like('no_ticket', $this->input->post('no_ticket'));
        // }
        // if ($this->input->post('content_ticket')) {
        //     $this->db->like('content_ticket', $this->input->post('content_ticket'));
        // }
        // if ($this->input->post('created_by')) {
        //     $this->db->like('created_by', $this->input->post('created_by'));
        // }

        //$this->db->select('ticket.*', 'user.*');
        $this->db->from($this->table);
        $this->db->join('user u', 'u.id = ' . $this->table . '.created_by');

        $i = 0;
        foreach ($this->column_search as $item) // loop kolom 
        {
            if ($this->input->post('keyword')) // jika datatable mengirim POST untuk search ($this->input->post('search')['value'])
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('keyword')); // ($this->input->post('search')['value'])
                } else {
                    $this->db->or_like($item, $this->input->post('keyword')); // ($this->input->post('search')['value'])
                }
                if (count($this->column_search) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function insertdata($dataNewTicket)
    {
        $this->db->insert($this->table, $dataNewTicket);
    }

    public function getdata($id)
    {
        //return $this->db->get_where($this->table, ['no_ticket' => $id]);
        $this->db->where('no_ticket', $id);
        $this->db->from($this->table);
        $this->db->join('user', 'user.id = ' . $this->table . '.created_by');
        return $this->db->get();
    }

    public function updatedata($data)
    {
        $this->db->where('no_ticket', $this->input->post('id', true));
        return $this->db->update($this->table, $data);
    }

    public function deletedata($id)
    {
        return $this->db->delete($this->table, ['no_ticket' => $id]);
    }

    public function count_ticket_today()
    {
        $today = date('Ymd');
        $this->db->like('no_ticket', $today, 'after');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function count_ticket_today_again($key)
    {
        $noTicket = date('Ymd') . $key;
        $this->db->where('no_ticket', $noTicket);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function count_ticket_by_status($status)
    {
        $this->db->where('status', $status);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}
