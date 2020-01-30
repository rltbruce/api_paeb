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
            'description'   =>      $transfert_daaf['description'],
            'montant'       =>      $transfert_daaf['montant'],
            'num_bordereau'   =>      $transfert_daaf['num_bordereau'],
            'date'          =>      $transfert_daaf['date'],
            'id_demande_rea_feffi'    =>  $transfert_daaf['id_demande_rea_feffi'],
            'id_compte_feffi'    =>  $transfert_daaf['id_compte_feffi']                       
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
                        ->order_by('description')
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
                        ->order_by('description')
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
