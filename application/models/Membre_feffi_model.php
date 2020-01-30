<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membre_feffi_model extends CI_Model {
    protected $table = 'membre_feffi';

    public function add($membre_feffi) {
        $this->db->set($this->_set($membre_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $membre_feffi) {
        $this->db->set($this->_set($membre_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($membre_feffi) {
        return array(
            'nom'       =>      $membre_feffi['nom'],
            'prenom'   =>      $membre_feffi['prenom'],
            'sexe'   =>      $membre_feffi['sexe'],
            'age'   =>      $membre_feffi['age'],
            'occupation'   => $membre_feffi['occupation'],
            'id_feffi'    => $membre_feffi['id_feffi']                       
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

    public function findByfeffi($id_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_feffi", $id_feffi)
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
}
