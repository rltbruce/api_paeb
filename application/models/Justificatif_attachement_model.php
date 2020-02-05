<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Justificatif_attachement_model extends CI_Model {
    protected $table = 'justificatif_attachement_pre';

    public function add($justificatif_attachement) {
        $this->db->set($this->_set($justificatif_attachement))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $justificatif_attachement) {
        $this->db->set($this->_set($justificatif_attachement))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($justificatif_attachement) {
        return array(
            'description'   =>      $justificatif_attachement['description'],
            'fichier'   =>      $justificatif_attachement['fichier'],
            'id_demande_pay_pre'    =>  $justificatif_attachement['id_demande_pay_pre']                       
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

    public function findAllBydemande($id_demande_pay_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_pay_pre", $id_demande_pay_pre)
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
