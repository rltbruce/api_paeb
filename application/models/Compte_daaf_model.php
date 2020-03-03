<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compte_daaf_model extends CI_Model {
    protected $table = 'compte_daaf';

    public function add($compte_daaf) {
        $this->db->set($this->_set($compte_daaf))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $compte_daaf) {
        $this->db->set($this->_set($compte_daaf))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($compte_daaf) {
        return array(
            'rib'          =>      $compte_daaf['rib'],
            'nom_banque'          =>      $compte_daaf['nom_banque'],
            'numero_compte'           =>      $compte_daaf['numero_compte'],
            'adresse_banque'          =>      $compte_daaf['adresse_banque']                       
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
                        ->order_by('nom_banque')
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

}
