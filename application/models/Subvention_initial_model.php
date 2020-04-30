<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subvention_initial_model extends CI_Model {
    protected $table = 'subvention_initial';

    public function add($subvention_initial) {
        $this->db->set($this->_set($subvention_initial))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $subvention_initial) {
        $this->db->set($this->_set($subvention_initial))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($subvention_initial) {
        return array(
            'id_type_batiment' => $subvention_initial['id_type_batiment'],
            'id_type_latrine' => $subvention_initial['id_type_latrine'],
            'id_type_mobilier' => $subvention_initial['id_type_mobilier'],
            'id_type_cout_maitrise' => $subvention_initial['id_type_cout_maitrise'],
            'id_type_cout_sousprojet' => $subvention_initial['id_type_cout_sousprojet'],
            'id_acces_zone' => $subvention_initial['id_acces_zone'],
            'id_zone_subvention' => $subvention_initial['id_zone_subvention']);
            
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

    public function findAll()
    {               
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
    public function findByZone($id_zone_subvention,$id_acces_zone)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_zone_subvention',$id_zone_subvention)
                        ->where('id_acces_zone',$id_acces_zone)
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
