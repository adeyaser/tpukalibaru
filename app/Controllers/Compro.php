<?php

namespace App\Controllers;

use App\Models\ComproMessageModel;
use App\Models\SettingModel;

class Compro extends BaseController
{
    protected $db;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['acl', 'url']);
    }
    
    /**
     * Get common data for all views
     */
    protected function getCommonData(): array
    {
        $settings = $this->db->table('settings')
            ->get()
            ->getResultArray();
        
        $settingsArray = [];
        foreach ($settings as $s) {
            $settingsArray[$s['key']] = $s['value'];
        }
        
        $contact = $this->db->table('compro_contact')->get()->getRowArray();
        
        return [
            'settings' => $settingsArray,
            'contact' => $contact,
        ];
    }
    
    /**
     * Homepage
     */
    public function index()
    {
        $data = $this->getCommonData();
        
        // Hero
        $data['hero'] = $this->db->table('compro_hero')
            ->where('is_active', 1)
            ->get()
            ->getRowArray();
        
        // About
        $data['about'] = $this->db->table('compro_about')
            ->get()
            ->getRowArray();
        
        // Services
        $data['services'] = $this->db->table('compro_services')
            ->where('is_active', 1)
            ->orderBy('urutan', 'ASC')
            ->get()
            ->getResultArray();
        
        // Gallery (limited)
        $data['gallery'] = $this->db->table('compro_gallery')
            ->where('is_active', 1)
            ->orderBy('urutan', 'ASC')
            ->limit(6)
            ->get()
            ->getResultArray();
        
        // Testimonials
        $data['testimonials'] = $this->db->table('compro_testimonials')
            ->where('is_active', 1)
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get()
            ->getResultArray();
        
        // Stats
        $data['stats'] = [
            'total_makam' => $this->db->table('lokasi_makam')->selectSum('kapasitas')->get()->getRow()->kapasitas ?? 0,
            'tahun_beroperasi' => date('Y') - 2000, // Assuming started in 2000
            'total_keluarga' => $this->db->table('keluarga_jenazah')->countAllResults(),
        ];
        
        return view('compro/index', $data);
    }
    
    /**
     * About page
     */
    public function about()
    {
        $data = $this->getCommonData();
        $data['title'] = 'Tentang Kami';
        $data['about'] = $this->db->table('compro_about')->get()->getRowArray();
        
        return view('compro/about', $data);
    }
    
    /**
     * Services page
     */
    public function services()
    {
        $data = $this->getCommonData();
        $data['title'] = 'Layanan Kami';
        $data['services'] = $this->db->table('compro_services')
            ->where('is_active', 1)
            ->orderBy('urutan', 'ASC')
            ->get()
            ->getResultArray();
        
        return view('compro/services', $data);
    }
    
    /**
     * Gallery page
     */
    public function gallery()
    {
        $data = $this->getCommonData();
        $data['title'] = 'Galeri';
        $data['gallery'] = $this->db->table('compro_gallery')
            ->where('is_active', 1)
            ->orderBy('urutan', 'ASC')
            ->get()
            ->getResultArray();
        
        return view('compro/gallery', $data);
    }
    
    /**
     * Contact page
     */
    public function contact()
    {
        $data = $this->getCommonData();
        $data['title'] = 'Kontak';
        
        return view('compro/contact', $data);
    }

    /**
     * Handle contact form submission
     */
    public function submitMessage()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/contact');
        }

        // Validation Rules
        $rules = [
            'name'    => 'required|min_length[3]|max_length[100]',
            'email'   => 'required|valid_email|max_length[100]',
            'subject' => 'required|min_length[3]|max_length[200]',
            'message' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // --- Turnstile Verification ---
        $turnstileResponse = $this->request->getPost('cf-turnstile-response');
        $secretKey = env('TURNSTILE_SECRET_KEY');

        if ($secretKey && $turnstileResponse) {
            $verifyUrl = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
            $postData = [
                'secret'   => $secretKey,
                'response' => $turnstileResponse,
                'remoteip' => $this->request->getIPAddress(),
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $verifyUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseBody = curl_exec($ch);
            curl_close($ch);

            $responseData = json_decode($responseBody, true);
            if (!$responseData['success']) {
                return redirect()->back()->withInput()->with('error', 'Verifikasi keamanan gagal (Bot detected). Silakan coba lagi.');
            }
        }

        // Save Message
        $messageModel = new ComproMessageModel();
        
        try {
            $data = [
                'nama'       => $this->request->getPost('name'),
                'email'      => $this->request->getPost('email'),
                'subject'    => $this->request->getPost('subject'),
                'pesan'      => $this->request->getPost('message'),
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => substr($this->request->getUserAgent()->getAgentString(), 0, 255),
            ];

            $save = $messageModel->insert($data);

            if (!$save) {
                $errors = $messageModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Kesalahan internal database.';
                return redirect()->back()->withInput()->with('error', 'Gagal mengirim pesan: ' . $errorMessage);
            }

            return redirect()->to('/contact')->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
        } catch (\Exception $e) {
            log_message('error', '[ContactForm] Error saving message: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
