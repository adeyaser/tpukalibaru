<?php

namespace App\Controllers;

use App\Models\TagihanKeluargaModel;
use App\Models\TagihanKeluargaItemModel;
use App\Models\PemakamanModel;
use App\Models\KeluargaJenazahModel;

use Dompdf\Dompdf;
use Dompdf\Options;

class TagihanKeluarga extends BaseController
{
    protected $model;
    protected $itemModel;

    public function __construct()
    {
        $this->model = new TagihanKeluargaModel();
        $this->itemModel = new TagihanKeluargaItemModel();
        helper(['acl', 'form', 'setting']);
    }

    public function index()
    {
        $data = [
            'title' => 'Data Tagihan',
            'breadcrumb' => [['title' => 'Data Tagihan', 'active' => true]],
            'tagihan' => $this->model->getAllWithDetails(),
        ];
        return view('tagihan/index', $data);
    }

    public function create()
    {
        $pemakamanModel = new PemakamanModel();
        
        $data = [
            'title' => 'Buat Tagihan Baru',
            'breadcrumb' => [
                ['title' => 'Data Tagihan', 'url' => base_url('tagihan'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
            'pemakaman' => $pemakamanModel->getAllWithDetails(),
        ];
        return view('tagihan/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        
        // Handle items
        $itemNames = $this->request->getPost('item_name');
        $itemNominals = $this->request->getPost('item_nominal');
        
        $totalNominal = 0;
        $items = [];
        
        if ($itemNames && is_array($itemNames)) {
            foreach ($itemNames as $key => $name) {
                if (!empty($name)) {
                    $nominal = (float)($itemNominals[$key] ?? 0);
                    $totalNominal += $nominal;
                    $items[] = [
                        'nama_item' => $name,
                        'nominal' => $nominal
                    ];
                }
            }
        }

        // If no items but nominal is provided (legacy or single input)
        if (empty($items) && !empty($data['nominal'])) {
            $totalNominal = (float)$data['nominal'];
            $items[] = [
                'nama_item' => 'Biaya ' . ucfirst(str_replace('_', ' ', $data['jenis_tagihan'])),
                'nominal' => $totalNominal
            ];
        }

        $data['nominal'] = $totalNominal;
        $data['no_tagihan'] = $this->model->generateNoTagihan();
        $data['total'] = $data['nominal'] + ($data['denda'] ?? 0);
        $data['sisa'] = $data['total'] - ($data['terbayar'] ?? 0);
        
        $db = \Config\Database::connect();
        $db->transStart();

        if (!$this->model->save($data)) {
            $db->transRollback();
            log_message('error', 'Tagihan Save Error: ' . json_encode($this->model->errors()));
            log_message('error', 'Tagihan Data: ' . json_encode($data));
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan tagihan: ' . implode(', ', $this->model->errors()));
        }
        
        $tagihanId = $this->model->getInsertID();
        
        // Save items
        foreach ($items as $item) {
            $item['tagihan_id'] = $tagihanId;
            $this->itemModel->insert($item);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan rincian tagihan');
        }
        
        return redirect()->to('/tagihan')->with('success', 'Tagihan berhasil dibuat');
    }

    public function view($id)
    {
        $db = \Config\Database::connect();
        $tagihan = $db->table('tagihan_keluarga')
            ->select('tagihan_keluarga.*, jenazah.nama_lengkap as nama_jenazah,
                      keluarga_jenazah.nama_lengkap as nama_keluarga, keluarga_jenazah.no_telepon,
                      pemakaman.no_makam, lokasi_makam.nama_blok')
            ->join('pemakaman', 'pemakaman.id = tagihan_keluarga.pemakaman_id')
            ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
            ->join('keluarga_jenazah', 'keluarga_jenazah.id = tagihan_keluarga.keluarga_id')
            ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id')
            ->where('tagihan_keluarga.id', $id)
            ->get()
            ->getRowArray();

        if (!$tagihan) {
            return redirect()->to('/tagihan')->with('error', 'Data tidak ditemukan');
        }

        // Get items
        $tagihan['items'] = $db->table('tagihan_keluarga_items')
            ->where('tagihan_id', $id)
            ->get()
            ->getResultArray();

        // Get pembayaran
        $tagihan['pembayaran'] = $db->table('pembayaran')
            ->where('tagihan_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Detail Tagihan',
            'breadcrumb' => [
                ['title' => 'Data Tagihan', 'url' => base_url('tagihan'), 'active' => false],
                ['title' => 'Detail', 'active' => true],
            ],
            'tagihan' => $tagihan,
        ];
        return view('tagihan/view', $data);
    }

    public function edit($id)
    {
        $tagihan = $this->model->find($id);
        if (!$tagihan) {
            return redirect()->to('/tagihan')->with('error', 'Data tidak ditemukan');
        }

        // Get items
        $tagihan['items'] = $this->itemModel->where('tagihan_id', $id)->findAll();

        $data = [
            'title' => 'Edit Tagihan',
            'breadcrumb' => [
                ['title' => 'Data Tagihan', 'url' => base_url('tagihan'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'tagihan' => $tagihan,
        ];
        return view('tagihan/edit', $data);
    }

    public function update($id)
    {
        $tagihan = $this->model->find($id);
        if (!$tagihan) {
            return redirect()->to('/tagihan')->with('error', 'Data tidak ditemukan');
        }

        $data = $this->request->getPost();
        
        // Handle items
        $itemNames = $this->request->getPost('item_name');
        $itemNominals = $this->request->getPost('item_nominal');
        
        $totalNominal = 0;
        $items = [];
        
        if ($itemNames && is_array($itemNames)) {
            foreach ($itemNames as $key => $name) {
                if (!empty($name)) {
                    $nominal = (float)($itemNominals[$key] ?? 0);
                    $totalNominal += $nominal;
                    $items[] = [
                        'tagihan_id' => $id,
                        'nama_item' => $name,
                        'nominal' => $nominal
                    ];
                }
            }
        }

        // If no items but nominal is provided
        if (empty($items) && !empty($data['nominal'])) {
            $totalNominal = (float)$data['nominal'];
            $items[] = [
                'tagihan_id' => $id,
                'nama_item' => 'Biaya ' . ucfirst(str_replace('_', ' ', $data['jenis_tagihan'])),
                'nominal' => $totalNominal
            ];
        }

        $data['id'] = $id;
        $data['nominal'] = $totalNominal;
        $data['total'] = $data['nominal'] + ($data['denda'] ?? 0);
        $data['sisa'] = $data['total'] - ($data['terbayar'] ?? $tagihan['terbayar']);

        $db = \Config\Database::connect();
        $db->transStart();

        if (!$this->model->save($data)) {
            $db->transRollback();
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }

        // Replace items
        $this->itemModel->where('tagihan_id', $id)->delete();
        if (!empty($items)) {
            $this->itemModel->insertBatch($items);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan rincian tagihan');
        }

        $this->model->updateStatus($id);
        return redirect()->to("/tagihan/view/{$id}")->with('success', 'Tagihan berhasil diperbarui');
    }

    public function delete($id)
    {
        $tagihan = $this->model->find($id);
        if (!$tagihan) {
            return redirect()->to('/tagihan')->with('error', 'Data tidak ditemukan');
        }

        if ($tagihan['terbayar'] > 0) {
            return redirect()->to('/tagihan')
                ->with('error', 'Tidak dapat menghapus tagihan yang sudah ada pembayaran');
        }

        $this->model->delete($id);
        return redirect()->to('/tagihan')->with('success', 'Tagihan berhasil dihapus');
    }
    public function pdf($id)
    {
        $db = \Config\Database::connect();
        $tagihan = $db->table('tagihan_keluarga')
            ->select('tagihan_keluarga.*, jenazah.nama_lengkap as nama_jenazah,
                      keluarga_jenazah.nama_lengkap as nama_keluarga, keluarga_jenazah.no_telepon,
                      pemakaman.no_makam, lokasi_makam.nama_blok')
            ->join('pemakaman', 'pemakaman.id = tagihan_keluarga.pemakaman_id')
            ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
            ->join('keluarga_jenazah', 'keluarga_jenazah.id = tagihan_keluarga.keluarga_id')
            ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id')
            ->where('tagihan_keluarga.id', $id)
            ->get()
            ->getRowArray();

        if (!$tagihan) {
            return redirect()->to('/tagihan')->with('error', 'Data tidak ditemukan');
        }

        // Get items
        $tagihan['items'] = $db->table('tagihan_keluarga_items')
            ->where('tagihan_id', $id)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Tagihan Pemakaman',
            'tagihan' => $tagihan
        ];

        // PDF Generation
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        
        $html = view('tagihan/pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = 'Tagihan_' . $tagihan['no_tagihan'] . '.pdf';
        $dompdf->stream($filename, ['Attachment' => false]);
    }
}
