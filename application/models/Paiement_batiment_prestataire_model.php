<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paiement_batiment_prestataire_model extends CI_Model {
    protected $table = 'paiement_batiment_prestataire';

    public function add($paiement_batiment_prestataire) {
        $this->db->set($this->_set($paiement_batiment_prestataire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $paiement_batiment_prestataire) {
        $this->db->set($this->_set($paiement_batiment_prestataire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($paiement_batiment_prestataire) {
        return array(
            'montant_paiement'       =>      $paiement_batiment_prestataire['montant_paiement'],
            //'cumul'       =>      $paiement_batiment_prestataire['cumul'],
            //'pourcentage_paiement'   =>      $paiement_batiment_prestataire['pourcentage_paiement'],
            'date_paiement'       =>      $paiement_batiment_prestataire['date_paiement'],
            'observation'       =>      $paiement_batiment_prestataire['observation'],
            'id_demande_batiment_pre'    => $paiement_batiment_prestataire['id_demande_batiment_pre']                       
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

    public function findBydemande_batiment_prestataire($id_demande_batiment_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_batiment_pre", $id_demande_batiment_pre)
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
