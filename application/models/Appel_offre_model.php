<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appel_offre_model extends CI_Model {
    protected $table = 'appel_offre';

    public function add($appel_offre) {
        $this->db->set($this->_set($appel_offre))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $appel_offre) {
        $this->db->set($this->_set($appel_offre))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($appel_offre) {
        return array(
            'description'   =>      $appel_offre['description'],
            'fichier'   =>      $appel_offre['fichier'],
            'date_livraison'    =>  $appel_offre['date_livraison'],
            'date_approbation'   =>      $appel_offre['date_approbation'],
            'observation'   =>      $appel_offre['observation'],
            'id_contrat_bureau_etude'    =>  $appel_offre['id_contrat_bureau_etude'],
            'validation'    =>  $appel_offre['validation']                       
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
    }*/

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
