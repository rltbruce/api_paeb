<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Justificatif_daaf_model extends CI_Model {
    protected $table = 'piece_justificatif_daaf';

    public function add($justificatif_daaf) {
        $this->db->set($this->_set($justificatif_daaf))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $justificatif_daaf) {
        $this->db->set($this->_set($justificatif_daaf))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($justificatif_daaf) {
        return array(
            'description'   =>      $justificatif_daaf['description'],
            'fichier'   =>      $justificatif_daaf['fichier'],
            'id_demande_deblocage_daaf'    =>  $justificatif_daaf['id_demande_deblocage_daaf']                       
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

    public function findAllBydemande($id_demande_deblocage_daaf) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_deblocage_daaf", $id_demande_deblocage_daaf)
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
