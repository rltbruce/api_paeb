<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class prestataire_model extends CI_Model {
    protected $table = 'prestataire';

    public function add($prestataire) {
        $this->db->set($this->_set($prestataire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $prestataire) {
        $this->db->set($this->_set($prestataire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($prestataire) {
        return array(
            'code'  => $prestataire['code'],
            'nom'   => $prestataire['nom'],
            'nif'   => $prestataire['nif'],
            'stat'  => $prestataire['stat'],
            'siege' => $prestataire['siege']                       
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
