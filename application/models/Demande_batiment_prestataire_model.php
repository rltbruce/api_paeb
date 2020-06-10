<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_batiment_prestataire_model extends CI_Model {
    protected $table = 'demande_batiment_presta';

    public function add($demande_batiment_prestataire) {
        $this->db->set($this->_set($demande_batiment_prestataire))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_batiment_prestataire) {
        $this->db->set($this->_set($demande_batiment_prestataire))
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
    public function _set($demande_batiment_prestataire) {
        return array(
            'montant'   =>      $demande_batiment_prestataire['montant'],
            'id_tranche_demande_mpe' => $demande_batiment_prestataire['id_tranche_demande_mpe'],
            'anterieur' => $demande_batiment_prestataire['anterieur'],
            'cumul' => $demande_batiment_prestataire['cumul'],
            'reste' => $demande_batiment_prestataire['reste'],
            'id_attachement_travaux'    =>  $demande_batiment_prestataire['id_attachement_travaux']                       
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
                        ->join('attachement_travaux','attachement_travaux.id = demande_batiment_presta.id_attachement_travaux')
                        ->join('facture_mpe','facture_mpe.id=attachement_travaux.id_facture_mpe')
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->order_by('demande_batiment_presta.id')
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
     public function countAllfactureByvalidation($validation)
    {
        $sql=" select 
                       sum(detail.nbr_facture_mpe) as nbr_facture_mpe,
                       sum( detail.nbr_facture_debut_moe) as nbr_facture_debut_moe,
                       sum(detail.nbr_facture_batiment_moe) as nbr_facture_batiment_moe,
                       sum( detail.nbr_facture_latrine_moe) as nbr_facture_latrine_moe,
                       sum(detail.nbr_facture_fin_moe) as nbr_facture_fin_moe,
                       sum(detail.nbr_facture_mpe) + sum( detail.nbr_facture_debut_moe) + sum(detail.nbr_facture_batiment_moe)
                        + sum( detail.nbr_facture_latrine_moe) + sum(detail.nbr_facture_fin_moe) as nombre
               from (
               
                (
                    select 
                        count(fact_mpe.id) as nbr_facture_mpe,
                        0 as nbr_facture_debut_moe,
                        0 as nbr_facture_batiment_moe,
                        0 as nbr_facture_latrine_moe,
                        0 as nbr_facture_fin_moe

                        from facture_mpe as fact_mpe
                        where 
                            fact_mpe.validation= '".$validation."'
                )
                UNION
                (
                    select 
                        0 as nbr_facture_mpe,
                        count(demande_debut_moe.id) as nbr_facture_debut_moe,
                        0 as nbr_facture_batiment_moe,
                        0 as nbr_facture_latrine_moe,
                        0 as nbr_facture_fin_moe

                        from demande_debut_travaux_moe as demande_debut_moe

                        where 
                            demande_debut_moe.validation= '".$validation."'
                )
                UNION
                (
                    select 
                        0 as nbr_facture_mpe,
                        0 as nbr_facture_debut_moe,
                        count(demande_batiment_moe.id) as nbr_facture_batiment_moe,
                        0 as nbr_facture_latrine_moe,
                        0 as nbr_facture_fin_moe

                        from demande_batiment_moe as demande_batiment_moe

                        where 
                            demande_batiment_moe.validation= '".$validation."'
                )
                UNION
                (
                    select 
                        0 as nbr_facture_mpe,
                        0 as nbr_facture_debut_moe,
                        0 as nbr_facture_batiment_moe,
                        count(demande_latrine_moe.id) as nbr_facture_latrine_moe,
                        0 as nbr_facture_fin_moe

                        from demande_latrine_moe as demande_latrine_moe

                        where 
                            demande_latrine_moe.validation= '".$validation."'
                )
                UNION
                (
                    select 
                        0 as nbr_facture_mpe,
                        0 as nbr_facture_debut_moe,
                        0 as nbr_facture_batiment_moe,
                        0 as nbr_facture_latrine_moe,
                        count(demande_fin_moe.id) as nbr_facture_fin_moe

                        from demande_fin_travaux_moe as demande_fin_moe

                        where 
                            demande_fin_moe.validation= '".$validation."'
                )

                )detail

            ";
            return $this->db->query($sql)->result();                  
    }

   /* public function findAllInvalideBycisco($id_cisco) {               
        $result =  $this->db->select('demande_batiment_presta.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_batiment_presta.id_contrat_prestataire')
                        ->join('convention_cisco_feffi_entete','contrat_prestataire.id_convention_entete = convention_cisco_feffi_entete.id')
                        
                        ->where("demande_batiment_presta.validation", 0)
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
        $result =  $this->db->select('demande_batiment_presta.*, contrat_prestataire.id as id_contrat')
                        ->from($this->table)
                        ->join('batiment_construction','batiment_construction.id = demande_batiment_presta.id_batiment_construction')
                        ->join('convention_cisco_feffi_entete','batiment_construction.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('contrat_prestataire','contrat_prestataire.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->where("demande_batiment_presta.validation", 3)
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
        $result =  $this->db->select('demande_batiment_presta.*, contrat_prestataire.id as id_contrat')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_batiment_presta.id_contrat_prestataire')
                        ->join('convention_cisco_feffi_entete','contrat_prestataire.id_convention_entete = convention_cisco_feffi_entete.id')
                        
                        ->where("demande_batiment_presta.validation", 3)
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
        $result =  $this->db->select('demande_batiment_presta.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_batiment_presta.id_contrat_prestataire')
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
        $result =  $this->db->select('demande_batiment_presta.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_batiment_presta.id_contrat_prestataire')
                        ->where("contrat_prestataire.id", $id_contrat_prestataire)
                        ->where("demande_batiment_presta.validation >", 0)
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
