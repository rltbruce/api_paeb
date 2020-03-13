<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_feffi_scan_model extends CI_Model {
    protected $table = 'document_feffi_scan';

    public function add($document_feffi_scan) {
        $this->db->set($this->_set($document_feffi_scan))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $document_feffi_scan) {
        $this->db->set($this->_set($document_feffi_scan))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($document_feffi_scan) {
        return array(
            'fichier'   =>      $document_feffi_scan['fichier'],
            'date_elaboration'   =>      $document_feffi_scan['date_elaboration'],
            'observation'   =>      $document_feffi_scan['observation'],
            'id_convention_entete'    =>  $document_feffi_scan['id_convention_entete'],
            'id_document_feffi'    =>  $document_feffi_scan['id_document_feffi'],
            'validation'    =>  $document_feffi_scan['validation'],
            'id_convention_entete'    =>  $document_feffi_scan['id_convention_entete'],                       
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

    public function findAllByconvention($id_convention_entete,$validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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
