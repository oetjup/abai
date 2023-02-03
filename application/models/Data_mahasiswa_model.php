<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_mahasiswa_model extends CI_Model
{
    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'mahasiswa';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array(null, 'Nama', 'Alamat', 'Email');

    var $column_search = array('Nama', 'Alamat', 'Email');
    // default order 
    var $order = array('IdMhsw' => 'asc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        if ($this->input->post('Nama')) {
            $this->db->like('Nama', $this->input->post('Nama'));
        }
        if ($this->input->post('Alamat')) {
            $this->db->like('Alamat', $this->input->post('Alamat'));
        }
        if ($this->input->post('Email')) {
            $this->db->like('Email', $this->input->post('Email'));
        }

        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) // loop kolom 
        {
            if ($this->input->post('search')['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
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

    public function insertdata($dataNewMahasiswa)
    {
        $this->db->insert('mahasiswa', $dataNewMahasiswa);
    }

    public function getdata($id)
    {
        return $this->db->get_where('mahasiswa', ['IdMhsw' => $id]);
    }

    public function updatedata($data)
    {
        $this->db->where('IdMhsw', $this->input->post('id', true));
        return $this->db->update('mahasiswa', $data);
    }

    public function deletedata($id)
    {
        return $this->db->delete('mahasiswa', ['IdMhsw' => $id]);
    }
}
