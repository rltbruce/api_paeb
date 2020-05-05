<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avenant_convention_model extends CI_Model {
    protected $table = 'avenant_convention';

    public function add($avenant_convention) {
        $this->db->set($this->_set($avenant_convention))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avenant_convention) {
        $this->db->set($this->_set($avenant_convention))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avenant_convention) {
        return array(

            'description' => $avenant_convention['description'],
            'montant'    => $avenant_convention['montant'],
            'date_signature' => $avenant_convention['date_signature'],
            'id_convention_entete' => $avenant_convention['id_convention_entete'],
            'validation' => $avenant_convention['validation']                       
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
                        ->order_by('date_signature')
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

    public function findAllinvalideByconvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
                        ->where("validation", 0)
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
    public function countAvenantByIdconvention($id_convention_entete)  {
        $this->db->select('count(id) as nbr')
                    ->where("id_convention_entete", $id_convention_entete)
                    ->where("validation", 0);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function getavenantvalideByconvention($id_convention_entete)  {
        $this->db->select('*')
                    ->where("id_convention_entete", $id_convention_entete)
                    ->where("validation", 1);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

}