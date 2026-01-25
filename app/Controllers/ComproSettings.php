<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComproHeroModel;
use App\Models\ComproAboutModel;
use App\Models\ComproContactModel;
use App\Models\ComproServicesModel;
use App\Models\ComproGalleryModel;
use App\Models\ComproTestimonialsModel;
use App\Models\ComproMessageModel;

class ComproSettings extends BaseController
{
    protected $models = [];

    public function __construct()
    {
        $this->models['hero'] = new ComproHeroModel();
        $this->models['about'] = new ComproAboutModel();
        $this->models['contact'] = new ComproContactModel();
        $this->models['services'] = new ComproServicesModel();
        $this->models['gallery'] = new ComproGalleryModel();
        $this->models['testimonials'] = new ComproTestimonialsModel();
        $this->models['messages'] = new ComproMessageModel();
    }

    public function index()
    {
        return view('compro_settings/index', ['title' => 'CMS Company Profile']);
    }

    // --- Hero Section ---
    public function hero()
    {
        $data = ['title' => 'Pengaturan Hero Section', 'hero' => $this->models['hero']->first()];
        return view('compro_settings/hero', $data);
    }

    public function updateHero()
    {
        $id = $this->request->getPost('id');
        $data = [
            'judul' => $this->request->getPost('judul'),
            'subjudul' => $this->request->getPost('subjudul'),
            'cta_text' => $this->request->getPost('cta_text'),
            'cta_url' => $this->request->getPost('cta_url'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $file = $this->request->getFile('background_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/compro', $newName);
            $data['background_image'] = $newName;
        }
        $id ? $this->models['hero']->update($id, $data) : $this->models['hero']->insert($data);
        return redirect()->to('/compro-settings/hero')->with('success', 'Hero updated');
    }

    // --- About Section ---
    public function about()
    {
        $data = ['title' => 'Pengaturan About Section', 'about' => $this->models['about']->first()];
        return view('compro_settings/about', $data);
    }

    public function updateAbout()
    {
        $id = $this->request->getPost('id');
        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'visi' => $this->request->getPost('visi'),
            'misi' => $this->request->getPost('misi'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/compro', $newName);
            $data['gambar'] = $newName;
        }
        $id ? $this->models['about']->update($id, $data) : $this->models['about']->insert($data);
        return redirect()->to('/compro-settings/about')->with('success', 'About updated');
    }

    // --- Contact Section ---
    public function contact()
    {
        $data = ['title' => 'Pengaturan Contact Section', 'contact' => $this->models['contact']->first()];
        return view('compro_settings/contact', $data);
    }

    public function updateContact()
    {
        $id = $this->request->getPost('id');
        $data = [
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'whatsapp' => $this->request->getPost('whatsapp'),
            'email' => $this->request->getPost('email'),
            'maps_embed' => $this->request->getPost('maps_embed'),
            'jam_operasional' => $this->request->getPost('jam_operasional'),
            'facebook' => $this->request->getPost('facebook'),
            'instagram' => $this->request->getPost('instagram'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $id ? $this->models['contact']->update($id, $data) : $this->models['contact']->insert($data);
        return redirect()->to('/compro-settings/contact')->with('success', 'Contact updated');
    }

    // --- Services Section CRUD ---
    public function services()
    {
        $data = ['title' => 'Pengaturan Layanan', 'services' => $this->models['services']->orderBy('urutan', 'ASC')->findAll()];
        return view('compro_settings/services/index', $data);
    }

    public function createService() { return view('compro_settings/services/create', ['title' => 'Tambah Layanan']); }
    
    public function storeService()
    {
        $data = [
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'icon' => $this->request->getPost('icon'),
            'urutan' => $this->request->getPost('urutan'),
            'harga' => $this->request->getPost('harga'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->models['services']->insert($data);
        return redirect()->to('/compro-settings/services')->with('success', 'Layanan berhasil ditambahkan');
    }

    public function editService($id) { return view('compro_settings/services/edit', ['title' => 'Edit Layanan', 'service' => $this->models['services']->find($id)]); }

    public function updateService($id)
    {
        $data = [
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'icon' => $this->request->getPost('icon'),
            'urutan' => $this->request->getPost('urutan'),
            'harga' => $this->request->getPost('harga'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->models['services']->update($id, $data);
        return redirect()->to('/compro-settings/services')->with('success', 'Layanan berhasil diupdate');
    }

    public function deleteService($id)
    {
        $this->models['services']->delete($id);
        return redirect()->to('/compro-settings/services')->with('success', 'Layanan berhasil dihapus');
    }

    // --- Gallery Section CRUD ---
    public function gallery()
    {
        $data = ['title' => 'Pengaturan Galeri', 'gallery' => $this->models['gallery']->orderBy('urutan', 'ASC')->findAll()];
        return view('compro_settings/gallery/index', $data);
    }

    public function createGallery() { return view('compro_settings/gallery/create', ['title' => 'Tambah Foto Galeri']); }

    public function storeGallery()
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'urutan' => $this->request->getPost('urutan') ?? 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/compro', $newName);
            $data['gambar'] = $newName;
        }
        $this->models['gallery']->insert($data);
        return redirect()->to('/compro-settings/gallery')->with('success', 'Foto berhasil ditambahkan');
    }

    public function deleteGallery($id)
    {
        $this->models['gallery']->delete($id);
        return redirect()->to('/compro-settings/gallery')->with('success', 'Foto berhasil dihapus');
    }

    // --- Testimonials Section CRUD ---
    public function testimonials()
    {
        $data = ['title' => 'Pengaturan Testimoni', 'testimonials' => $this->models['testimonials']->findAll()];
        return view('compro_settings/testimonials/index', $data);
    }

    public function createTestimonial() { return view('compro_settings/testimonials/create', ['title' => 'Tambah Testimoni']); }

    public function storeTestimonial()
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'relasi' => $this->request->getPost('relasi'),
            'testimoni' => $this->request->getPost('testimoni'),
            'rating' => $this->request->getPost('rating'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/compro', $newName);
            $data['foto'] = $newName;
        }
        $this->models['testimonials']->insert($data);
        return redirect()->to('/compro-settings/testimonials')->with('success', 'Testimoni berhasil ditambahkan');
    }

    public function editTestimonial($id) { return view('compro_settings/testimonials/edit', ['title' => 'Edit Testimoni', 'testimonial' => $this->models['testimonials']->find($id)]); }

    public function updateTestimonial($id)
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'relasi' => $this->request->getPost('relasi'),
            'testimoni' => $this->request->getPost('testimoni'),
            'rating' => $this->request->getPost('rating'),
        ];
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/compro', $newName);
            $data['foto'] = $newName;
        }
        $this->models['testimonials']->update($id, $data);
        return redirect()->to('/compro-settings/testimonials')->with('success', 'Testimoni berhasil diupdate');
    }

    public function deleteTestimonial($id)
    {
        $this->models['testimonials']->delete($id);
        return redirect()->to('/compro-settings/testimonials')->with('success', 'Testimoni berhasil dihapus');
    }

    // --- Messages Section ---
    public function messages()
    {
        $data = [
            'title'    => 'Pesan Masuk',
            'messages' => $this->models['messages']->orderBy('created_at', 'DESC')->findAll(),
        ];
        return view('compro_settings/messages/index', $data);
    }

    public function viewMessage($id)
    {
        $message = $this->models['messages']->find($id);
        if (!$message) {
            return redirect()->to('/compro-settings/messages')->with('error', 'Pesan tidak ditemukan');
        }

        // Mark as read
        $this->models['messages']->update($id, ['is_read' => 1]);

        return view('compro_settings/messages/view', [
            'title'   => 'Baca Pesan',
            'message' => $message
        ]);
    }

    public function deleteMessage($id)
    {
        $this->models['messages']->delete($id);
        return redirect()->to('/compro-settings/messages')->with('success', 'Pesan berhasil dihapus');
    }
}
