<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_mobilier_prestataire_model extends CI_Model {
    protected $table = 'demande_mobilier_presta';

    public function add($demande_mobilier_prestataire) {
        $this->db->set($this->_set($demande_mobilier_prestataire))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_mobilier_prestataire) {
        $this->db->set($this->_set($demande_mobilier_prestataire))
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
    public function _set($demande_mobilier_prestataire) {
        return array(
            'montant'   =>      $demande_mobilier_prestataire['montant'],
            'id_tranche_demande_mpe' => $demande_mobilier_prestataire['id_tranche_demande_mpe'],
            'anterieur' => $demande_mobilier_prestataire['anterieur'],
            'cumul' => $demande_mobilier_prestataire['cumul'],
            'reste' => $demande_mobilier_prestataire['reste'],
            'id_attachement_travaux'    =>  $demande_mobilier_prestataire['id_attachement_travaux']                       
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
                        ->order_by('objet')
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
    public function finddemandeByattachement($id_attachement_travaux) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_attachement_travaux", $id_attachement_travaux)
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
    public function finddemandeBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('demande_mobilier_presta.*')
                        ->from($this->table)
                        ->join('attachement_travaux','attachement_travaux.id = demande_mobilier_presta.id_attachement_travaux')
                        ->join('facture_mpe','facture_mpe.id_attachement_travaux = attachement_travaux.id')
                        //->join('attachement_travaux','attachement_travaux.id=attachement_travaux.id_attachement_travaux')
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("facture_mpe.validation", 4)
                        ->order_by('demande_mobilier_presta.id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    /*public function finddemandeBycontrat($id_contrat_prestataire) {               
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
     public function finddemandeinvalideBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("validation", 0)
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
     public function finddemandevalidebcafBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("validation", 1)
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
    public function finddemandevalideBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("validation", 2)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/
     public function countAllByInvalide($invalide)
    {
        $result = $this->db->select('COUNT(*) as nombre')
                        ->from($this->table)
                        ->where("validation", $invalide)
                        ->order_by('id', 'desc')
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
