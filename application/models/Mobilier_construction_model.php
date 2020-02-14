<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobilier_construction_model extends CI_Model {
    protected $table = 'mobilier_construction';

    public function add($mobilier_construction) {
        $this->db->set($this->_set($mobilier_construction))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $mobilier_construction) {
        $this->db->set($this->_set($mobilier_construction))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mobilier_construction) {
        return array(
            'id_type_mobilier' => $mobilier_construction['id_type_mobilier'],
            'id_batiment_construction'=> $mobilier_construction['id_batiment_construction'],
            'cout_unitaire'=> $mobilier_construction['cout_unitaire'],
            'nbr_mobilier'=> $mobilier_construction['nbr_mobilier']);
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
                        ->order_by('id')
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

    public function findAllByBatiment($id_batiment_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_batiment_construction",$id_batiment_construction)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

  /*  public function supressionBydetail($id) {
        $this->db->where('id_convention_detail', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    } */

}
