<?php

class inventaris_model extends MY_Model {

    protected $table = 'inventaris_desa';
    protected $table_mutasi = 'mutasi_inventaris';
    protected $table_jenis = 'master_jenis_inventaris';
    protected $table_relation = 'master_desa';
    protected $table_relation_kec = 'master_kecamatan';
    private $ci;

  function __construct()
  {
    parent::__construct();
  }

  private function _get_select(){
    $select = $this->table.".id, ";
    $select .= $this->table.".nama_barang, ";
    $select .= $this->table.".kode_barang, ";
    $select .= $this->table.".register, ";
    $select .= $this->table.".jenis_asset, ";
    // Digunakan untuk inv gedung
    $select .= $this->table.".kondisi_bangunan, ";
    $select .= $this->table.".kontruksi_bertingkat, ";
    $select .= $this->table.".kontruksi_beton, ";
    $select .= $this->table.".luas_bangunan, ";
    $select .= $this->table.".letak, ";
    $select .= $this->table.".tanggal_dokument, ";
    $select .= $this->table.".no_dokument, ";
    $select .= $this->table.".luas, ";
    $select .= $this->table.".status_tanah, ";
    $select .= $this->table.".kode_tanah, ";

    // inv Jalan
    $select .= $this->table.".kontruksi, ";
    $select .= $this->table.".panjang, ";
    $select .= $this->table.".lebar, ";
    $select .= $this->table.".luas, ";
    $select .= $this->table.".letak, ";
    $select .= $this->table.".tanggal_dokument, ";
    $select .= $this->table.".no_dokument, ";
    $select .= $this->table.".status_tanah, ";
    $select .= $this->table.".kode_tanah, ";
    $select .= $this->table.".kondisi, ";

    // inv peralatan
    $select .= $this->table.".merk, ";
    $select .= $this->table.".ukuran, ";
    $select .= $this->table.".bahan, ";
    $select .= $this->table.".tahun_pengadaan, ";
    $select .= $this->table.".no_pabrik, ";
    $select .= $this->table.".no_rangka, ";
    $select .= $this->table.".no_mesin, ";
    $select .= $this->table.".no_polisi, ";
    $select .= $this->table.".no_bpkb, ";

    // inv kontruksi
    $select .= $this->table.".kondisi_bangunan, ";
    $select .= $this->table.".kontruksi_bertingkat, ";
    $select .= $this->table.".kontruksi_beton, ";
    $select .= $this->table.".luas_bangunan, ";
    $select .= $this->table.".letak, ";
    $select .= $this->table.".tanggal_dokument, ";
    $select .= $this->table.".no_dokument, ";
    $select .= $this->table.".tanggal, ";
    $select .= $this->table.".status_tanah, ";
    $select .= $this->table.".kode_tanah, ";

    // inv tanah

    $select .= $this->table.".luas, ";
    $select .= $this->table.".tahun_pengadaan, ";
    $select .= $this->table.".letak, ";
    $select .= $this->table.".hak, ";
    $select .= $this->table.".no_sertifikat, ";
    $select .= $this->table.".tanggal_sertifikat, ";
    $select .= $this->table.".penggunaan, ";

    // asset
    $select .= $this->table.".jenis, ";
    $select .= $this->table.".judul_buku, ";
    $select .= $this->table.".spesifikasi_buku, ";
    $select .= $this->table.".asal_daerah, ";
    $select .= $this->table.".pencipta, ";
    $select .= $this->table.".bahan, ";
    $select .= $this->table.".jenis_hewan, ";
    $select .= $this->table.".ukuran_hewan, ";
    $select .= $this->table.".jenis_tumbuhan, ";
    $select .= $this->table.".ukuran_tumbuhan, ";
    $select .= $this->table.".jumlah, ";
    $select .= $this->table.".tahun_pengadaan, ";
    $select .= $this->table.".asal, ";
    $select .= $this->table.".harga, ";
    $select .= $this->table.".id_inventaris, ";
    $select .= $this->table.".Kd_Desa, ";
    $select .= $this->table.".keterangan, ";
    $select .= $this->table.".created_at, ";
    $select .= $this->table.".created_by, ";
    $select .= $this->table_relation.".Nama_Desa, ";
    $select .= $this->table_relation.".Kd_Kec, ";
    $select .= $this->table_relation_kec.".Nama_Kecamatan, ";
    $select .= $this->table_mutasi.".jenis_mutasi, ";
    $select .= $this->table_mutasi.".tahun_mutasi, ";
    $select .= $this->table_mutasi.".keterangan as keterangan_mutasi, ";
    $select .= $this->table_jenis.".nama_jenis_inventaris, ";

    return $select;
}

  function datatables($kec,$desa,$tahun,$jenis)
  {
    $this->datatables->select($this->_get_select());
    $this->datatables->from($this->table);
    $this->datatables->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
    $this->datatables->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
    $this->datatables->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
    $this->datatables->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
    if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
    if($kec == 'all'){
      if($tahun == 'all'){
          if($desa != 'null' && $jenis != 'all'){
              $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
              $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
          }else if($desa != 'null'){
              $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
          }else if($jenis != 'all'){
              $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
          }
      }else if( $tahun != 'all'){
          if($desa != 'null' && $jenis != 'all'){
              $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
              $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
          }else if($desa != 'null'){
              $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
          }else if($jenis != 'all'){
              $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
          }
          $this->datatables->where('inventaris_desa.tahun_pengadaan', $tahun);
      }
  }else if ($tahun == 'all'){
      if($kec == 'all'){
          if($desa != 'null' && $jenis != 'all'){
              $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
              $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
          }else if($desa != 'null'){
              $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
          }else if($jenis != 'all'){
              $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
          }
      }else if( $kec !=0){
          if($desa != 'null' && $jenis != 'all'){
              $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
              $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
          }else if($desa != 'null'){
              $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
          }else if($jenis != 'all'){
              $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
          }
          $this->datatables->like('inventaris_desa.Kd_Desa', $kec);
      }
  }else if ($kec == 'all' && $tahun == 'all'){
      if($desa != 'null' && $jenis != 'all'){
          $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
          $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
      }else if($desa != 'null'){
          $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
      }else if($jenis != 'all'){
          $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
      }
  }else{
      if($desa != 'null' && $jenis != 'all'){
          $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
          $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
      }else if($desa != 'null'){
          $this->datatables->where('inventaris_desa.Kd_Desa', $desa);
      }else if($jenis != 'all'){
          $this->datatables->where('inventaris_desa.jenis_asset', $jenis);
      }
      $this->datatables->like('inventaris_desa.Kd_Desa', $kec);
      $this->datatables->where('inventaris_desa.tahun_pengadaan', $tahun);
  }

  $this->datatables->where('inventaris_desa.visible',1);
    return $this->datatables->generate();
  }


  function datatables_laporan($kec,$desa)
  {
    $query = "SELECT
                    desa,n_desa,n_kec,
                    SUM(tanah) AS tanah,
                    SUM(peralatan) AS peralatan,
                    SUM(bangunan) AS bangunan,
                    SUM(jaringan) AS jaringan,
                    SUM(aset_lain) AS aset_lain,
                    SUM(kontruksi) AS kontruksi,
                    SUM(tanah)+ SUM(peralatan) +  SUM(bangunan) +  SUM(jaringan) + SUM(aset_lain) + SUM(kontruksi) AS total
                FROM
                (
                SELECT inventaris_desa.Kd_Desa as desa, master_desa.Nama_Desa as n_desa, master_kecamatan.Nama_Kecamatan as n_kec,
                    if(jenis_asset='1',sum(harga),0) as tanah,
                    if(jenis_asset='2',sum(harga),0) as peralatan,
                    if(jenis_asset='3',sum(harga),0) as bangunan,
                    if(jenis_asset='4',sum(harga),0) as jaringan,
                    if(jenis_asset='5',sum(harga),0) as aset_lain,
                    if(jenis_asset='6',sum(harga),0) as kontruksi
                FROM `inventaris_desa`
                JOIN `master_desa` ON inventaris_desa.Kd_Desa = master_desa.Kd_Desa
                JOIN `master_kecamatan` ON master_kecamatan.Kd_Kec = master_desa.Kd_Kec";

    // START KONDISI UNTUK MEMBATASI USER MELIHAT DATA
    if($this->session->userdata['level_id'] == 1){
    }else if($this->session->userdata['level_id'] == 2){
      $query .= " WHERE inventaris_desa.Kd_Kec = ".$this->session->userdata['kec_id'];
    }else if($this->session->userdata['level_id'] == 3){
      $query .= " WHERE inventaris_desa.Kd_Desa = ".$this->session->userdata['desa_id'];
    }
    // END KONDISI UNTUK MEMBATASI USER MELIHAT DATA

    // START KONDISI UNTUK PENCARIAN KECAMATAN, DESA, TAHUN
    if($kec == 'all'){

    }else if( $kec !=0){
        if($desa != 'null'){
            $query .= " AND inventaris_desa.Kd_Desa = ".$desa;
        }
            $query .= " AND inventaris_desa.Kd_Desa LIKE '%".$kec."%' ";
    }else{
        if($desa != 'null'){
            $query .= " AND inventaris_desa.Kd_Desa = ".$desa;
        }
            $query .= " AND inventaris_desa.Kd_Desa LIKE '%".$kec."%' ";
         }
    // END KONDISI UNTUK PENCARIAN KECAMATAN, DESA, TAHUN



$query .= " GROUP BY inventaris_desa.Kd_Desa, inventaris_desa.jenis_asset
            ) AS y
            GROUP BY desa,n_kec DESC;
            ";
    $query = $this->db->query($query);
    $query = $query->result();
    return $query;

  }

//   FUNGSI UNTUK CETAK

function cetak_keuangan($kec,$desa)
{
        $query = "SELECT
                        desa,n_desa,n_kec,
                        SUM(tanah) AS tanah,
                        SUM(peralatan) AS peralatan,
                        SUM(bangunan) AS bangunan,
                        SUM(jaringan) AS jaringan,
                        SUM(aset_lain) AS aset_lain,
                        SUM(kontruksi) AS kontruksi,
                        SUM(tanah)+ SUM(peralatan) +  SUM(bangunan) +  SUM(jaringan) + SUM(aset_lain) + SUM(kontruksi) AS total
                    FROM
                    (
                    SELECT inventaris_desa.Kd_Desa as desa, master_desa.Nama_Desa as n_desa, master_kecamatan.Nama_Kecamatan as n_kec,
                        if(jenis_asset='1',sum(harga),0) as tanah,
                        if(jenis_asset='2',sum(harga),0) as peralatan,
                        if(jenis_asset='3',sum(harga),0) as bangunan,
                        if(jenis_asset='4',sum(harga),0) as jaringan,
                        if(jenis_asset='5',sum(harga),0) as aset_lain,
                        if(jenis_asset='6',sum(harga),0) as kontruksi
                    FROM `inventaris_desa`
                    JOIN `master_desa` ON inventaris_desa.Kd_Desa = master_desa.Kd_Desa
                    JOIN `master_kecamatan` ON master_kecamatan.Kd_Kec = master_desa.Kd_Kec";

        // START KONDISI UNTUK MEMBATASI USER MELIHAT DATA
        if($this->session->userdata['level_id'] == 1){
        }else if($this->session->userdata['level_id'] == 2){
          $query .= " WHERE inventaris_desa.Kd_Kec = ".$this->session->userdata['kec_id'];
        }else if($this->session->userdata['level_id'] == 3){
          $query .= " WHERE inventaris_desa.Kd_Desa = ".$this->session->userdata['desa_id'];
        }
        // END KONDISI UNTUK MEMBATASI USER MELIHAT DATA

        // START KONDISI UNTUK PENCARIAN KECAMATAN, DESA, TAHUN
        if($kec == 'all'){

        }else if( $kec !=0){
            if($desa != 'null'){
                $query .= " AND inventaris_desa.Kd_Desa = ".$desa;
            }
                $query .= " AND inventaris_desa.Kd_Desa LIKE '%".$kec."%' ";
        }else{
            if($desa != 'null'){
                $query .= " AND inventaris_desa.Kd_Desa = ".$desa;
            }
                $query .= " AND inventaris_desa.Kd_Desa LIKE '%".$kec."%' ";
             }
        // END KONDISI UNTUK PENCARIAN KECAMATAN, DESA, TAHUN



    $query .= " GROUP BY inventaris_desa.Kd_Desa, inventaris_desa.jenis_asset
                ) AS y
                GROUP BY desa,n_kec DESC;
                ";
        $query = $this->db->query($query);
        $query = $query->result();
        return $query;
}


function cetak($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total, inventaris_desa.asal');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',5);
    $this->db->group_by('inventaris_desa.asal');

    $query = $this->db->get();
    return $query->result();
}



//   FUNGSI UNTUK CETAK

function lampiran_cetak($kec,$desa,$tahun,$jenis)
{
  $this->db->select($this->_get_select());
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
  if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
    $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
    $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',5);

    $query = $this->db->get();
    return $query->result();
}

function lampiran_cetak_gedung($kec,$desa,$tahun,$jenis)
{
  $this->db->select($this->_get_select());
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
  if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
    $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
    $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',3);

    $query = $this->db->get();
    return $query->result();
}

function lampiran_cetak_jalan($kec,$desa,$tahun,$jenis)
{
  $this->db->select($this->_get_select());
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
  if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
    $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
    $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',4);

    $query = $this->db->get();
    return $query->result();
}

function lampiran_cetak_kontruksi($kec,$desa,$tahun,$jenis)
{
  $this->db->select($this->_get_select());
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',6);

    $query = $this->db->get();
    return $query->result();
}

function lampiran_cetak_peralatan($kec,$desa,$tahun,$jenis)
{
  $this->db->select($this->_get_select());
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',2);

    $query = $this->db->get();
    return $query->result();
}

function lampiran_cetak_tanah($kec,$desa,$tahun,$jenis)
{
  $this->db->select($this->_get_select());
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',1);

    $query = $this->db->get();
    return $query->result();
}

// hitung asset berdasarkan inventaris gedung dan bangunan.

function cetak_gedung($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total, inventaris_desa.asal');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',3);
    $this->db->group_by('inventaris_desa.asal');

    $query = $this->db->get();
    return $query->result();
}

// hitung asset berdasarkan inventaris peralatan.

function cetak_peralatan($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total, inventaris_desa.asal');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',2);
    $this->db->group_by('inventaris_desa.asal');

    $query = $this->db->get();
    return $query->result();
}

// hitung asset berdasarkan inventaris jalan.

function cetak_jalan($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total, inventaris_desa.asal');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',4);
    $this->db->group_by('inventaris_desa.asal');

    $query = $this->db->get();
    return $query->result();
}

// hitung asset berdasarkan inventaris kontruksi.

function cetak_kontruksi($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total, inventaris_desa.asal');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',6);
    $this->db->group_by('inventaris_desa.asal');

    $query = $this->db->get();
    return $query->result();
}



// hitung asset berdasarkan inventaris tanah.

function cetak_tanah($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total, inventaris_desa.asal');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.jenis_asset',1);
    $this->db->group_by('inventaris_desa.asal');

    $query = $this->db->get();
    return $query->result();
}



//   FUNGSI UNTUK CETAK

function cetak_mutasi_baik($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',0);
    $this->db->where('inventaris_desa.jenis_asset',5);

    $query = $this->db->get();
    return $query->row();
}

//   FUNGSI UNTUK CETAK

function cetak_mutasi_rusak($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',5);

    $query = $this->db->get();
    return $query->row();
}


//   FUNGSI UNTUK CETAK

function bangunan_cetak_mutasi_baik($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',0);
    $this->db->where('inventaris_desa.jenis_asset',3);

    $query = $this->db->get();
    return $query->row();
}

//   FUNGSI UNTUK CETAK

function bangunan_cetak_mutasi_rusak($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',3);

    $query = $this->db->get();
    return $query->row();
}

//   FUNGSI UNTUK CETAK

function jalan_cetak_mutasi_baik($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',0);
    $this->db->where('inventaris_desa.jenis_asset',4);

    $query = $this->db->get();
    return $query->row();
}

//   FUNGSI UNTUK CETAK

function jalan_cetak_mutasi_rusak($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',4);

    $query = $this->db->get();
    return $query->row();
}



//   FUNGSI UNTUK CETAK

function kontruksi_cetak_mutasi_baik($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',0);
    $this->db->where('inventaris_desa.jenis_asset',6);

    $query = $this->db->get();
    return $query->row();
}

//   FUNGSI UNTUK CETAK

function kontruksi_cetak_mutasi_rusak($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',6);

    $query = $this->db->get();
    return $query->row();
}


//   FUNGSI UNTUK CETAK

function peralatan_cetak_mutasi_baik($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',0);
    $this->db->where('inventaris_desa.jenis_asset',2);

    $query = $this->db->get();
    return $query->row();
}

//   FUNGSI UNTUK CETAK

function peralatan_cetak_mutasi_rusak($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',2);

    $query = $this->db->get();
    return $query->row();
}


//   FUNGSI UNTUK CETAK

function tanah_cetak_mutasi_baik($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',0);
    $this->db->where('inventaris_desa.jenis_asset',1);

    $query = $this->db->get();
    return $query->row();
}

//   FUNGSI UNTUK CETAK

function tanah_cetak_mutasi_rusak($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',1);

    $query = $this->db->get();
    return $query->row();
}

//   FUNGSI UNTUK CETAK

function cetak_mutasi_asset($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total,mutasi_inventaris.jenis_mutasi');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',5);
    $this->db->group_by('mutasi_inventaris.jenis_mutasi');

    $query = $this->db->get();
    return $query->result();
}

function cetak_mutasi_gedung($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total,mutasi_inventaris.jenis_mutasi');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',3);
    $this->db->group_by('mutasi_inventaris.jenis_mutasi');

    $query = $this->db->get();
    return $query->result();
}

function cetak_mutasi_jalan($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total,mutasi_inventaris.jenis_mutasi');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',4);
    $this->db->group_by('mutasi_inventaris.jenis_mutasi');

    $query = $this->db->get();
    return $query->result();
}

function cetak_mutasi_kontruksi($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total,mutasi_inventaris.jenis_mutasi');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',6);
    $this->db->group_by('mutasi_inventaris.jenis_mutasi');

    $query = $this->db->get();
    return $query->result();
}

function cetak_mutasi_peralatan($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total,mutasi_inventaris.jenis_mutasi');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',2);
    $this->db->group_by('mutasi_inventaris.jenis_mutasi');

    $query = $this->db->get();
    return $query->result();
}

function cetak_mutasi_tanah($kec,$desa,$tahun,$jenis)
{
  $this->db->select('count(inventaris_desa.id) as total,mutasi_inventaris.jenis_mutasi');
  $this->db->from($this->table);
  $this->db->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
  $this->db->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
  $this->db->join('master_jenis_inventaris','master_jenis_inventaris.id_jenis_inventaris = inventaris_desa.jenis_asset');
  $this->db->join($this->table_mutasi,'inventaris_desa.id = mutasi_inventaris.id_inventaris','left');
   if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
  if($kec == 'all'){
    if($tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else if( $tahun != 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }
    }else if ($tahun == 'all'){
        if($kec == 'all'){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
        }else if( $kec !=0){
            if($desa != 'null' && $jenis != 'all'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }else if($desa != 'null'){
                $this->db->where('inventaris_desa.Kd_Desa', $desa);
            }else if($jenis != 'all'){
                $this->db->where('inventaris_desa.jenis_asset', $jenis);
            }
            $this->db->like('inventaris_desa.Kd_Desa', $kec);
        }
    }else if ($kec == 'all' && $tahun == 'all'){
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
    }else{
        if($desa != 'null' && $jenis != 'all'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }else if($desa != 'null'){
            $this->db->where('inventaris_desa.Kd_Desa', $desa);
        }else if($jenis != 'all'){
            $this->db->where('inventaris_desa.jenis_asset', $jenis);
        }
        $this->db->like('inventaris_desa.Kd_Desa', $kec);
        $this->db->where('inventaris_desa.tahun_pengadaan', $tahun);
    }

    $this->db->where('inventaris_desa.visible',1);
    $this->db->where('inventaris_desa.status',1);
    $this->db->where('inventaris_desa.jenis_asset',1);
    $this->db->group_by('mutasi_inventaris.jenis_mutasi');

    $query = $this->db->get();
    return $query->result();
}

    public function add($data)
    {
      $this->db->insert($this->table, $data);
      $inserted = $this->db->get_where($this->table, array('Kd_Kec' => $data['Kd_Kec']))->row();

      return $inserted;
    }

    public function delete($id)
    {
      $idString = (int)$id;
      $this->db->update($this->table, array('visible' => 0), array('No_Visi' => $idString));
      $id = $this->db->insert_id();
      $updated = $this->db->get_where($this->table, array('No_Visi' =>  $idString))->row();

      return $updated;
    }

    public function get_no_visi(){
      $this->db->select_max('No_Visi');
      $this->db->where($this->table.'.visible',1);
      $query = $this->db->get($this->table)->row();

      return $query;
    }

    public function get_by_id($id){
      $this->db->select('*');
      $this->db->where($this->table_relation.'.Kd_Desa',$id);
      $query = $this->db->get($this->table_relation)->row();

      return $query;
    }

    public function chart_inventaris()
	{
        // $this->db->select(')','jumlah');
		$this->db->select('count(inventaris_desa.created_at) as jumlah,inventaris_desa.created_at');
		$this->db->from($this->table);
        $this->db->where($this->table.'.visible',1);
        $this->db->group_by("DATE(inventaris_desa.created_at)");
		$data = $this->db->get()->result();
		return $data;
    }
    public function get_all_data()
	{
        // $this->db->select(')','jumlah');
		$this->db->select('count(inventaris_desa.id) as jumlah_data');
		$this->db->from($this->table);
        $this->db->where($this->table.'.visible',1);
		$data = $this->db->get()->row();
		return $data;
    }
    public function get_day_data()
	{
        // $this->db->select(')','jumlah');
		$this->db->select('count(inventaris_desa.id) as jumlah_data');
		$this->db->from($this->table);
        $this->db->where($this->table.'.visible',1);
        $this->db->where("DATE(inventaris_desa.created_at)",date('Y-m-d'));
        // $this->db->group_by("DATE(inventaris_desa.created_at)");
        // date('Y-m-d', strtotime(inventaris_desa.created_at))
		$data = $this->db->get()->row();
		return $data;
	}

}
