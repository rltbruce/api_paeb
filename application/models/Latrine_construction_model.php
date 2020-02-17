<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Latrine_construction_model extends CI_Model {
    protected $table = 'latrine_construction';

    public function add($latrine_construction) {
        $this->db->set($this->_set($latrine_construction))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $latrine_construction) {
        $this->db->set($this->_set($latrine_construction))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($latrine_construction) {
        return array(
            'id_type_latrine' => $latrine_construction['id_type_latrine'],            
            'id_batiment_construction'=> $latrine_construction['id_batiment_construction'],
            'cout_unitaire'=> $latrine_construction['cout_unitaire'],
            'nbr_latrine'=> $latrine_construction['nbr_latrine']);
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
