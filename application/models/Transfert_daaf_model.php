<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfert_daaf_model extends CI_Model {
    protected $table = 'transfert_daaf';

    public function add($transfert_daaf) {
        $this->db->set($this->_set($transfert_daaf))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $transfert_daaf) {
        $this->db->set($this->_set($transfert_daaf))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($transfert_daaf) {
        return array(
            'montant_transfert'       =>      $transfert_daaf['montant_transfert'],
            'frais_bancaire'       =>      $transfert_daaf['frais_bancaire'],
            'montant_total'   =>      $transfert_daaf['montant_total'],
            'date'       =>      $transfert_daaf['date'],
            'observation'       =>      $transfert_daaf['observation'],
            'id_demande_rea_feffi'    =>  $transfert_daaf['id_demande_rea_feffi']                       
        );
    }
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('date')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findAllByprogramme($id_demande_rea_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_rea_feffi", $id_demande_rea_feffi)
                        ->order_by('date')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    } 

}
