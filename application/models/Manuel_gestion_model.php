<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manuel_gestion_model extends CI_Model {
    protected $table = 'manuel_gestion';

    public function add($manuel_gestion) {
        $this->db->set($this->_set($manuel_gestion))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $manuel_gestion) {
        $this->db->set($this->_set($manuel_gestion))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($manuel_gestion) {
        return array(
            'description'   =>      $manuel_gestion['description'],
            'fichier'   =>      $manuel_gestion['fichier'],
            'date_livraison'    =>  $manuel_gestion['date_livraison'],
            'observation'   =>      $manuel_gestion['observation'],
            'id_contrat_bureau_etude'    =>  $manuel_gestion['id_contrat_bureau_etude'],
            'validation'    =>  $manuel_gestion['validation']                       
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
                        ->order_by('date_livraison')
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
                        ->order_by('date_livraison')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    } */
        public function findAllByvalidation($validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", $validation)
                        ->order_by('date_livraison')
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
