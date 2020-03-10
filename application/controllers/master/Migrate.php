<?php

class Migrate extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->input->post('cancel-button'))
            redirect('auth/user/index');

        $this->load->language('auth');
        $this->template
        ->set_js(bower_url('datatables/media/js/jquery.dataTables.min'))
        ->set_js(bower_url('jquery-validation/dist/jquery.validate.min.js'));
    }

    public function index()
    {
        $this->load->vars(array(
            'page_title' => 'Migrasi Data Desa',
            'page_icon' => '<a class="btn btn-primary" href="' . site_url('master/migrate/add') . '"> <i class="fa fa-plus"></i> Tambah</a><br>',
            'ui_controller' => 'MasterKeluargaController',
        ));
        $this->template
            ->set_js('configs/datatables')
            ->build('master/migrate/index');
    }

    public function migration($desa_id)
    {
        $this->load->model('master/url_model');
        $this->load->model('master/inventaris_model');
        $url = $this->url_model->get_by_id($desa_id);


        $file = $url->url_desa.'/Api_inventaris/get_inventaris';
        $file_mutasi = $url->url_desa.'/Api_inventaris/get_mutasi_inventaris';
        $file_headers = @get_headers($file);
        $file_headers_mutasi = @get_headers($file_mutasi);

        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found' && !$file_headers_mutasi || $file_headers_mutasi[0] == 'HTTP/1.1 404 Not Found') {
            echo '<script>alert("URL Tidak Aktif");window.location="'.site_url().'/master/migrate"</script>';
            // redirect("master/migrate");
        }else if(!$file_headers || $file_headers[0] == 'HTTP/1.1 500 Internal Server Error' && !$file_headers_mutasi || $file_headers_mutasi[0] == 'HTTP/1.1 500 Internal Server Error') {
            echo '<script>alert("URL Tidak Aktif");window.location="'.site_url().'/master/migrate"</script>';
            // redirect("master/migrate");
        }
        else {
            $data = $this->inventaris_model->delete_data($url->Kd_Desa);
            $data2 = $this->inventaris_model->delete_data_mutasi($url->Kd_Desa);
             // Get Inventariss
            $data = file_get_contents($file);
            $result = json_decode($data);
            // Get Mutasi Inventaris
            $data1 = file_get_contents($file_mutasi);
            $result1 = json_decode($data1);

            foreach($result->inventaris_asset as $data_i)
            {
                $data = $this->inventaris_model->add(array(
                    'id' => $url->Kd_Desa.'5'.$data_i->id,
                    'id_inventaris' =>$data_i->id,
                    'Kd_Kec' => $url->Kd_Kec,
                    'Kd_Desa' => $url->Kd_Desa,
                    'jenis_asset' => 5,
                    'nama_barang' => $data_i->nama_barang,
                    'kode_barang' => $data_i->kode_barang,
                    'register' => $data_i->register,
                    'jenis' => $data_i->jenis,
                    'judul_buku' => $data_i->judul_buku,
                    'spesifikasi_buku' => $data_i->spesifikasi_buku,
                    'asal_daerah' => $data_i->asal_daerah,
                    'pencipta' => $data_i->pencipta,
                    'bahan' => $data_i->bahan,
                    'jenis_hewan' => $data_i->jenis_hewan,
                    'ukuran_hewan' => $data_i->ukuran_hewan,
                    'jenis_tumbuhan' => $data_i->jenis_tumbuhan,
                    'ukuran_tumbuhan' => $data_i->ukuran_tumbuhan,
                    'jumlah' => $data_i->jumlah,
                    'tahun_pengadaan' => $data_i->tahun_pengadaan,
                    'asal' => $data_i->asal,
                    'harga' => $data_i->harga,
                    'keterangan' => $data_i->keterangan,
                    'created_at' => $data_i->created_at,
                    'created_by' => $data_i->created_by,
                    'visible' => $data_i->visible,
                    'status' => $data_i->status
                    ));
                if ($data) $_SESSION['success']=1;
            }
            foreach($result1->inventaris_asset as $data_mutasi)
            {
                $data = $this->inventaris_model->add_mutasi(array(
                    'id_inventaris' =>$url->Kd_Desa.'5'.$data_mutasi->id_inventaris_asset,
                    'Kd_Desa' => $url->Kd_Desa,
                    'tahun_mutasi' => $data_mutasi->tahun_mutasi,
                    'jenis_mutasi' => $data_mutasi->jenis_mutasi,
                    'harga_jual' => $data_mutasi->harga_jual,
                    'sumbangkan' => $data_mutasi->sumbangkan,
                    'keterangan' => $data_mutasi->keterangan,
                    'created_by' => $data_mutasi->created_by,
                    'visible' => 1
                    ));
                if ($data) $_SESSION['success']=1;
            }
            foreach($result->inventaris_gedung as $data_i)
            {
                $data = $this->inventaris_model->add(array(
                    'id' => $url->Kd_Desa.'3'.$data_i->id,
                    'id_inventaris' =>$data_i->id,
                    'Kd_Kec' => $url->Kd_Kec,
                    'Kd_Desa' => $url->Kd_Desa,
                    'jenis_asset' => 3,
                    'nama_barang' => $data_i->nama_barang,
                    'kode_barang' => $data_i->kode_barang,
                    'register' => $data_i->register,
                    'kondisi_bangunan' => $data_i->kondisi_bangunan,
                    'kontruksi_bertingkat' => $data_i->kontruksi_bertingkat,
                    'kontruksi_beton' => $data_i->kontruksi_beton,
                    'luas_bangunan' => $data_i->luas_bangunan,
                    'letak' => $data_i->letak,
                    'no_dokument' => $data_i->no_dokument,
                    'tahun_pengadaan' => date('Y',strtotime($data_i->tanggal_dokument)),
                    'tanggal_dokument' => $data_i->tanggal_dokument,
                    'status_tanah' => $data_i->status_tanah,
                    'luas' => $data_i->luas,
                    'kode_tanah' => $data_i->kode_tanah,
                    'asal' => $data_i->asal,
                    'harga' => $data_i->harga,
                    'keterangan' => $data_i->keterangan,
                    'created_at' => $data_i->created_at,
                    'created_by' => $data_i->created_by,
                    'visible' => $data_i->visible,
                    'status' => $data_i->status
                    ));
                if ($data) $_SESSION['success']=1;
            }
            foreach($result1->inventaris_gedung as $data_mutasi)
            {
                $data = $this->inventaris_model->add_mutasi(array(
                    'id_inventaris' =>$url->Kd_Desa.'3'.$data_mutasi->id_inventaris_gedung,
                    'Kd_Desa' => $url->Kd_Desa,
                    'tahun_mutasi' => $data_mutasi->tahun_mutasi,
                    'jenis_mutasi' => $data_mutasi->jenis_mutasi,
                    'harga_jual' => $data_mutasi->harga_jual,
                    'sumbangkan' => $data_mutasi->sumbangkan,
                    'keterangan' => $data_mutasi->keterangan,
                    'created_by' => $data_mutasi->created_by,
                    'visible' => 1
                    ));
                if ($data) $_SESSION['success']=1;
            }
            foreach($result->inventaris_tanah as $data_i)
            {
                $data = $this->inventaris_model->add(array(
                    'id' => $url->Kd_Desa.'1'.$data_i->id,
                    'id_inventaris' =>$data_i->id,
                    'Kd_Kec' => $url->Kd_Kec,
                    'Kd_Desa' => $url->Kd_Desa,
                    'jenis_asset' => 1,
                    'nama_barang' => $data_i->nama_barang,
                    'kode_barang' => $data_i->kode_barang,
                    'register' => $data_i->register,
                    'luas' => $data_i->luas,
                    'tahun_pengadaan' => $data_i->tahun_pengadaan,
                    'letak' => $data_i->letak,
                    'hak' => $data_i->hak,
                    'no_sertifikat' => $data_i->no_sertifikat,
                    'tanggal_sertifikat' => $data_i->tanggal_sertifikat,
                    'penggunaan' => $data_i->penggunaan,
                    'asal' => $data_i->asal,
                    'harga' => $data_i->harga,
                    'keterangan' => $data_i->keterangan,
                    'created_at' => $data_i->created_at,
                    'created_by' => $data_i->created_by,
                    'visible' => $data_i->visible,
                    'status' => $data_i->status
                    ));
                if ($data) $_SESSION['success']=1;
            }
            foreach($result1->inventaris_tanah as $data_mutasi)
            {
                $data = $this->inventaris_model->add_mutasi(array(
                    'id_inventaris' =>$url->Kd_Desa.'1'.$data_mutasi->id_inventaris_tanah,
                    'Kd_Desa' => $url->Kd_Desa,
                    'tahun_mutasi' => $data_mutasi->tahun_mutasi,
                    'jenis_mutasi' => $data_mutasi->jenis_mutasi,
                    'harga_jual' => $data_mutasi->harga_jual,
                    'sumbangkan' => $data_mutasi->sumbangkan,
                    'keterangan' => $data_mutasi->keterangan,
                    'created_by' => $data_mutasi->created_by,
                    'visible' => 1
                    ));
                if ($data) $_SESSION['success']=1;
            }
            foreach($result->inventaris_peralatan as $data_i)
            {
                $data = $this->inventaris_model->add(array(
                    'id' => $url->Kd_Desa.'2'.$data_i->id,
                    'id_inventaris' =>$data_i->id,
                    'Kd_Kec' => $url->Kd_Kec,
                    'Kd_Desa' => $url->Kd_Desa,
                    'jenis_asset' => 2,
                    'nama_barang' => $data_i->nama_barang,
                    'kode_barang' => $data_i->kode_barang,
                    'register' => $data_i->register,
                    'merk' => $data_i->merk,
                    'ukuran' => $data_i->ukuran,
                    'bahan' => $data_i->bahan,
                    'tahun_pengadaan' => $data_i->tahun_pengadaan,
                    'no_pabrik' => $data_i->no_pabrik,
                    'no_rangka' => $data_i->no_rangka,
                    'no_mesin' => $data_i->no_mesin,
                    'no_polisi' => $data_i->no_polisi,
                    'no_bpkb' => $data_i->no_bpkb,
                    'asal' => $data_i->asal,
                    'harga' => $data_i->harga,
                    'keterangan' => $data_i->keterangan,
                    'created_at' => $data_i->created_at,
                    'created_by' => $data_i->created_by,
                    'visible' => $data_i->visible,
                    'status' => $data_i->status
                    ));
                if ($data) $_SESSION['success']=1;
            }
            foreach($result1->inventaris_peralatan as $data_mutasi)
            {
                $data = $this->inventaris_model->add_mutasi(array(
                    'id_inventaris' =>$url->Kd_Desa.'2'.$data_mutasi->id_inventaris_peralatan,
                    'Kd_Desa' => $url->Kd_Desa,
                    'tahun_mutasi' => $data_mutasi->tahun_mutasi,
                    'jenis_mutasi' => $data_mutasi->jenis_mutasi,
                    'harga_jual' => $data_mutasi->harga_jual,
                    'sumbangkan' => $data_mutasi->sumbangkan,
                    'keterangan' => $data_mutasi->keterangan,
                    'created_by' => $data_mutasi->created_by,
                    'visible' => 1
                    ));
                if ($data) $_SESSION['success']=1;
            }
            
            foreach($result->inventaris_jalan as $data_i)
            {
                $data = $this->inventaris_model->add(array(
                    'id' => $url->Kd_Desa.'4'.$data_i->id,
                    'id_inventaris' =>$data_i->id,
                    'Kd_Kec' => $url->Kd_Kec,
                    'Kd_Desa' => $url->Kd_Desa,
                    'jenis_asset' => 4,
                    'nama_barang' => $data_i->nama_barang,
                    'kode_barang' => $data_i->kode_barang,
                    'register' => $data_i->register,
                    'kondisi' =>  $data_i->kondisi,
                    'kontruksi' =>  $data_i->kontruksi,
                    'panjang' =>  $data_i->panjang,
                    'lebar' => $data_i->lebar,
                    'luas' =>  $data_i->luas,
                    'letak' =>  $data_i->letak,
                    'no_dokument' =>  $data_i->no_dokument,
                    'tahun_pengadaan' => date('Y',strtotime($data_i->tanggal_dokument)),
                    'tanggal_dokument' =>  $data_i->tanggal_dokument,
                    'status_tanah' =>  $data_i->status_tanah,
                    'kode_tanah' =>  $data_i->register,
                    'asal' => $data_i->asal,
                    'harga' => $data_i->harga,
                    'keterangan' => $data_i->keterangan,
                    'created_at' => $data_i->created_at,
                    'created_by' => $data_i->created_by,
                    'visible' => $data_i->visible,
                    'status' => $data_i->status
                    ));
                if ($data) $_SESSION['success']=1;
            }
            foreach($result1->inventaris_jalan as $data_mutasi)
            {
                $data = $this->inventaris_model->add_mutasi(array(
                    'id_inventaris' =>$url->Kd_Desa.'4'.$data_mutasi->id_inventaris_jalan,
                    'Kd_Desa' => $url->Kd_Desa,
                    'tahun_mutasi' => $data_mutasi->tahun_mutasi,
                    'jenis_mutasi' => $data_mutasi->jenis_mutasi,
                    'harga_jual' => $data_mutasi->harga_jual,
                    'sumbangkan' => $data_mutasi->sumbangkan,
                    'keterangan' => $data_mutasi->keterangan,
                    'created_by' => $data_mutasi->created_by,
                    'visible' => 1
                    ));
                if ($data) $_SESSION['success']=1;
            }
            foreach($result->inventaris_kontruksi as $data_i)
            {
                $data = $this->inventaris_model->add(array(
                    'id' => $url->Kd_Desa.'6'.$data_i->id,
                    'id_inventaris' =>$data_i->id,
                    'Kd_Kec' => $url->Kd_Kec,
                    'Kd_Desa' => $url->Kd_Desa,
                    'jenis_asset' => 6,
                    'nama_barang' => $data_i->nama_barang,
                    'kondisi_bangunan' => $data_i->kondisi_bangunan,
                    'kontruksi_bertingkat' => $data_i->kontruksi_bertingkat,
                    'kontruksi_beton' => $data_i->kontruksi_beton,
                    'luas_bangunan' => $data_i->luas_bangunan,
                    'letak' => $data_i->letak,
                    'no_dokument' => $data_i->no_dokument,
                    'tahun_pengadaan' => date('Y',strtotime($data_i->tanggal_dokument)),
                    'tanggal_dokument' => $data_i->tanggal_dokument,
                    'tanggal' => $data_i->tanggal,
                    'status_tanah' => $data_i->status_tanah,
                    'kode_tanah' => $data_i->kode_tanah,
                    'asal' => $data_i->asal,
                    'harga' => $data_i->harga,
                    'keterangan' => $data_i->keterangan,
                    'created_at' => $data_i->created_at,
                    'created_by' => $data_i->created_by,
                    'visible' => $data_i->visible,
                    'status' => $data_i->status
                    ));
                if ($data) $_SESSION['success']=1;
            }
            $data = $this->inventaris_model->update_date($url->Kd_Desa);
            redirect("master/migrate");
        }
    }

}


