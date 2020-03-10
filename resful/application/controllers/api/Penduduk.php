<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Penduduk Controller
// Created by    : Mugi Rachmat
// Site          : www.infomugi.com
// Date          : 2019-03-28 11:41:59

class Penduduk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
       // $this->load->model('Site_model');
       // $this->load->model('Penduduk_model');
        date_default_timezone_set('Asia/Jakarta');
    }




    /* ----------------------------------------------------------------
    Nama 	: Index Penduduk
    Fungsi 	: Menampilkan Semua data pada tabel Penduduk
    ---------------------------------------------------------------- */
    public function index()
    {
        $penduduk = $this->Penduduk_model->get_all();
        $total = $this->Penduduk_model->get_total_rows();

        $response = array(
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'pageTitle' => 'Index Penduduk',
            'total_result' => $total,
            'data' => $penduduk,
        );

        echo $this->Site_model->json($response);
    }




    /* ----------------------------------------------------------------
    Nama 	: List Limit Penduduk
    Fungsi 	: Menampilkan Semua data dengan Limit pada tabel Penduduk
    Request 	: // start : (Inisasi Mulai Menampilkan Data Penduduk)
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Penduduk)
    // Method 	: POST
    ---------------------------------------------------------------- */
    public function listPenduduk()
    {
        $start = $this->input->post('start');
        $limit = $this->input->post('limit');
        $penduduk = $this->Penduduk_model->get_limit_data($limit,$start);
        $total = $this->Penduduk_model->get_total_rows();

        $response = array(
            'status' => 'success',
            'message' => 'Data retrieved successfully.',
            'pageTitle' => 'List Penduduk',
            'total_result' => $total,
            'data' => $penduduk,
        );

        echo $this->Site_model->json($response);

    }
    
    
    
    public function convert($code)
    {
        $userid = "1292019032113272_01gunungpuyuh";
        $password = "dHLpnVbuw6m3";
        $ip = "10.32.2.200";
        $url = "http://api.infomugi.com/ektp/basic/penduduk/detail";
        $contents = 'nik=' . $code . '&user_id=' . $userid . '&password=' . $password . '&ip_user=' . $ip;
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $contents);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec( $ch );      
        echo $response;
    }    




    /* ----------------------------------------------------------------
    Nama 	: Detail Penduduk
    Fungsi 	: Menampilkan detail data pada tabel Penduduk]
    Request 	: // id_penduduk : (Adalah Primary Key dari Tabel Penduduk)
    Method 	: POST
    ---------------------------------------------------------------- */
    public function view($nik)
    {
        $row = $this->Penduduk_model->get_by_nik($nik);
        if ($row) {

            $data = array(
              'NO_KK' => $row->NO_KK,
              'NIK' => $row->NIK,
              'NAMA_LGKP' => $row->NAMA_LGKP,
              'KAB_NAME' => $row->KAB_NAME,
              'AGAMA' => $row->AGAMA,
              'NO_RW' => $row->NO_RW,
              'KEC_NAME' => $row->KEC_NAME,
              'JENIS_PKRJN' => $row->JENIS_PKRJN,
              'NO_RT' => $row->NO_RT,
              'NO_KEL' => $row->NO_KEL,
              'ALAMAT' => $row->ALAMAT,
              'NO_KEC' => $row->NO_KEC,
              'TMPT_LHR' => $row->TMPT_LHR,
              'STATUS_KAWIN' => $row->STATUS_KAWIN,
              'NO_PROP' => $row->NO_PROP,
              'PROP_NAME' => $row->PROP_NAME,
              'NO_KAB' => $row->NO_KAB,
              'KEL_NAME' => $row->KEL_NAME,
              'JENIS_KLMIN' => $row->JENIS_KLMIN,
              'TGL_LHR' => $row->TGL_LHR,
          );

            $response = array(
                'content' => array($data),
                'copyright' => "Kementerian Dalam Negeri - Republik Indonesia",
            );

            echo $this->Site_model->json($response);

        } else {

            $response['STATUS'] = 0;
            $response['RESPONSE_DESC'] = 'Data Tidak Ditemukan';
            echo $this->Site_model->json($response);
        }
    }
    
    
    
    /* ----------------------------------------------------------------
    Nama 	: Detail Penduduk
    Fungsi 	: Menampilkan detail data pada tabel Penduduk]
    Request 	: // id_penduduk : (Adalah Primary Key dari Tabel Penduduk)
    Method 	: POST
    ---------------------------------------------------------------- */
    public function detail()
    {
        $nik = $this->input->post('nik');
        $user_id = $this->input->post('user_id');        
        $password = $this->input->post('password');        
        $ip_user = $this->input->post('ip_user');
        
        if($user_id=="1292019032113272_01gunungpuyuh" && $password=="dHLpnVbuw6m3" && $ip_user=="10.32.2.200" && $nik != NULL){
        
        $row = $this->Penduduk_model->get_by_nik($nik);
        if ($row) {

            $data = array(
              'NO_KK' => $row->NO_KK,
              'NIK' => $row->NIK,
              'NAMA_LGKP' => $row->NAMA_LGKP,
              'KAB_NAME' => $row->KAB_NAME,
              'AGAMA' => $row->AGAMA,
              'NO_RW' => $row->NO_RW,
              'KEC_NAME' => $row->KEC_NAME,
              'JENIS_PKRJN' => $row->JENIS_PKRJN,
              'NO_RT' => $row->NO_RT,
              'NO_KEL' => $row->NO_KEL,
              'ALAMAT' => $row->ALAMAT,
              'NO_KEC' => $row->NO_KEC,
              'TMPT_LHR' => $row->TMPT_LHR,
              'STATUS_KAWIN' => $row->STATUS_KAWIN,
              'NO_PROP' => $row->NO_PROP,
              'PROP_NAME' => $row->PROP_NAME,
              'NO_KAB' => $row->NO_KAB,
              'KEL_NAME' => $row->KEL_NAME,
              'JENIS_KLMIN' => $row->JENIS_KLMIN,
              'TGL_LHR' => $row->TGL_LHR,
          );

            $response = array(
                'content' => array($data),
                'copyright' => "Kementerian Dalam Negeri - Republik Indonesia",
            );

            echo $this->Site_model->json($response);

        } else {

            $response['STATUS'] = 0;
            $response['RESPONSE_DESC'] = 'Data Tidak Ditemukan';
            echo $this->Site_model->json($response);
        }
        
        }else{
            $response['STATUS'] = 0;
            $response['RESPONSE_DESC'] = 'Request Tidak Valid / Token Tidak Sesuai';
            echo $this->Site_model->json($response);
        }
        
    }    



    /* ----------------------------------------------------------------
    Nama 	: Pencarian Penduduk
    Fungsi 	: Mencari data pada tabel Penduduk
    Request 	: // start : (Inisasi Mulai Menampilkan Data Penduduk)
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Penduduk)
    	 	 	  // keyword : (Merupakan Kata Kunci dalam Pencarian Data Penduduk)
    // Method 	: POST
    ---------------------------------------------------------------- */
    public function search()
    {
        $start = $this->input->post('start');
        $limit = $this->input->post('limit');
        $keyword = $this->input->post('keyword');

        $row = $this->Penduduk_model->get_search($limit, $start, $keyword);
        if ($row) {
            $total = $this->Penduduk_model->get_total_rows($keyword);
            $response = array(
                'status' => 'success',
                'message' => 'Data retrieved successfully.',
                'pageTitle' => 'Search Penduduk',
                'total_result' => $total,
                'data' => $row,
            );

        } else {

            $response['status'] = 'failed';
            $response['message'] = 'Data '.$keyword.' not Found.';
        }
        echo $this->Site_model->json($response);
    }



    /* ----------------------------------------------------------------
    Nama 	: Simpan Penduduk
    Fungsi 	: Menambahkan data pada tabel Penduduk
    Request 	:
				 // NO_KK
				 // NIK
				 // NAMA_LGKP
				 // KAB_NAME
				 // AGAMA
				 // NO_RW
				 // KEC_NAME
				 // JENIS_PKRJN
				 // NO_RT
				 // NO_KEL
				 // ALAMAT
				 // NO_KEC
				 // TMPT_LHR
				 // STATUS_KAWIN
				 // NO_PROP
				 // PROP_NAME
				 // NO_KAB
				 // KEL_NAME
				 // JENIS_KLMIN
				 // TGL_LHR
    // Method 	: POST
    ---------------------------------------------------------------- */

    public function save()
    {
        $data = array(
          'NO_KK' => $this->input->post('NO_KK'),
          'NIK' => $this->input->post('NIK'),
          'NAMA_LGKP' => $this->input->post('NAMA_LGKP'),
          'KAB_NAME' => $this->input->post('KAB_NAME'),
          'AGAMA' => $this->input->post('AGAMA'),
          'NO_RW' => $this->input->post('NO_RW'),
          'KEC_NAME' => $this->input->post('KEC_NAME'),
          'JENIS_PKRJN' => $this->input->post('JENIS_PKRJN'),
          'NO_RT' => $this->input->post('NO_RT'),
          'NO_KEL' => $this->input->post('NO_KEL'),
          'ALAMAT' => $this->input->post('ALAMAT'),
          'NO_KEC' => $this->input->post('NO_KEC'),
          'TMPT_LHR' => $this->input->post('TMPT_LHR'),
          'STATUS_KAWIN' => $this->input->post('STATUS_KAWIN'),
          'NO_PROP' => $this->input->post('NO_PROP'),
          'PROP_NAME' => $this->input->post('PROP_NAME'),
          'NO_KAB' => $this->input->post('NO_KAB'),
          'KEL_NAME' => $this->input->post('KEL_NAME'),
          'JENIS_KLMIN' => $this->input->post('JENIS_KLMIN'),
          'TGL_LHR' => $this->input->post('TGL_LHR'),
      );


        if($data){
            $insert = $this->Penduduk_model->insert($data);
            $response = array(
                'status' => 'success',
                'message' => 'Data saved successfully.',
                'pageTitle' => 'Add Penduduk',
            );

        }else{

            $response['status'] = 'failed';
            $response['message'] = 'Data failed to save.';

        }
        echo $this->Site_model->json($response);
    }



    /* ----------------------------------------------------------------
    Nama 	: Edit Penduduk
    Fungsi 	: Memperbaharui data pada tabel Penduduk
    Request 	: // id_penduduk : (Adalah Primary Key dari Tabel Penduduk)
    Method 	: POST
    ---------------------------------------------------------------- */
    public function edit()
    {
        $id = $this->input->post('id_penduduk');
        $row = $this->Penduduk_model->get_by_id($id);

        if ($row) {

            $data = array(
              'NO_KK' => $this->input->post('NO_KK'),
              'NIK' => $this->input->post('NIK'),
              'NAMA_LGKP' => $this->input->post('NAMA_LGKP'),
              'KAB_NAME' => $this->input->post('KAB_NAME'),
              'AGAMA' => $this->input->post('AGAMA'),
              'NO_RW' => $this->input->post('NO_RW'),
              'KEC_NAME' => $this->input->post('KEC_NAME'),
              'JENIS_PKRJN' => $this->input->post('JENIS_PKRJN'),
              'NO_RT' => $this->input->post('NO_RT'),
              'NO_KEL' => $this->input->post('NO_KEL'),
              'ALAMAT' => $this->input->post('ALAMAT'),
              'NO_KEC' => $this->input->post('NO_KEC'),
              'TMPT_LHR' => $this->input->post('TMPT_LHR'),
              'STATUS_KAWIN' => $this->input->post('STATUS_KAWIN'),
              'NO_PROP' => $this->input->post('NO_PROP'),
              'PROP_NAME' => $this->input->post('PROP_NAME'),
              'NO_KAB' => $this->input->post('NO_KAB'),
              'KEL_NAME' => $this->input->post('KEL_NAME'),
              'JENIS_KLMIN' => $this->input->post('JENIS_KLMIN'),
              'TGL_LHR' => $this->input->post('TGL_LHR'),
          );


            if($data){

                $update = $this->Penduduk_model->update($id, $data);
                $response = array(
                    'status' => 'success',
                    'message' => 'Data saved successfully.',
                    'pageTitle' => 'Update Penduduk',
                );

            }else{

                $response['status'] = 'failed';
                $response['message'] = 'Data failed to save.';

            }

        } else {

            $response['status'] = 'failed';
            $response['message'] = 'Data not found.';
        }
        echo $this->Site_model->json($response);
    }




    /* ----------------------------------------------------------------
    Nama 	: Upload Penduduk
    Fungsi 	: Mengunggah file ke direktori dan disimpan di tabel Penduduk
    Method 	: POST
    ---------------------------------------------------------------- */
    public function upload()
    {
       $idBaru = $_POST['id_baru'];
       $target_path_folder = './images/penduduk/big/';
       echo $fileName = $idBaru.time().basename($_FILES['club_image']['name']);
       $imageName = $this->Penduduk_model->getImageName($idBaru);

       if($imageName != ''){
           $data = array(
               'image' => $imageName.','.$fileName,
           );
           $this->Penduduk_model->update(array('id' => $idBaru), $data);

       }else{
          $data = array(
              'image' => $fileName,
          );
          $this->Penduduk_model->update(array('id' => $idBaru), $data);

      }
      $target_path = $target_path_folder .$fileName;

      if(move_uploaded_file($_FILES['club_image']['tmp_name'], $target_path)) {

          $response['status'] = 'success';
          $response['message'] = 'Upload successfully.';

      } else{

         $response['status'] = 'failed';
         $response['message'] = 'Upload failed.';
     }

     echo $this->Site_model->json($response);
 }




/* ----------------------------------------------------------------
Nama 	: Hapus Penduduk
Fungsi 	: Menghapus data pada tabel Penduduk
Request 	: // id_penduduk : (Adalah Primary Key dari Tabel Penduduk)
Method 	: POST
---------------------------------------------------------------- */
public function delete()
{
    $id = $this->input->post('id_penduduk');
    $row = $this->Penduduk_model->get_by_id($id);

    if ($row) {
        $this->Penduduk_model->delete($id);
        $response = array(
            'status' => 'success',
            'message' => 'Data delete successfully.',
            'pageTitle' => 'Delete Penduduk',
        );

    } else {
        $response['status'] = 'failed';
        $response['message'] = 'Data not found.';
    }

    echo $this->Site_model->json($response);
}


    public function convertDisdik($code)
    {
        $userid = "867201911114juhana_3204";
        $password = "juhana_3204";
        $ip = "172.16.160.43";
        $url = "http://172.16.160.43:8080/dukcapil/get_json/32-04/disdik_3204/disdik_3204";
        $contents = 'nik=' . $code . '&user_id=' . $userid . '&password=' . $password . '&ip_user=' . $ip;
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $contents);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec( $ch );      
        echo $response;
    }    



}

