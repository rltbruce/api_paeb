<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_prestataire_scan_model extends CI_Model {
    protected $table = 'document_prestataire_scan';

    public function add($document_prestataire_scan) {
        $this->db->set($this->_set($document_prestataire_scan))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $document_prestataire_scan) {
        $this->db->set($this->_set($document_prestataire_scan))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($document_prestataire_scan) {
        return array(
            'fichier'   =>      $document_prestataire_scan['fichier'],
            'date_elaboration'   =>      $document_prestataire_scan['date_elaboration'],
            'observation'   =>      $document_prestataire_scan['observation'],
            'id_contrat_prestataire'    =>  $document_prestataire_scan['id_contrat_prestataire'],
            'id_document_prestataire'    =>  $document_prestataire_scan['id_document_prestataire'],
            'validation'    =>  $document_prestataire_scan['validation']                       
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
                        ->order_by('date_elaboration')
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

   /* public function findAllBycontrat($id_contrat_prestataire,$validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("validation", $validation)
                        ->order_by('date_elaboration')
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
                        ->order_by('date_elaboration')
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
