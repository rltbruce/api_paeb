<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfert_ufp_model extends CI_Model {
    protected $table = 'transfert_ufp';

    public function add($transfert_ufp) {
        $this->db->set($this->_set($transfert_ufp))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $transfert_ufp) {
        $this->db->set($this->_set($transfert_ufp))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($transfert_ufp) {
        return array(
            'code'          =>      $transfert_ufp['code'],
            'description'   =>      $transfert_ufp['description'],
            'montant'       =>      $transfert_ufp['montant'],
            'num_facture'   =>      $transfert_ufp['num_facture'],
            'date'          =>      $transfert_ufp['date'],
            'id_demande_deblo_daaf'    =>  $transfert_ufp['id_demande_deblo_daaf']                       
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

    public function findAllBydemande_deblocage_daaf($id_demande_deblo_daaf) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_deblo_daaf", $id_demande_deblo_daaf)
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
