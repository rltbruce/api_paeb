<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Police_assurance_model extends CI_Model {
    protected $table = 'police_assurance';

    public function add($police_assurance) {
        $this->db->set($this->_set($police_assurance))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $police_assurance) {
        $this->db->set($this->_set($police_assurance))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($police_assurance) {
        return array(
            'description'   =>      $police_assurance['description'],
            'fichier'   =>      $police_assurance['fichier'],
            'date_expiration'    =>  $police_assurance['date_expiration'],
            'observation'   =>      $police_assurance['observation'],
            'id_contrat_bureau_etude'    =>  $police_assurance['id_contrat_bureau_etude'],
            'validation'    =>  $police_assurance['validation']                       
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
                        ->order_by('date_expiration')
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

   /* public function findAllBycontrat($id_contrat_bureau_etude,$validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("validation", $validation)
                        ->order_by('date_expiration')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/ 
        public function findAllByvalidation($validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", $validation)
                        ->order_by('date_expiration')
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
