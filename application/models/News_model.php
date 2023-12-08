<?php

class News_model extends CI_Model
{

    public function get_news($slug = false)
    {
        if ($slug == false) {

            $this->db->order_by('created', 'DESC');                                       //join tabel terus perlihatkan secara descending
            $this->db->join('category', 'category.id_kategori=news.id_kategori', 'left'); //
            return $this->db->get('news')->result_array();
        }
        $this->db->join('category', 'category.id_kategori=news.id_kategori', 'left');
        return $this->db->get_where('news', array('slug' => $slug))->row_array();
    }
    public function save_news()
    {
        $gambar = $_FILES['image'];
        if ($gambar) {
            $config['upload_path']          = './assets/img/news/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 6048;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $gambar = $this->upload->data('file_name');
                $title = $this->input->post('title');
                $data = [
                    'title' => $this->input->post('title'),
                    'id_kategori' => $this->input->post('category'),
                    'body' => $this->input->post('body'),
                    'image' => $gambar,
                    'slug' => url_title($title),
                    'email' => $this->input->post('email'),
                    'is_active' => 1

                ];
                return $this->db->insert('news', $data);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Gambar Salah Harus = gif/jpg/png/jpeg
                  </div>');
                redirect('admin/tambah ');
            }
        }
    }


    public function hapus_data($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('news');
    }
    public function edit_news($id)
    {
        $this->db->join('category', 'category.id_kategori=news.id_kategori', 'left');
        return $this->db->get_where('news', ['id' => $id])->row_array();
    }
    public function get_image_name($id)
    {
        $result = $this->db->select('image')->get_where('news', ['id' => $id])->row();
        if ($result) {
            return $result->image;
        } else {

            return false;
        }
    }
    public function save_edit_news($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('news', $data);
    }

    public function getlistnews($limit, $start, $keyword = null)
    {
        $this->db->join('category', 'category.id_kategori=news.id_kategori', 'left');
        if ($keyword) {
            $this->db->like('title', $keyword);
            $this->db->or_like('kategori', $keyword);
        }
        $this->db->where('is_active', 1);
        $this->db->order_by('created', 'DESC'); // Mengurutkan data berdasarkan tanggal_pembuatan secara descending
        $this->db->limit($limit, $start); // Menentukan limit data dan start    
        return $this->db->get('news')->result_array();
    }
    //untuk mencari tahu data nya ada brp
    public function countAllnews()
    {
        return $this->db->get('news')->num_rows();
    }
    //pengajuan
    public function save_pengajuan()
    {
        $gambar = $_FILES['image'];
        if ($gambar) {
            $config['upload_path']          = './assets/img/news/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 6048;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $gambar = $this->upload->data('file_name');
                $title = $this->input->post('title');
                $data = [
                    'title' => $this->input->post('title'),
                    'id_kategori' => $this->input->post('category'),
                    'body' => $this->input->post('body'),
                    'image' => $gambar,
                    'email' => $this->input->post('email'),
                    'slug' => url_title($title),
                    'is_active' => 0

                ];
                return $this->db->insert('news', $data);
                redirect('user/pengajuan');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Gambar Salah Harus = gif/jpg/png/jpeg
                  </div>');
                redirect('user/pengajuan_berita ');
            }
        }
    }
    public function get_user()
    {

        return $this->db->get('user')->result_array();
    }
    public function hapus_user($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
    }
    public function ubahrole($id)
    {
        $user_role = $this->db->get_where('user', array('id' => $id))->row_array();

        // Mengecek role_id yang diperoleh dari user
        if ($user_role['role_id'] == 1) {
            // Jika role_id adalah 1, update menjadi 2
            $data = ['role_id' => 2];
        } else {
            // Jika role_id bukan 1 (maka diasumsikan 2), update menjadi 1
            $data = ['role_id' => 1];
        }

        // Melakukan update berdasarkan id yang diberikan
        $this->db->where('id', $id);
        $this->db->update('user', $data);
    }
}
