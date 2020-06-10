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
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->join('attachement_travaux','attachement_travaux.id = demande_mobilier_presta.id_attachement_travaux')
                        ->join('facture_mpe','facture_mpe.id=attachement_travaux.id_facture_mpe')
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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

   /* public function findAllInvalideBycisco($id_cisco) {               
        $result =  $this->db->select('demande_mobilier_presta.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_mobilier_presta.id_contrat_prestataire')
                        ->join('convention_cisco_feffi_entete','contrat_prestataire.id_convention_entete = convention_cisco_feffi_entete.id')
                        
                        ->where("demande_mobilier_presta.validation", 0)
                        ->where("convention_cisco_feffi_entete.id_cisco", $id_cisco)
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

        public function findAllValideBycisco($id_cisco) {               
        $result =  $this->db->select('demande_mobilier_presta.*, contrat_prestataire.id as id_contrat')
                        ->from($this->table)
                        ->join('mobilier_construction','mobilier_construction.id = demande_mobilier_presta.id_mobilier_construction')
                        ->join('convention_cisco_feffi_entete','mobilier_construction.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('contrat_prestataire','contrat_prestataire.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->where("demande_mobilier_presta.validation", 3)
                        ->where("convention_cisco_feffi_entete.id_cisco", $id_cisco)
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
            public function findValideBycisco($id_cisco) {               
        $result =  $this->db->select('demande_mobilier_presta.*, contrat_prestataire.id as id_contrat')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_mobilier_presta.id_contrat_prestataire')
                        ->join('convention_cisco_feffi_entete','contrat_prestataire.id_convention_entete = convention_cisco_feffi_entete.id')
                        
                        ->where("demande_mobilier_presta.validation", 3)
                        ->where("convention_cisco_feffi_entete.id_cisco", $id_cisco)
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

    public function findAllValidebcaf() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
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

        public function findAllValide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 3)
                        ->order_by('date_approbation')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

            public function findAllValidetechnique() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
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

   
    /*public function findAlldemandeBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('demande_mobilier_presta.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_mobilier_presta.id_contrat_prestataire')
                        ->where("contrat_prestataire.id", $id_contrat_prestataire)
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

    public function finddemandedisponibleBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('demande_mobilier_presta.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_mobilier_presta.id_contrat_prestataire')
                        ->where("contrat_prestataire.id", $id_contrat_prestataire)
                        ->where("demande_mobilier_presta.validation >", 0)
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
     

}
