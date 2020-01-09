<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfert_feffi_model extends CI_Model {
    protected $table = 'transfert_feffi';

    public function add($transfert_feffi) {
        $this->db->set($this->_set($transfert_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $transfert_feffi) {
        $this->db->set($this->_set($transfert_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($transfert_feffi) {
        return array(
            'code'          =>      $transfert_feffi['code'],
            'description'   =>      $transfert_feffi['description'],
            'montant'       =>      $transfert_feffi['montant'],
            'num_facture'   =>      $transfert_feffi['num_facture'],
            'date'          =>      $transfert_feffi['date'],
            'id_convention'    =>  $transfert_feffi['id_convention']                       
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

    public function findAllByprogramme($id_convention) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention", $id_convention)
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
