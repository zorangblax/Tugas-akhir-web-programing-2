<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        ceklogin();
        $this->load->model('news_model');
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function editprofile()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full name', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            //kalo ada gambar yg pengen di upload
            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $config['upload_path']          = './assets/img/profile/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 6048;
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image); //FCPATH untuk mengetahui file namenya karena gak bisa pake base url
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Gambar Salah Harus gif/jpg/png/jpeg
              </div>');
                    redirect('user');
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			  Profile berhasil di edit
			</div>');
            redirect('user');
        }
    }

    public function changepassword()
    {

        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'password lama', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'password baru', 'required|trim|min_length[8]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'password_baru2', 'required|trim|matches[new_password1]|min_length[8]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new = $this->input->post('new_password1');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			  Password lama salah!
			</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Password lama tidak boleh sama dengan password baru
                  </div>');
                    redirect('user/changepassword');
                } else {
                    //password bener
                    $encrypt = password_hash($new, PASSWORD_DEFAULT);
                    $this->db->set('password', $encrypt);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Password telah diganti  
                  </div>');
                    redirect('user/changepassword');
                }
            }
        }
    }
    public function pengajuan()
    {
        $data['title'] = 'Pengajuan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['news'] = $this->news_model->get_news();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/pengajuan', $data);
        $this->load->view('templates/footer');
    }



    public function pengajuan_berita()
    {
        $data['title'] = 'Pengajuan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['news'] = $this->news_model->get_news();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/tambah-pengajuan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->news_model->save_news();
            redirect('user/pengajuan');
        }
    }


    public function hapus_data($id)
    {
        $this->news_model->hapus_data($id);
        redirect('user/pengajuan');
    }

    public function edit_data($id)
    {
        $data['title'] = 'Pengajuan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['news'] = $this->news_model->edit_news($id);

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/pengajuan-edit', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('user/save_edit');
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
                redirect('user/pengajuan');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Gambar Salah Harus gif/jpg/png/jpeg
              </div>');
                redirect('user/pengajuan');
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
            redirect('user/pengajuan');
        }
    }
    public function pengajuan_detail($slug)
    {
        $data['title'] = 'Berita';
        $data['news'] = $this->news_model->get_news($slug);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/pengajuan-detail', $data);
        $this->load->view('templates/footer');
    }
}
