<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facture_mpe_model extends CI_Model {
    protected $table = 'facture_mpe';

    public function add($facture_mpe) {
        $this->db->set($this->_set($facture_mpe))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $facture_mpe) {
        $this->db->set($this->_set($facture_mpe))
                ->set('date_approbation', 'NOW()', false)
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($facture_mpe) {
        return array(
            'numero' => $facture_mpe['numero'],
            'montant_rabais' => $facture_mpe['montant_rabais'],
            'pourcentage_rabais' => $facture_mpe['pourcentage_rabais'],
            'montant_travaux' => $facture_mpe['montant_travaux'],
            'montant_ht' => $facture_mpe['montant_ht'],
            'montant_tva' => $facture_mpe['montant_tva'],
            'montant_ttc' => $facture_mpe['montant_ttc'],
            'remboursement_acompte' => $facture_mpe['remboursement_acompte'],
            'penalite_retard' => $facture_mpe['penalite_retard'],
            'retenue_garantie' => $facture_mpe['retenue_garantie'],
            'net_payer' => $facture_mpe['net_payer'],
            'date_signature' => $facture_mpe['date_signature'],
            'id_contrat_prestataire' => $facture_mpe['id_contrat_prestataire'],
            'validation' => $facture_mpe['validation']                     
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
                        ->order_by('date_signature')
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
    public function findfacture_mpeBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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
         public function findfacture_mpevalidebcafBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("validation>", 0)
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
