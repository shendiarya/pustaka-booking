<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Buku extends CI_Controller
{
 public function __construct()
 {
 parent::__construct();
 cek_login();
 }
 //manajemen Buku
 public function index()
 {
 $data['judul'] = 'Data Buku';
 $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
 $data['buku'] = $this->ModelBuku->tampil();
 $data['kategori'] = $this->ModelBuku->getKategori()->result_array();
 $this->form_validation->set_rules('judul_buku', 'Judul 
Buku', 'required|min_length[3]', [
 'required' => 'Judul Buku harus diisi',
 'min_length' => 'Judul buku terlalu pendek'
 ]);
 $this->form_validation->set_rules('id_kategori', 'Kategori', 
'required', [
 'required' => 'Nama pengarang harus diisi',
 ]);
 $this->form_validation->set_rules('pengarang', 'Nama 
Pengarang', 'required|min_length[3]', [
 'required' => 'Nama pengarang harus diisi',
 'min_length' => 'Nama pengarang terlalu pendek'
 ]);
 $this->form_validation->set_rules('penerbit', 'Nama 
Penerbit', 'required|min_length[3]', [
 'required' => 'Nama penerbit harus diisi',
 'min_length' => 'Nama penerbit terlalu pendek'
 ]);
 $this->form_validation->set_rules('tahun', 'Tahun Terbit', 
'required|min_length[3]|max_length[4]|numeric', [
 'required' => 'Tahun terbit harus diisi',
 'min_length' => 'Tahun terbit terlalu pendek',
 'max_length' => 'Tahun terbit terlalu panjang',
 'numeric' => 'Hanya boleh diisi angka'
 ]);
 $this->form_validation->set_rules('isbn', 'Nomor ISBN', 
'required|min_length[3]|numeric', [
 'required' => 'Nama ISBN harus diisi',
 'min_length' => 'Nama ISBN terlalu pendek',
 'numeric' => 'Yang anda masukan bukan angka'
]);
 $this->form_validation->set_rules('stok', 'Stok', 
'required|numeric', [
 'required' => 'Stok harus diisi',
 'numeric' => 'Yang anda masukan bukan angka'
 ]);
 //konfigurasi sebelum gambar diupload
 $config['upload_path'] = './assets/img/upload/';
 $config['allowed_types'] = 'jpg|png|jpeg';
 $config['max_size'] = '3000';
 $config['max_width'] = '1024';
 $config['max_height'] = '1000';
 $config['file_name'] = 'img' . time();
 $this->load->library('upload', $config);
 if ($this->form_validation->run() == false) {
 $this->load->view('template/header', $data);
 $this->load->view('template/sidebar', $data);
 $this->load->view('template/topbar', $data);
 $this->load->view('buku/index', $data);
 $this->load->view('template/footer');
 } else {
 if ($this->upload->do_upload('image')) {
 $image = $this->upload->data();
 $gambar = $image['file_name'];
 } else {
 $gambar = '';
 }
 $data = [
 'judul_buku' => $this->input->post('judul_buku', 
true),
 'id_kategori' => $this->input->post('id_kategori', 
true),
 'pengarang' => $this->input->post('pengarang', 
true),
 'penerbit' => $this->input->post('penerbit', true),
 'tahun_terbit' => $this->input->post('tahun', true),
 'isbn' => $this->input->post('isbn', true),
 'stok' => $this->input->post('stok', true),
 'dipinjam' => 0,
 'dibooking' => 0,
 'image' => $gambar
 ];
 $this->ModelBuku->simpanBuku($data);
 redirect('buku');
 }
 }
}