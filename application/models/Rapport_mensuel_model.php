<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rapport_mensuel_model extends CI_Model {
    protected $table = 'rapport_mensuel';

    public function add($rapport_mensuel) {
        $this->db->set($this->_set($rapport_mensuel))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $rapport_mensuel) {
        $this->db->set($this->_set($rapport_mensuel))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($rapport_mensuel) {
        return array(
            'description'   =>      $rapport_mensuel['description'],
            'fichier'   =>      $rapport_mensuel['fichier'],
            'date_livraison'    =>  $rapport_mensuel['date_livraison'],
            'observation'   =>      $rapport_mensuel['observation'],
            'id_contrat_bureau_etude'    =>  $rapport_mensuel['id_contrat_bureau_etude'],
            'validation'    =>  $rapport_mensuel['validation']                       
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

 /*   public function findAllBycontrat($id_contrat_bureau_etude,$validation) {               
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
