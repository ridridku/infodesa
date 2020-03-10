<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Product Model
class Product_model extends CI_Model
{

    public $table = 'product';
    public $id = 'id_product';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // datatables
        function json() {
            $this->datatables->select('id_product,code,name,description,category_id,sub_category_id,color,size,price,image,status,stock,spesification,weight,brand_id,views,likes,discount,created_id,update_id,created_date,update_date,keyword,abstrack,sales,rate,callus,video,url,dimension_width,dimension_height,dimension_length,parent_id,unit_id');
            $this->datatables->from('product');
        //add this line for join
        //$this->datatables->join('table2', 'product.field = table2.field');
            $this->datatables->add_column('action', anchor(site_url('product/read/$1'),'Read')." | ".anchor(site_url('product/update/$1'),'Update')." | ".anchor(site_url('product/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_product');
            return $this->datatables->generate();
        }

    
    /* ---------------------------------------------------------------- 
    Nama 	: Get Index All Product  
    Fungsi 	: Menampilkan semua data pada tabel Product
    ---------------------------------------------------------------- */
    function get_all($id = null,$tahun=null)
    {
		 $kode_desa=($id.'.');
		
			$string_query="SELECT a.Anggaran,a.KdPosting,a.Tahun,a.Kd_Rincian,max(a.KdPosting) as jml
							FROM ta_anggaran a WHERE a.Kd_Desa='$kode_desa' AND a.Tahun='$tahun' AND a.Kd_Rincian LIKE '4.%'";
			$d = $this->db->query($string_query);
							$row = $d->row(1);
							$jml=$row->jml;
		
						
						



            if($id === null) {

            $string_query="SELECT * FROM trx_qrspjurnal ";

			$d = $this->db->query($string_query);
			return $d;
       
            } else {
              
			 $kode_desa=($id.'.');
			 $string_query="SELECT 
				B.Tahun as tahun,
				B.Akun,
				B.Kelompok,
				B.Jenis,
				B.Formula,
				B.KdPosting,
				B.Nama_Jenis as nama_jenis,
				B.Nama_Kelompok,
				B.Kd_Desa,B.Tahun,
				B.AnggaranStlhPAK as apbdes,
				B.realisasi as realisasi
				FROM
				 (SELECT 
				A.Akun,
				A.Kelompok,
				A.Jenis,
				A.Nama_Jenis,
				A.Formula,
				A.NoLap,
				A.Nama_Kelompok,
				A.Obyek,
				A.KdPosting,
				A.Tahun,
				A.Anggaran,
				A.AnggaranPAK,
				A.AnggaranStlhPAK,
				A.Kd_SubRinci,
				spp.id,
				spp.JAnggaran,
				spp.JRealLalu,
				spp.Kd_Desa,
				(spp.JRealLalu+spp.JAnggaran) as realisasi,
				spp.Kd_Rincian
				FROM 
				(SELECT
				jenis.Akun,
				jenis.Kelompok,
				jenis.Jenis,
				jenis.Nama_Jenis,
				jenis.Formula,
				jenis.NoLap,
				jenis.Nama_Kelompok,
				jenis.Obyek,
				ang.KdPosting,
				ang.Tahun,
				ang.Anggaran,
				ang.AnggaranPAK,
				ang.AnggaranStlhPAK,
				ang.Kd_SubRinci
				FROM v_jenis jenis, ta_anggaran ang 
				where ang.Kd_Rincian = jenis.Obyek AND jenis.Jenis LIKE '4.%' AND ang.Kd_Desa='$kode_desa'  AND ang.KdPosting='$jml' AND ang.Tahun='2019' GROUP BY ang.Kd_Rincian)A,
				trx_spprincian spp WHERE spp.Kd_Rincian=A.Obyek AND spp.Kd_Desa='$kode_desa' and spp.Tahun='$tahun' AND spp.JRealLalu>0 GROUP BY spp.Kd_Rincian)B
				GROUP BY B.Kd_Rincian";

		
			
			$d = $this->db->query($string_query);
			return $d->result_array();

            }
        
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Detail Data Product  
    Fungsi 	: Menampilkan detail data pada tabel Product
    Ket 		: // id : (Adalah Primary Key dari Tabel Product) 
    ---------------------------------------------------------------- */
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
		
		
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Total Data Product  
    Fungsi 	: Menampilkan total data pada tabel Product
    Ket 		: // keyword : (Adalah kata kunci pencarian data pada tabel Product) 
    ---------------------------------------------------------------- */
    function get_total_rows($keyword = NULL) {
        $this->db->like('id_product', $keyword);
	$this->db->or_like('code', $keyword);
	$this->db->or_like('name', $keyword);
	$this->db->or_like('description', $keyword);
	$this->db->or_like('category_id', $keyword);
	$this->db->or_like('sub_category_id', $keyword);
	$this->db->or_like('color', $keyword);
	$this->db->or_like('size', $keyword);
	$this->db->or_like('price', $keyword);
	$this->db->or_like('image', $keyword);
	$this->db->or_like('status', $keyword);
	$this->db->or_like('stock', $keyword);
	$this->db->or_like('spesification', $keyword);
	$this->db->or_like('weight', $keyword);
	$this->db->or_like('brand_id', $keyword);
	$this->db->or_like('views', $keyword);
	$this->db->or_like('likes', $keyword);
	$this->db->or_like('discount', $keyword);
	$this->db->or_like('created_id', $keyword);
	$this->db->or_like('update_id', $keyword);
	$this->db->or_like('created_date', $keyword);
	$this->db->or_like('update_date', $keyword);
	$this->db->or_like('keyword', $keyword);
	$this->db->or_like('abstrack', $keyword);
	$this->db->or_like('sales', $keyword);
	$this->db->or_like('rate', $keyword);
	$this->db->or_like('callus', $keyword);
	$this->db->or_like('video', $keyword);
	$this->db->or_like('url', $keyword);
	$this->db->or_like('dimension_width', $keyword);
	$this->db->or_like('dimension_height', $keyword);
	$this->db->or_like('dimension_length', $keyword);
	$this->db->or_like('parent_id', $keyword);
	$this->db->or_like('unit_id', $keyword);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get List Limit Product  
    Fungsi 	: Menampilkan data dengan pengaturan jumlah tampil data Product
    Ket 		: // start : (Inisasi Mulai Menampilkan Data Product) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Product)
    ---------------------------------------------------------------- */
    function get_limit_data($limit, $start = 0) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_product');
	$this->db->or_like('code');
	$this->db->or_like('name');
	$this->db->or_like('description');
	$this->db->or_like('category_id');
	$this->db->or_like('sub_category_id');
	$this->db->or_like('color');
	$this->db->or_like('size');
	$this->db->or_like('price');
	$this->db->or_like('image');
	$this->db->or_like('status');
	$this->db->or_like('stock');
	$this->db->or_like('spesification');
	$this->db->or_like('weight');
	$this->db->or_like('brand_id');
	$this->db->or_like('views');
	$this->db->or_like('likes');
	$this->db->or_like('discount');
	$this->db->or_like('created_id');
	$this->db->or_like('update_id');
	$this->db->or_like('created_date');
	$this->db->or_like('update_date');
	$this->db->or_like('keyword');
	$this->db->or_like('abstrack');
	$this->db->or_like('sales');
	$this->db->or_like('rate');
	$this->db->or_like('callus');
	$this->db->or_like('video');
	$this->db->or_like('url');
	$this->db->or_like('dimension_width');
	$this->db->or_like('dimension_height');
	$this->db->or_like('dimension_length');
	$this->db->or_like('parent_id');
	$this->db->or_like('unit_id');
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Pencarian Product  
    Fungsi 	: Mencari data pada tabel Product
    Ket 	 	: // start : (Inisasi Mulai Menampilkan Data Product) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Product)
    	 	 	  // keyword : (Adalah kata kunci pencarian data pada tabel Product) 
    ---------------------------------------------------------------- */
    function get_search($limit, $start, $keyword) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_product', $keyword);
	$this->db->or_like('code', $keyword);
	$this->db->or_like('name', $keyword);
	$this->db->or_like('description', $keyword);
	$this->db->or_like('category_id', $keyword);
	$this->db->or_like('sub_category_id', $keyword);
	$this->db->or_like('color', $keyword);
	$this->db->or_like('size', $keyword);
	$this->db->or_like('price', $keyword);
	$this->db->or_like('image', $keyword);
	$this->db->or_like('status', $keyword);
	$this->db->or_like('stock', $keyword);
	$this->db->or_like('spesification', $keyword);
	$this->db->or_like('weight', $keyword);
	$this->db->or_like('brand_id', $keyword);
	$this->db->or_like('views', $keyword);
	$this->db->or_like('likes', $keyword);
	$this->db->or_like('discount', $keyword);
	$this->db->or_like('created_id', $keyword);
	$this->db->or_like('update_id', $keyword);
	$this->db->or_like('created_date', $keyword);
	$this->db->or_like('update_date', $keyword);
	$this->db->or_like('keyword', $keyword);
	$this->db->or_like('abstrack', $keyword);
	$this->db->or_like('sales', $keyword);
	$this->db->or_like('rate', $keyword);
	$this->db->or_like('callus', $keyword);
	$this->db->or_like('video', $keyword);
	$this->db->or_like('url', $keyword);
	$this->db->or_like('dimension_width', $keyword);
	$this->db->or_like('dimension_height', $keyword);
	$this->db->or_like('dimension_length', $keyword);
	$this->db->or_like('parent_id', $keyword);
	$this->db->or_like('unit_id', $keyword);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }    


    /* ---------------------------------------------------------------- 
    Nama 	: Simpan Product  
    Fungsi 	: Menyimpan data pada tabel Product
    ---------------------------------------------------------------- */
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Edit Product  
    Fungsi 	: Update data pada tabel Product
    ---------------------------------------------------------------- */
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Hapus Product  
    Fungsi 	: Delete data pada tabel Product
    ---------------------------------------------------------------- */
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}
