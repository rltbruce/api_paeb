<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convention_ufp_daaf_entete_model extends CI_Model {
    protected $table = 'convention_ufp_daaf_entete';

    public function add($convention_ufp_daaf_entete) {
        $this->db->set($this->_set($convention_ufp_daaf_entete))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $convention_ufp_daaf_entete) {
        $this->db->set($this->_set($convention_ufp_daaf_entete))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($convention_ufp_daaf_entete) {
        return array(
            'ref_convention' => $convention_ufp_daaf_entete['ref_convention'],
            'objet' =>    $convention_ufp_daaf_entete['objet'],
            'ref_financement'    => $convention_ufp_daaf_entete['ref_financement'],
            'montant_convention' => $convention_ufp_daaf_entete['montant_convention'],
            'montant_trans_comm' => $convention_ufp_daaf_entete['montant_trans_comm'],
            'frais_bancaire' => $convention_ufp_daaf_entete['frais_bancaire'],
            'validation' => $convention_ufp_daaf_entete['validation']                      
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
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findConvention_ufp_daafByValidation($validation)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('validation',$validation)
                        ->order_by('ref_convention')
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
        public function findByIdObjet($id) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
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
