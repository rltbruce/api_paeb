<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cout_divers_construction_model extends CI_Model {
    protected $table = 'cout_divers_construction';

    public function add($cout_divers_construction) {
        $this->db->set($this->_set($cout_divers_construction))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $cout_divers_construction) {
        $this->db->set($this->_set($cout_divers_construction))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($cout_divers_construction) {
        return array(
            'id_type_cout_divers'       =>      $cout_divers_construction['id_type_cout_divers'],
            'id_convention_detail'      =>      $cout_divers_construction['id_convention_detail'],
            'cout'               =>      $cout_divers_construction['cout']                       
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
        $this->db->select(" cout_divers_construction.id as id,
                            cout_divers_construction.cout as cout,
                            type_cout_divers.id as id_tcd,
                            type_cout_divers.description as description",FALSE);
                        
        $q =  $this->db->from('cout_divers_construction')

                    ->join('type_cout_divers', 'type_cout_divers.id = cout_divers_construction.id_type_cout_divers')      
                    ->get()
                    ->result();

            if($q)
            {
                return $q;
            }
            else
            {
                return null;
            }                  
    }

    public function findAll_by_convention_detail($id_convention_detail) 
    {               
        $this->db->select(" cout_divers_construction.id as id,
                            cout_divers_construction.cout as cout,
                            type_cout_divers.id as id_tcd,
                            type_cout_divers.description as description",FALSE);
                        
        $q =  $this->db->from('cout_divers_construction')

                    ->join('type_cout_divers', 'type_cout_divers.id = cout_divers_construction.id_type_cout_divers')  
                    ->where("id_convention_detail", $id_convention_detail)    
                    ->get()
                    ->result();

            if($q)
            {
                return $q;
            }
            else
            {
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