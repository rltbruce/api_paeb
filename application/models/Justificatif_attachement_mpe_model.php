<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Justificatif_attachement_mpe_model extends CI_Model {
    protected $table = 'justificatif_attachement_mpe';

    public function add($justificatif_attachement_mpe) {
        $this->db->set($this->_set($justificatif_attachement_mpe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $justificatif_attachement_mpe) {
        $this->db->set($this->_set($justificatif_attachement_mpe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($justificatif_attachement_mpe) {
        return array(
            'description'   =>      $justificatif_attachement_mpe['description'],
            'fichier'   =>      $justificatif_attachement_mpe['fichier'],
            'id_attachement_travaux'    =>  $justificatif_attachement_mpe['id_attachement_travaux']                       
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
                        ->order_by('description')
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

    public function findAllBydemande($id_attachement_travaux) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_attachement_travaux", $id_attachement_travaux)
                        ->order_by('description')
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
