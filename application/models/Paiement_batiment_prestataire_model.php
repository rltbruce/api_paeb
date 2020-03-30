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

         public function getpaiementByconvention($id_convention_entete)
    {               
        $this->db->select("convention_cisco_feffi_entete.id as id_conv");
        
        $this->db ->select("(select sum(paiement_batiment_prestataire.montant_paiement) from paiement_batiment_prestataire 
            inner join demande_batiment_presta on demande_batiment_presta.id = paiement_batiment_prestataire.id_demande_batiment_pre 
            inner join contrat_prestataire on contrat_prestataire.id = demande_batiment_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_bat_pre",FALSE);
        
        $this->db ->select("(select sum(tranche_demande_mpe.pourcentage) from tranche_demande_mpe

            inner join demande_batiment_presta on demande_batiment_presta.id_tranche_demande_mpe = tranche_demande_mpe.id
            inner join paiement_batiment_prestataire on paiement_batiment_prestataire.id_demande_batiment_pre = demande_batiment_presta.id  
            inner join contrat_prestataire on contrat_prestataire.id = demande_batiment_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_bat_pre",FALSE);

        $this->db ->select("(select sum(paiement_latrine_prestataire.montant_paiement) from paiement_latrine_prestataire 
            inner join demande_latrine_presta on demande_latrine_presta.id = paiement_latrine_prestataire.id_demande_latrine_pre 
            inner join contrat_prestataire on contrat_prestataire.id = demande_latrine_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_lat_pre",FALSE);

        $this->db ->select("(select sum(tranche_demande_latrine_mpe.pourcentage) from tranche_demande_latrine_mpe

            inner join demande_latrine_presta on demande_latrine_presta.id_tranche_demande_mpe = tranche_demande_latrine_mpe.id
            inner join paiement_latrine_prestataire on paiement_latrine_prestataire.id_demande_latrine_pre = demande_latrine_presta.id  
            inner join contrat_prestataire on contrat_prestataire.id = demande_latrine_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_lat_pre",FALSE);

        $this->db ->select("(select sum(paiement_mobilier_prestataire.montant_paiement) from paiement_mobilier_prestataire 
            inner join demande_mobilier_presta on demande_mobilier_presta.id = paiement_mobilier_prestataire.id_demande_mobilier_pre 
            inner join contrat_prestataire on contrat_prestataire.id = demande_mobilier_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_mob_pre",FALSE);

        $this->db ->select("(select sum(tranche_demande_mobilier_mpe.pourcentage) from tranche_demande_mobilier_mpe

            inner join demande_mobilier_presta on demande_mobilier_presta.id_tranche_demande_mpe = tranche_demande_mobilier_mpe.id
            inner join paiement_mobilier_prestataire on paiement_mobilier_prestataire.id_demande_mobilier_pre = demande_mobilier_presta.id  
            inner join contrat_prestataire on contrat_prestataire.id = demande_mobilier_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_mob_pre",FALSE);



        $this->db ->select("(select sum(paiement_debut_travaux_moe.montant_paiement) from paiement_debut_travaux_moe 
            inner join demande_debut_travaux_moe on demande_debut_travaux_moe.id = paiement_debut_travaux_moe.id_demande_debut_travaux 
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_debut_travaux_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_debut_moe",FALSE);
        
        $this->db ->select("(select sum(tranche_d_debut_travaux_moe.pourcentage) from tranche_d_debut_travaux_moe

            inner join demande_debut_travaux_moe on demande_debut_travaux_moe.id_tranche_d_debut_travaux_moe = tranche_d_debut_travaux_moe.id
            inner join paiement_debut_travaux_moe on paiement_debut_travaux_moe.id_demande_debut_travaux = demande_debut_travaux_moe.id  
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_debut_travaux_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_deb_moe",FALSE);

        $this->db ->select("(select sum(paiement_batiment_moe.montant_paiement) from paiement_batiment_moe 
            inner join demande_batiment_moe on demande_batiment_moe.id = paiement_batiment_moe.id_demande_batiment_moe 
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_batiment_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_bat_moe",FALSE);

        $this->db ->select("(select sum(tranche_demande_batiment_moe.pourcentage) from tranche_demande_batiment_moe

            inner join demande_batiment_moe on demande_batiment_moe.id_tranche_demande_batiment_moe = tranche_demande_batiment_moe.id
            inner join paiement_batiment_moe on paiement_batiment_moe.id_demande_batiment_moe = demande_batiment_moe.id  
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_batiment_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_bat_moe",FALSE);

       $this->db ->select("(select sum(paiement_latrine_moe.montant_paiement) from paiement_latrine_moe 
            inner join demande_latrine_moe on demande_latrine_moe.id = paiement_latrine_moe.id_demande_latrine_moe 
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_latrine_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_lat_moe",FALSE);

        $this->db ->select("(select sum(tranche_demande_latrine_moe.pourcentage) from tranche_demande_latrine_moe

            inner join demande_latrine_moe on demande_latrine_moe.id_tranche_demande_latrine_moe = tranche_demande_latrine_moe.id
            inner join paiement_latrine_moe on paiement_latrine_moe.id_demande_latrine_moe = demande_latrine_moe.id  
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_latrine_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_lat_moe",FALSE);

        $this->db ->select("(select sum(paiement_fin_travaux_moe.montant_paiement) from paiement_fin_travaux_moe 
            inner join demande_fin_travaux_moe on demande_fin_travaux_moe.id = paiement_fin_travaux_moe.id_demande_fin_travaux 
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_fin_travaux_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_fin_moe",FALSE);
        
        $this->db ->select("(select sum(tranche_d_fin_travaux_moe.pourcentage) from tranche_d_fin_travaux_moe

            inner join demande_fin_travaux_moe on demande_fin_travaux_moe.id_tranche_d_fin_travaux_moe = tranche_d_fin_travaux_moe.id
            inner join paiement_fin_travaux_moe on paiement_fin_travaux_moe.id_demande_fin_travaux = demande_fin_travaux_moe.id  
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_fin_travaux_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_fin_moe",FALSE);

        $this->db ->select("(select sum(paiement_debut_travaux_pr.montant_paiement) from paiement_debut_travaux_pr 
            inner join demande_debut_travaux_pr on demande_debut_travaux_pr.id = paiement_debut_travaux_pr.id_demande_debut_travaux 
            inner join contrat_partenaire_relai on contrat_partenaire_relai.id = demande_debut_travaux_pr.id_contrat_partenaire_relai
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_partenaire_relai.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_debut_pr",FALSE);
        
        $this->db ->select("(select sum(tranche_d_debut_travaux_pr.pourcentage) from tranche_d_debut_travaux_pr

            inner join demande_debut_travaux_pr on demande_debut_travaux_pr.id_tranche_d_debut_travaux_pr = tranche_d_debut_travaux_pr.id
            inner join paiement_debut_travaux_pr on paiement_debut_travaux_pr.id_demande_debut_travaux = demande_debut_travaux_pr.id  
            inner join contrat_partenaire_relai on contrat_partenaire_relai.id = demande_debut_travaux_pr.id_contrat_partenaire_relai
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_partenaire_relai.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_deb_pr",FALSE);
        
        $this->db ->select("(select sum(decaiss_fonct_feffi.montant) from decaiss_fonct_feffi
            
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = decaiss_fonct_feffi.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_foncti_feffi",FALSE);
        

        $result =  $this->db->from('convention_cisco_feffi_entete')
                    
                    ->where('convention_cisco_feffi_entete.id',$id_convention_entete)
                    ->group_by('id_conv')
                                       
                    ->get()
                    ->result();


        if($result)
        {   
            return $result;
        }
        else
        {
            return $data=array();
        }               
    
    }

    public function getpaiementbat_mpeBycontrat($id_contrat_prestataire)
    {               
        $result =  $this->db->select('demande_batiment_presta.date_approbation as date_approbation,tranche_demande_mpe.code as code,tranche_demande_mpe.pourcentage as pourcentage,paiement_batiment_prestataire.montant_paiement as montant_paiement')
                        ->from($this->table)
                        ->join('demande_batiment_presta','demande_batiment_presta.id=paiement_batiment_prestataire.id_demande_batiment_pre')
                        ->join('tranche_demande_mpe','tranche_demande_mpe.id=demande_batiment_presta.id_tranche_demande_mpe')
                        ->join('contrat_prestataire','contrat_prestataire.id=demande_batiment_presta.id_contrat_prestataire')
                        
                        ->where("contrat_prestataire.id",$id_contrat_prestataire )
                        ->where("demande_batiment_presta.validation",3 )
                       //->order_by('code')
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
