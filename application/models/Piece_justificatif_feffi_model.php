<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Piece_justificatif_feffi_model extends CI_Model {
    protected $table = 'piece_justificatif_feffi';

    public function add($piece_justificatif_feffi) {
        $this->db->set($this->_set($piece_justificatif_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $piece_justificatif_feffi) {
        $this->db->set($this->_set($piece_justificatif_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($piece_justificatif_feffi) {
        return array(
            'description'   =>      $piece_justificatif_feffi['description'],
            'fichier'   =>      $piece_justificatif_feffi['fichier'],
            'date'          =>      $piece_justificatif_feffi['date'],
            'id_demande_rea_feffi'    =>  $piece_justificatif_feffi['id_demande_rea_feffi']                       
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

    public function findAllBydemande($id_demande_rea_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_rea_feffi", $id_demande_rea_feffi)
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
