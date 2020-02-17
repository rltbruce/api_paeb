<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Batiment_construction_model extends CI_Model {
    protected $table = 'batiment_construction';

    public function add($batiment_construction) {
        $this->db->set($this->_set($batiment_construction))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $batiment_construction) {
        $this->db->set($this->_set($batiment_construction))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($batiment_construction) {
        return array(
            'id_type_batiment' => $batiment_construction['id_type_batiment'],
            'id_convention_detail'=> $batiment_construction['id_convention_detail'],
            'cout_unitaire'=> $batiment_construction['cout_unitaire'],
            'nbr_batiment'=> $batiment_construction['nbr_batiment']);
            
    }
   /* public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }*/

    public function delete($id) {
        $this->db->from($this->table)
                ->join('latrine_construction', 'latrine_construction.id_batiment_construction = batiment_construction.id')
                ->join('mobilier_construction', 'mobilier_construction.id_batiment_construction = batiment_construction.id')
                ->where('batiment_construction.id', (int) $id)
        ->delete($this->table);
                    ;
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

    public function findAllByDetail($id_convention_detail) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_detail",$id_convention_detail)
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
 

}
