<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
        ceklogin();
    }

    public function index()
    {
        $data['title'] = 'Post Berita';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['news'] = $this->news_model->get_news();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/post', $data);
        $this->load->view('templates/footer');
    }



    public function tambah()
    {
        $data['title'] = 'Post Berita';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['news'] = $this->news_model->get_news();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/created', $data);
            $this->load->view('templates/footer');
        } else {
            $this->news_model->save_news();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Berhasil Ditambahkan
          </div>');
            redirect('admin');
        }
    }


    public function hapus_data($id)
    {
        $this->news_model->hapus_data($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Berhasil Dihapus
          </div>');
        redirect('admin');
    }

    public function edit_data($id)
    {
        $data['title'] = 'Post Berita';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['news'] = $this->news_model->edit_news($id);

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit_berita', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('admin/save_edit');
        }
    }

    public function save_edit()
    {
        $this->load->library('upload'); // Load upload library

        // Atur file di upload
        $config['upload_path'] = './assets/img/news/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 6040;
        $this->upload->initialize($config); // di Initialize upload

        if (!$this->upload->do_upload('image')) { //baris ini buat upload gambar baru tapi sebelum itu di cek
            // apakah dia mau ngubah gambar lama atau tidak
            if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4) //$_FILES['image']['size'] == 0 memeriksa apakah ukuran file yang diunggah adalah 0 byte. 
            // $_FILES['image']['error'] == 4 teru kalo ini kalo kode error 4 itu  menunjukkan bahwa tidak ada file yang diunggah.
            {
                // jika if diatas berhasil jalanin kodingan dibawah
                $id = $this->input->post('id');
                $title = $this->input->post('title');
                $data = [
                    'title' => $this->input->post('title'),
                    'id_kategori' => $this->input->post('category'),
                    'body' => $this->input->post('body'),
                    'slug' => url_title($title)
                    // nah disini gk ada image
                ];

                $this->news_model->save_edit_news($id, $data); // Update data tanpa ganti image
                redirect('admin/');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Gambar Salah Harus gif/jpg/png/jpeg
              </div>');
                redirect('admin');
            }
        } else {
            // Get upload data
            $upload_data = $this->upload->data(); //data disini berisi tentang upload an nya

            // ambil gambar yg ada
            $id = $this->input->post('id');
            $existing_image = $this->news_model->get_image_name($id); //mendapatkan nama gambar terkait dengan ID yang ada di model news_model

            // apus gambar yang telah di ganti
            if ($existing_image && file_exists('./assets/img/news/' . $existing_image)) {
                unlink('./assets/img/news/' . $existing_image);
            }

            // Update news data including the new image
            $title = $this->input->post('title');
            $data = [
                'title' => $this->input->post('title'),
                'id_kategori' => $this->input->post('category'),
                'body' => $this->input->post('body'),
                'slug' => url_title($title),
                'image' => $upload_data['file_name'] // New file name
            ];
            $this->news_model->save_edit_news($id, $data);
            redirect('admin/');
        }
    }
    public function verification_news()
    {
        $data['title'] = 'Verification News';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['news'] = $this->news_model->get_news();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/verifikasi-news', $data);
        $this->load->view('templates/footer');
    }
    public function hapus_verify($id)
    {
        $this->news_model->hapus_data($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Berhasil di Hapus
          </div>');
        redirect('admin/verification_news');
    }
    public function verifikasi_detail($slug)
    {
        $data['title'] = 'Verification News';
        $data['news'] = $this->news_model->get_news($slug);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/verifikasi-detail', $data);
        $this->load->view('templates/footer');
    }
    public function prove($id)
    {
        $data['title'] = 'Verification News';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['news'] = $this->news_model->edit_news($id);

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/verifikasi-edit', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('admin/save_prove');
        }
    }

    public function save_prove()
    {
        $this->load->library('upload'); // Load upload library

        // Atur file di upload
        $config['upload_path'] = './assets/img/news/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 6040;
        $this->upload->initialize($config); // di Initialize upload

        if (!$this->upload->do_upload('image')) { //baris ini buat upload gambar baru tapi sebelum itu di cek
            // apakah dia mau ngubah gambar lama atau tidak
            if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4) //$_FILES['image']['size'] == 0 memeriksa apakah ukuran file yang diunggah adalah 0 byte. 
            // $_FILES['image']['error'] == 4 teru kalo ini kalo kode error 4 itu  menunjukkan bahwa tidak ada file yang diunggah.
            {
                // jika if diatas berhasil jalanin kodingan dibawah
                $id = $this->input->post('id');
                $title = $this->input->post('title');
                $data = [
                    'title' => $this->input->post('title'),
                    'id_kategori' => $this->input->post('category'),
                    'body' => $this->input->post('body'),
                    'slug' => url_title($title),
                    'is_active' => $this->input->post('status', true)
                    // nah disini gk ada image
                ];

                $this->news_model->save_edit_news($id, $data); // Update data tanpa ganti image
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Berhasil di Approve
              </div>');
                redirect('admin/verification_news');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Gambar Salah Harus gif/jpg/png/jpeg
              </div>');
                redirect('admin/verification_news');
            }
        } else {
            // Get upload data
            $upload_data = $this->upload->data(); //data disini berisi tentang upload an nya

            // ambil gambar yg ada
            $id = $this->input->post('id');
            $existing_image = $this->news_model->get_image_name($id); //mendapatkan nama gambar terkait dengan ID yang ada di model news_model

            // apus gambar yang telah di ganti
            if ($existing_image && file_exists('./assets/img/news/' . $existing_image)) {
                unlink('./assets/img/news/' . $existing_image);
            }

            // Update news data including the new image
            $title = $this->input->post('title');
            $data = [
                'title' => $this->input->post('title'),
                'id_kategori' => $this->input->post('category'),
                'body' => $this->input->post('body'),
                'slug' => url_title($title),
                'image' => $upload_data['file_name'], // New file name
                'is_active' => $this->input->post('status', true)
            ];
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Berhasil di Approve
          </div>');
            $this->news_model->save_edit_news($id, $data);
            redirect('admin/verification_news');
        }
    }
    public function datauser()
    {
        $data['title'] = 'Data User';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['datauser'] = $this->news_model->get_user();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/data-user', $data);
        $this->load->view('templates/footer');
    }
    public function hapus_user($id)
    {
        $this->news_model->hapus_user($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                User Berhasil Dihapus
              </div>');
        redirect('admin/datauser');
    }
    public function ubahrole($id)
    {
        $this->news_model->ubahrole($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Role Telah diganti
      </div>');
        redirect('admin/datauser');
    }
}
