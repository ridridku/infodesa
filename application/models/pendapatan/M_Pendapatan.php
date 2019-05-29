<?php

class M_pendapatan extends MY_Model {

    protected $table = 'account';

    private $ci;

  function __construct()
  {
    parent::__construct();
  }

  function get_data(){
      	
		$result = $this->db->query("SELECT 
ref_desa.Nama_Desa as desa,
SUM(PEND.anggaran)as anggaran,
COALESCE(PEND.kredit, '0') as 'realisasi'
 FROM (SELECT 
REA1.kredit,
REA1.tahun,
ANG1.anggaran,
ANG1.JRealIni,
ANG1.JRealLalu,
ANG1.Kd_Desa,
ANG1.kode_kecamatan,
ANG1.Kd_Keg,
ANG1.Kd_Rincian,
ANG1.sub
 FROM (SELECT 
B.Kd_Desa,
SUBSTR(B.Kd_Desa,1,2)as kode_kecamatan,
B.Kd_Keg,
B.sub,
B.Kd_Rincian,
sum(B.JAnggaran)as anggaran,
B.JRealLalu,
B.JRealIni
 FROM (SELECT A.Tahun,
A.Kd_Desa,
A.Kd_Keg,
SUBSTR(A.Kd_Rincian,1,1) as sub,
A.Kd_Rincian,
A.JAnggaran,
A.JRealLalu,
A.JRealIni
 FROM QrRptRAPeriode A WHERE 1=1)B 
WHERE B.Kd_Rincian like '4.%'
GROUP BY B.Kd_Desa)ANG1
LEFT JOIN (SELECT QR1.Kd_Desa, QR1.Kd_Rincian,QR1.SUB,sum(QR1.Kredit)as kredit,QR1.Debet,QR1.Tahun FROM (SELECT
qrsp_jurnal.Kd_Source,
qrsp_jurnal.Tahun,
qrsp_jurnal.Kd_Desa,
qrsp_jurnal.Tgl_Bukti,
qrsp_jurnal.No_Bukti,
qrsp_jurnal.Kd_Rincian,

SUBSTR(Kd_Rincian,1,1) as SUB,
qrsp_jurnal.D_K,
qrsp_jurnal.Debet,
qrsp_jurnal.Kredit
FROM qrsp_jurnal  )QR1 where 1=1 AND QR1.Kd_Rincian LIKE '4.%' 
GROUP BY QR1.Kd_Desa )REA1 ON REA1.Kd_Desa=ANG1.Kd_Desa
WHERE 1=1)PEND 
left join ref_kecamatan ON ref_kecamatan.Kd_Kec=PEND.kode_kecamatan
left join ref_desa ON ref_desa.Kd_Desa=PEND.Kd_Desa
where PEND.kode_kecamatan='11'
GROUP BY PEND.Kd_Desa");
		return $result;
  }
  
  
  function get_chart_data($start_date, $end_date) {
        $sql = "SELECT 
ref_desa.Nama_Desa as desa,
SUM(PEND.anggaran)as anggaran,
COALESCE(PEND.kredit, '0') as 'realisasi'
 FROM (SELECT 
REA1.kredit,
REA1.tahun,
ANG1.anggaran,
ANG1.JRealIni,
ANG1.JRealLalu,
ANG1.Kd_Desa,
ANG1.kode_kecamatan,
ANG1.Kd_Keg,
ANG1.Kd_Rincian,
ANG1.sub
 FROM (SELECT 
B.Kd_Desa,
SUBSTR(B.Kd_Desa,1,2)as kode_kecamatan,
B.Kd_Keg,
B.sub,
B.Kd_Rincian,
sum(B.JAnggaran)as anggaran,
B.JRealLalu,
B.JRealIni
 FROM (SELECT A.Tahun,
A.Kd_Desa,
A.Kd_Keg,
SUBSTR(A.Kd_Rincian,1,1) as sub,
A.Kd_Rincian,
A.JAnggaran,
A.JRealLalu,
A.JRealIni
 FROM QrRptRAPeriode A WHERE 1=1)B 
WHERE B.Kd_Rincian like '4.%'
GROUP BY B.Kd_Desa)ANG1
LEFT JOIN (SELECT QR1.Kd_Desa, QR1.Kd_Rincian,QR1.SUB,sum(QR1.Kredit)as kredit,QR1.Debet,QR1.Tahun FROM (SELECT
qrsp_jurnal.Kd_Source,
qrsp_jurnal.Tahun,
qrsp_jurnal.Kd_Desa,
qrsp_jurnal.Tgl_Bukti,
qrsp_jurnal.No_Bukti,
qrsp_jurnal.Kd_Rincian,

SUBSTR(Kd_Rincian,1,1) as SUB,
qrsp_jurnal.D_K,
qrsp_jurnal.Debet,
qrsp_jurnal.Kredit
FROM qrsp_jurnal  )QR1 where 1=1 AND QR1.Kd_Rincian LIKE '4.%' 
GROUP BY QR1.Kd_Desa )REA1 ON REA1.Kd_Desa=ANG1.Kd_Desa
WHERE 1=1)PEND 
left join ref_kecamatan ON ref_kecamatan.Kd_Kec=PEND.kode_kecamatan
left join ref_desa ON ref_desa.Kd_Desa=PEND.Kd_Desa

GROUP BY PEND.Kd_Desa";
        $query = $this->db->query($sql);
        $results = $query->result();
        return $results;
    }
    
    
    
     public function getChartData_Angkatan(){	
		$query = $this->db->query("SELECT 
ref_desa.Nama_Desa as desa,
SUM(PEND.anggaran)as anggaran,
COALESCE(PEND.kredit, '0') as 'realisasi'
 FROM (SELECT 
REA1.kredit,
REA1.tahun,
ANG1.anggaran,
ANG1.JRealIni,
ANG1.JRealLalu,
ANG1.Kd_Desa,
ANG1.kode_kecamatan,
ANG1.Kd_Keg,
ANG1.Kd_Rincian,
ANG1.sub
 FROM (SELECT 
B.Kd_Desa,
SUBSTR(B.Kd_Desa,1,2)as kode_kecamatan,
B.Kd_Keg,
B.sub,
B.Kd_Rincian,
sum(B.JAnggaran)as anggaran,
B.JRealLalu,
B.JRealIni
 FROM (SELECT A.Tahun,
A.Kd_Desa,
A.Kd_Keg,
SUBSTR(A.Kd_Rincian,1,1) as sub,
A.Kd_Rincian,
A.JAnggaran,
A.JRealLalu,
A.JRealIni
 FROM QrRptRAPeriode A WHERE 1=1)B 
WHERE B.Kd_Rincian like '4.%'
GROUP BY B.Kd_Desa)ANG1
LEFT JOIN (SELECT QR1.Kd_Desa, QR1.Kd_Rincian,QR1.SUB,sum(QR1.Kredit)as kredit,QR1.Debet,QR1.Tahun FROM (SELECT
qrsp_jurnal.Kd_Source,
qrsp_jurnal.Tahun,
qrsp_jurnal.Kd_Desa,
qrsp_jurnal.Tgl_Bukti,
qrsp_jurnal.No_Bukti,
qrsp_jurnal.Kd_Rincian,

SUBSTR(Kd_Rincian,1,1) as SUB,
qrsp_jurnal.D_K,
qrsp_jurnal.Debet,
qrsp_jurnal.Kredit
FROM qrsp_jurnal  )QR1 where 1=1 AND QR1.Kd_Rincian LIKE '4.%' 
GROUP BY QR1.Kd_Desa )REA1 ON REA1.Kd_Desa=ANG1.Kd_Desa
WHERE 1=1)PEND 
left join ref_kecamatan ON ref_kecamatan.Kd_Kec=PEND.kode_kecamatan
left join ref_desa ON ref_desa.Kd_Desa=PEND.Kd_Desa

GROUP BY PEND.Kd_Desa");
		return $query;
    }

}
