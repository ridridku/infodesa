<?php

class kontruksi_model extends MY_Model {

    protected $table = 'inventaris_desa';
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

    return $select;
}

  function datatables()
  {
    $this->datatables->select($this->_get_select());
    $this->datatables->from($this->table);
    $this->datatables->join($this->table_relation,'inventaris_desa.Kd_Desa = master_desa.Kd_Desa');
    $this->datatables->join('master_kecamatan','master_kecamatan.Kd_Kec = master_desa.Kd_Kec');
    $this->datatables->where('inventaris_desa.jenis_asset',6);
    if($this->session->userdata['level_id'] == 1){

    }else if($this->session->userdata['level_id'] == 2){
      $this->datatables->where('inventaris_desa.Kd_Kec',$this->session->userdata['kec_id']);
    }else if($this->session->userdata['level_id'] == 3){
      $this->datatables->where('inventaris_desa.Kd_Desa',$this->session->userdata['desa_id']);
    }
    return $this->datatables->generate();
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

}
