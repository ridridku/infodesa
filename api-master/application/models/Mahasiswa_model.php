<?php
    class Mahasiswa_model extends CI_model {
        public function getMahasiswa($id = null) {
            if($id === null) {

            $string_query="SELECT * FROM trx_qrspjurnal ";
            $d = $this->db->query($string_query);
	    return $d;
       
            } else {
                
              
          //  return $this->db->get_where('trx_qrspjurnal', ['id' => $id])->result_array();
          //  var_dump($id) or die();
            
         $kode_desa=($id.'.');
            $string_query="SELECT 
                            B.Kd_Desa as id,
                            B.Debet_,B.kredit_,SUM(D.JAnggaran) AS JAnggaran ,SUM(B.Debet),SUM(B.Kredit),
                            B.Jenis,B.Akun,B.Kd_Rincian,B.Nama_Jenis,B.Kelompok,B.Formula
                            FROM (SELECT v_jenis.*,
                            COALESCE(SUM(A.Debet),'0')as Debet_,
                            COALESCE(SUM(A.Kredit),'0') AS Kredit_,
                            A.Debet,
                            A.Kredit,
                            A.Kd_Rincian,A.Kd_Desa
                            FROM v_jenis
                            LEFT JOIN trx_qrspjurnal A ON SUBSTR(A.Kd_Rincian,1,6)=v_jenis.Jenis  AND A.Kd_Desa='$kode_desa'
                            GROUP BY v_jenis.Jenis,A.Kd_Desa )B 
                            LEFT JOIN qrpilihrekeningspp D ON SUBSTR(D.Kd_Rincian,1,6)=B.Jenis AND D.JAnggaran!='0'
                            WHERE D.Kd_Desa='$kode_desa' GROUP BY B.Jenis ";
                             // var_dump($string_query) or die();
			$d = $this->db->query($string_query);
			return $d->result_array();
            }
        }

        public function deleteMahasiswa($id) {
            $this->db->delete('mahasiswa', ['id' => $id]);
            return $this->db->affected_rows();
        }

        public function createMahasiswa($data) {
            $this->db->insert('mahasiswa', $data);
            return $this->db->affected_rows();
        } 

        public function updateMahasiswa($data, $id) {
            $this->db->update('mahasiswa', $data, ['id' => $id]);
            return $this->db->affected_rows();
        }
    }
?>