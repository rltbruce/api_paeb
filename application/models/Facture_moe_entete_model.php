<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facture_moe_entete_model extends CI_Model {
    protected $table = 'facture_moe_entete';

    public function add($facture_moe_entete) {
        $this->db->set($this->_set($facture_moe_entete))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $facture_moe_entete) {
        $this->db->set($this->_set($facture_moe_entete))
                //->set('date_approbation', 'NOW()', false)
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($facture_moe_entete) {
        return array(
            'numero' => $facture_moe_entete['numero'],
            'date_br' => $facture_moe_entete['date_br'],
            'id_contrat_bureau_etude' => $facture_moe_entete['id_contrat_bureau_etude'],
            'validation'    =>  $facture_moe_entete['validation']                      
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
                        ->order_by('id')
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
    public function getfacture_moe_enteteBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_bureau_etude',$id_contrat_bureau_etude)
                        ->order_by('id')
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
