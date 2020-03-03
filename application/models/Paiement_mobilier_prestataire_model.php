<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paiement_mobilier_prestataire_model extends CI_Model {
    protected $table = 'paiement_mobilier_prestataire';

    public function add($paiement_mobilier_prestataire) {
        $this->db->set($this->_set($paiement_mobilier_prestataire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $paiement_mobilier_prestataire) {
        $this->db->set($this->_set($paiement_mobilier_prestataire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($paiement_mobilier_prestataire) {
        return array(
            'montant_paiement'       =>      $paiement_mobilier_prestataire['montant_paiement'],
            //'cumul'       =>      $paiement_mobilier_prestataire['cumul'],
            //'pourcentage_paiement'   =>      $paiement_mobilier_prestataire['pourcentage_paiement'],
            'date_paiement'       =>      $paiement_mobilier_prestataire['date_paiement'],
            'observation'       =>      $paiement_mobilier_prestataire['observation'],
            'id_demande_mobilier_pre'    => $paiement_mobilier_prestataire['id_demande_mobilier_pre']                       
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

    public function findBydemande_mobilier_prestataire($id_demande_mobilier_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_mobilier_pre", $id_demande_mobilier_pre)
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
