<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zap_model extends CI_Model {
    protected $table = 'zap';

    public function add($zap) {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($zap))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $zap) {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($zap))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($zap) {
		// Affectation des valeurs
        return array(
            'code'       =>  $zap['code'],
            'nom'        =>  $zap['nom'],
            'latitude'   =>  $zap['latitude'],
            'longitude'  =>  $zap['longitude'],
            'id_commune' =>  $zap['id_commune']                       
        );
    }
    public function delete($id) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('nom')
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
?>