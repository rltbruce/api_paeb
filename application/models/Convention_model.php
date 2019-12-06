<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convention_model extends CI_Model {
    protected $table = 'convention';

    public function add($convention) {
        $this->db->set($this->_set($convention))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $convention) {
        $this->db->set($this->_set($convention))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($convention) {
        return array(
            'numero_convention'  =>   $convention['numero_convention'],
            'description'   =>      $convention['description'],
            'id_cisco'     =>      $convention['id_cisco'],
            'id_association'  =>   $convention['id_association'],
            'id_categorie_ouvrage'   =>      $convention['id_categorie_ouvrage'],
            'id_ouvrage'     =>      $convention['id_ouvrage'],
            'montant_prevu'  =>   $convention['montant_prevu'],
            'montant_reel'   =>      $convention['montant_reel'],
            'date'   =>      $convention['date'],
            'validation'   =>      $convention['validation'],
            'id_programmation'   =>      $convention['id_programmation']                       
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
                        ->order_by('numero_convention')
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

    public function findByProgrammationValide($id_programmation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_programmation",$id_programmation)
                        ->where("validation",1)
                        ->order_by('numero_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllInvalide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",0)
                        ->order_by('numero_convention')
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
