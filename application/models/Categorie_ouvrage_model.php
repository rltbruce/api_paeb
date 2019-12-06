<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorie_ouvrage_model extends CI_Model {
    protected $table = 'categorie_ouvrage';

    public function add($categorie_ouvrage) {
        $this->db->set($this->_set($categorie_ouvrage))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $categorie_ouvrage) {
        $this->db->set($this->_set($categorie_ouvrage))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($categorie_ouvrage) {
        return array(
            'libelle'       =>      $categorie_ouvrage['libelle'],
            'description'   =>      $categorie_ouvrage['description']                       
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

}
