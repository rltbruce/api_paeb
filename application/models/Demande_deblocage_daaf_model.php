<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_deblocage_daaf_model extends CI_Model {
    protected $table = 'demande_deblocage_daaf';

    public function add($demande_deblocage_daaf) {
        $this->db->set($this->_set($demande_deblocage_daaf))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_deblocage_daaf) {
        $this->db->set($this->_set($demande_deblocage_daaf))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($demande_deblocage_daaf) {
        return array(
            'code'          =>      $demande_deblocage_daaf['code'],
            'description'   =>      $demande_deblocage_daaf['description'],
            'date'          =>      $demande_deblocage_daaf['date'],
            'id_convention_ufpdaaf'    =>  $demande_deblocage_daaf['id_convention_ufpdaaf']                       
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
                        ->order_by('objet')
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

    public function findAllByconvention_ufpdaaf($id_convention_ufpdaaf) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_ufpdaaf", $id_convention_ufpdaaf)
                        ->order_by('objet')
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
