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
    function get_all()
    {
          $d = $this->db->query("SELECT * FROM 30072019_view_realisasi ");
                return $d;
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
