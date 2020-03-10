<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// Product Controller
class Product extends REST_Controller
{
    //Setting Request per hour per user/key

    function __construct()
    {
        parent::__construct();

        //Load Model Product
        $this->load->model('Product_model');

        //Konfigurasi Request Product
        $big = 100;
        $medium = 50;
        $small = 25;

        //Method Controller Product
        $this->methods['index_get']['limit'] = $big;
        $this->methods['listProduct_get']['limit'] = $big;
        $this->methods['view_get']['limit'] = $big;
        $this->methods['search_get']['limit'] = $big;
        $this->methods['save_get']['limit'] = $medium;
        $this->methods['edit_get']['limit'] = $medium;
        $this->methods['delete_get']['limit'] = $small;

    }




    /* ----------------------------------------------------------------
    Nama 	: Index Product
    Fungsi 	: Menampilkan Semua data pada tabel Product
    ---------------------------------------------------------------- */
    public function index_get()
    {
        $product = $this->Product_model->get_all();
        $total = $this->Product_model->get_total_rows();

        $response = array(
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'pageTitle' => 'Index Product',
            'total_result' => $total,
            'data' => $product,
        );

        $this->response($response, REST_Controller::HTTP_OK);
    }




    /* ----------------------------------------------------------------
    Nama 	: List Limit Product
    Fungsi 	: Menampilkan Semua data dengan Limit pada tabel Product
    Request 	: // start : (Inisasi Mulai Menampilkan Data Product)
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Product)
    // Method 	: POST
    ---------------------------------------------------------------- */
    public function listProduct_get()
    {
        $start = $this->input->post('start');
        $limit = $this->input->post('limit');
        $product = $this->Product_model->get_limit_data($limit,$start);
        $total = $this->Product_model->get_total_rows();

        $response = array(
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'pageTitle' => 'List Product',
            'total_result' => $total,
            'data' => $product,
        );

        $this->response($response, REST_Controller::HTTP_OK);

    }




    /* ----------------------------------------------------------------
    Nama 	: Detail Product
    Fungsi 	: Menampilkan detail data pada tabel Product]
    Request 	: // id_product : (Adalah Primary Key dari Tabel Product)
    Method 	: POST
    ---------------------------------------------------------------- */
    public function view_get()
    {
        $id = $this->input->post('id_product');
        $row = $this->Product_model->get_by_id($id);
        if ($row) {

            $data = array(
              'id_product' => $row->id_product,
              'code' => $row->code,
              'name' => $row->name,
              'description' => $row->description,
              'category_id' => $row->category_id,
              'sub_category_id' => $row->sub_category_id,
              'color' => $row->color,
              'size' => $row->size,
              'price' => $row->price,
              'image' => $row->image,
              'status' => $row->status,
              'stock' => $row->stock,
              'spesification' => $row->spesification,
              'weight' => $row->weight,
              'brand_id' => $row->brand_id,
              'views' => $row->views,
              'likes' => $row->likes,
              'discount' => $row->discount,
              'created_id' => $row->created_id,
              'update_id' => $row->update_id,
              'created_date' => $row->created_date,
              'update_date' => $row->update_date,
              'keyword' => $row->keyword,
              'abstrack' => $row->abstrack,
              'sales' => $row->sales,
              'rate' => $row->rate,
              'callus' => $row->callus,
              'video' => $row->video,
              'url' => $row->url,
              'dimension_width' => $row->dimension_width,
              'dimension_height' => $row->dimension_height,
              'dimension_length' => $row->dimension_length,
              'parent_id' => $row->parent_id,
              'unit_id' => $row->unit_id,
          );

            $response = array(
                'status' => 'success',
                'message' => 'Data retrieved successfully.',
                'pageTitle' => 'Detail Product',
                'data' => $data,
            );
            $this->response($response, REST_Controller::HTTP_OK);

        } else {

            $response['status'] = 'failed';
            $response['message'] = 'Data not Found.';
            $this->response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }



    /* ----------------------------------------------------------------
    Nama 	: Pencarian Product
    Fungsi 	: Mencari data pada tabel Product
    Request 	: // start : (Inisasi Mulai Menampilkan Data Product)
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Product)
    	 	 	  // keyword : (Merupakan Kata Kunci dalam Pencarian Data Product)
    // Method 	: POST
    ---------------------------------------------------------------- */
    public function search_get()
    {
        $start = $this->input->post('start');
        $limit = $this->input->post('limit');
        $keyword = $this->input->post('keyword');

        $row = $this->Product_model->get_search($limit, $start, $keyword);
        if ($row) {
            $total = $this->Product_model->get_total_rows($keyword);
            $response = array(
                'status' => 'success',
                'message' => 'Data retrieved successfully.',
                'pageTitle' => 'Search Product',
                'total_result' => $total,
                'data' => $row,
            );
            $this->response($response, REST_Controller::HTTP_OK);

        } else {

            $response['status'] = 'failed';
            $response['message'] = 'Data '.$keyword.' not Found.';
            $this->response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }



    /* ----------------------------------------------------------------
    Nama 	: Simpan Product
    Fungsi 	: Menambahkan data pada tabel Product
    Request 	:
				 // Code
				 // Name
				 // Description
				 // Category_id
				 // Sub_category_id
				 // Color
				 // Size
				 // Price
				 // Image
				 // Status
				 // Stock
				 // Spesification
				 // Weight
				 // Brand_id
				 // Views
				 // Likes
				 // Discount
				 // Created_id
				 // Update_id
				 // Created_date
				 // Update_date
				 // Keyword
				 // Abstrack
				 // Sales
				 // Rate
				 // Callus
				 // Video
				 // Url
				 // Dimension_width
				 // Dimension_height
				 // Dimension_length
				 // Parent_id
				 // Unit_id
    // Method 	: POST
    ---------------------------------------------------------------- */

    public function save_get()
    {
        $data = array(
          'code' => $this->input->post('code'),
          'name' => $this->input->post('name'),
          'description' => $this->input->post('description'),
          'category_id' => $this->input->post('category_id'),
          'sub_category_id' => $this->input->post('sub_category_id'),
          'color' => $this->input->post('color'),
          'size' => $this->input->post('size'),
          'price' => $this->input->post('price'),
          'image' => $this->input->post('image'),
          'status' => $this->input->post('status'),
          'stock' => $this->input->post('stock'),
          'spesification' => $this->input->post('spesification'),
          'weight' => $this->input->post('weight'),
          'brand_id' => $this->input->post('brand_id'),
          'views' => $this->input->post('views'),
          'likes' => $this->input->post('likes'),
          'discount' => $this->input->post('discount'),
          'created_id' => $this->input->post('created_id'),
          'update_id' => $this->input->post('update_id'),
          'created_date' => $this->input->post('created_date'),
          'update_date' => $this->input->post('update_date'),
          'keyword' => $this->input->post('keyword'),
          'abstrack' => $this->input->post('abstrack'),
          'sales' => $this->input->post('sales'),
          'rate' => $this->input->post('rate'),
          'callus' => $this->input->post('callus'),
          'video' => $this->input->post('video'),
          'url' => $this->input->post('url'),
          'dimension_width' => $this->input->post('dimension_width'),
          'dimension_height' => $this->input->post('dimension_height'),
          'dimension_length' => $this->input->post('dimension_length'),
          'parent_id' => $this->input->post('parent_id'),
          'unit_id' => $this->input->post('unit_id'),
      );


        if($data){
            $insert = $this->Product_model->insert($data);
            $response = array(
                'status' => 'success',
                'message' => 'Data saved successfully.',
                'pageTitle' => 'Add Product',
            );

            $this->set_response($response, REST_Controller::HTTP_CREATED);

        }else{

            $response['status'] = 'failed';
            $response['message'] = 'Data failed to save.';
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);

        }
    }



    /* ----------------------------------------------------------------
    Nama 	: Edit Product
    Fungsi 	: Memperbaharui data pada tabel Product
    Request 	: // id_product : (Adalah Primary Key dari Tabel Product)
    Method 	: POST
    ---------------------------------------------------------------- */
    public function edit_get()
    {
        $id = $this->input->post('id_product');
        $row = $this->Product_model->get_by_id($id);

        if ($row) {

            $data = array(
              'code' => $this->input->post('code'),
              'name' => $this->input->post('name'),
              'description' => $this->input->post('description'),
              'category_id' => $this->input->post('category_id'),
              'sub_category_id' => $this->input->post('sub_category_id'),
              'color' => $this->input->post('color'),
              'size' => $this->input->post('size'),
              'price' => $this->input->post('price'),
              'image' => $this->input->post('image'),
              'status' => $this->input->post('status'),
              'stock' => $this->input->post('stock'),
              'spesification' => $this->input->post('spesification'),
              'weight' => $this->input->post('weight'),
              'brand_id' => $this->input->post('brand_id'),
              'views' => $this->input->post('views'),
              'likes' => $this->input->post('likes'),
              'discount' => $this->input->post('discount'),
              'created_id' => $this->input->post('created_id'),
              'update_id' => $this->input->post('update_id'),
              'created_date' => $this->input->post('created_date'),
              'update_date' => $this->input->post('update_date'),
              'keyword' => $this->input->post('keyword'),
              'abstrack' => $this->input->post('abstrack'),
              'sales' => $this->input->post('sales'),
              'rate' => $this->input->post('rate'),
              'callus' => $this->input->post('callus'),
              'video' => $this->input->post('video'),
              'url' => $this->input->post('url'),
              'dimension_width' => $this->input->post('dimension_width'),
              'dimension_height' => $this->input->post('dimension_height'),
              'dimension_length' => $this->input->post('dimension_length'),
              'parent_id' => $this->input->post('parent_id'),
              'unit_id' => $this->input->post('unit_id'),
          );


            if($data){

                $update = $this->Product_model->update($id, $data);
                $response = array(
                    'status' => 'success',
                    'message' => 'Data saved successfully.',
                    'pageTitle' => 'Update Product',
                );
                $this->response($response, REST_Controller::HTTP_OK);

            }else{

                $response['status'] = 'failed';
                $response['message'] = 'Data failed to save.';
                $this->response($response, REST_Controller::HTTP_BAD_REQUEST);

            }

        } else {

            $response['status'] = 'failed';
            $response['message'] = 'Data not found.';
            $this->response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }



    /* ----------------------------------------------------------------
    Nama 	: Hapus Product
    Fungsi 	: Menghapus data pada tabel Product
    Request 	: // id_product : (Adalah Primary Key dari Tabel Product)
    Method 	: POST
    ---------------------------------------------------------------- */
    public function remove_get()
    {
        $id = $this->input->post('id_product');
        $row = $this->Product_model->get_by_id($id);

        if ($row) {
            $this->Product_model->delete($id);
            $response = array(
                'status' => 'success',
                'message' => 'Data delete successfully.',
                'pageTitle' => 'Delete Product',
            );
            $this->set_response($response, REST_Controller::HTTP_NO_CONTENT);

        } else {
            $response['status'] = 'failed';
            $response['message'] = 'Data not found.';
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

    }


}

