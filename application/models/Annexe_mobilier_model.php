<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Annexe_mobilier_model extends CI_Model {
    protected $table = 'annexe_mobilier';

    public function add($annexe_mobilier) {
        $this->db->set($this->_set($annexe_mobilier))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $annexe_mobilier) {
        $this->db->set($this->_set($annexe_mobilier))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($annexe_mobilier) {
        return array(
            'libelle'       =>      $annexe_mobilier['libelle'],
            'description'   =>      $annexe_mobilier['description'],
            'cout_mobilier'   =>      $annexe_mobilier['cout_mobilier'],
            'id_batiment_ouvrage'    => $annexe_mobilier['id_batiment_ouvrage']                       
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

    public function findBybatiment_ouvrage($id_batiment_ouvrage) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_batiment_ouvrage", $id_batiment_ouvrage)
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