<?php
defined('BASEPATH') or exit('No direct script access allowed');

class tamu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
    }

    public function index()
    {

        $data['title'] = 'Berita';
        $this->load->library('pagination');


        if ($this->input->post('keyword')) {
            $data['keyword'] = trim($this->input->post('keyword'));
        } else {
            $data['keyword'] = '';
        }

        $this->db->join('category', 'category.id_kategori=news.id_kategori', 'left');
        $this->db->group_start();
        $this->db->like('title', $data['keyword']);
        $this->db->or_like('kategori', $data['keyword']);
        $this->db->group_end();
        $this->db->where('is_active', 1); // Memastikan hanya yang is_active=1 yang dihitung
        $this->db->from('news');
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];
        $data['kategori'] = $this->input->post('kategori');
        $config['per_page'] = 4;


        //initialise
        $this->pagination->initialize($config);
        $data['start'] = $this->uri->segment(3);
        $data['news'] = $this->news_model->getlistnews($config['per_page'], $data['start'], $data['keyword'], $data['kategori']);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->session->userdata('email')) {
            $data['email'] = $this->session->userdata('email');
        };

        //-pagination end


        $this->load->view('layout/v_head', $data);
        $this->load->view('layout/v_header', $data);
        $this->load->view('layout/v_nav', $data);
        $this->load->view('layout/index', $data);
        $this->load->view('layout/v_footer');
    }

    public function detail($slug)
    {
        $data['title'] = 'Berita';
        $data['news'] = $this->news_model->get_news($slug);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->session->userdata('email')) {
            $data['email'] = $this->session->userdata('email');
        };

        $this->load->view('layout/v_head', $data);
        $this->load->view('layout/v_header', $data);
        $this->load->view('layout/v_nav', $data);
        $this->load->view('layout/v_detail', $data);
        $this->load->view('layout/v_footer');
    }
}
