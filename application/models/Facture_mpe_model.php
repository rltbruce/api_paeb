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
            'remboursement_plaque' => $facture_mpe['remboursement_plaque'],
            'taxe_marche_public' => $facture_mpe['taxe_marche_public'],
            'net_payer' => $facture_mpe['net_payer'],
            'date_signature' => $facture_mpe['date_signature'],
            'id_attachement_travaux' => $facture_mpe['id_attachement_travaux'],
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
    public function findfacture_mpeByattachement($id_attachement_travaux) {               
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
    public function avancement_financiereBycontrat($id_contrat)
    {
        $sql=" select 
                       (sum(detail.net_payer) + sum(detail.montant_avance)) as montant_facture_total
               from (
               
                (
                    select 
                        contrat_mpe.id as id,
                        sum(fact_mpe.net_payer) as net_payer,
                        0 as montant_avance

                        from facture_mpe as fact_mpe
                        inner join attachement_travaux as atta_tra on atta_tra.id=fact_mpe.id_attachement_travaux
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id=atta_tra.id_contrat_prestataire
                        where 
                            fact_mpe.validation= 4 and contrat_mpe.id= '".$id_contrat."'
                )
                UNION
                (
                    select 
                        contrat_mpe.id as id,
                        0 as net_payer,                       
                        sum(avance_dem.net_payer) as montant_avance

                        from avance_demarrage as avance_dem
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id=avance_dem.id_contrat_prestataire
                        where 
                            avance_dem.validation= 4 and contrat_mpe.id= '".$id_contrat."'
                )

                )detail

            ";
            return $this->db->query($sql)->result();                  
    }
   /* public function avancement_financiereBycontrat($id_contrat) otran diso
    {
        $sql=" select 
                       (sum(detail.net_payer) + sum( detail.remboursement_acompte) - sum(detail.montant_avance)) as montant_facture_total
               from (
               
                (
                    select 
                        contrat_mpe.id as id,
                        sum(fact_mpe.net_payer) as net_payer,
                        sum(fact_mpe.remboursement_acompte) as remboursement_acompte,
                        0 as montant_avance

                        from facture_mpe as fact_mpe
                        inner join attachement_travaux as atta_tra on atta_tra.id=fact_mpe.id_attachement_travaux
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id=atta_tra.id_contrat_prestataire
                        where 
                            fact_mpe.validation= 4 and contrat_mpe.id= '".$id_contrat."'
                )
                UNION
                (
                    select 
                        contrat_mpe.id as id,
                        0 as net_payer,                        
                        0 as remboursement_acompte,                        
                        sum(avance_dem.net_payer) as montant_avance

                        from avance_demarrage as avance_dem
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id=avance_dem.id_contrat_prestataire
                        where 
                            avance_dem.validation= 4 and contrat_mpe.id= '".$id_contrat."'
                )

                )detail

            ";
            return $this->db->query($sql)->result();                  
    }*/

        
    public function getfacture_mpevalideBycontrat($id_contrat_prestataire)
    {               
        $result =  $this->db->select('facture_mpe.*,attachement_travaux.date_debut as date_debut, attachement_travaux.date_fin,((contrat_prestataire.cout_batiment + contrat_prestataire.cout_latrine + contrat_prestataire.cout_mobilier)-facture_mpe.net_payer) as reste_payer,((facture_mpe.montant_travaux*100)/(contrat_prestataire.cout_batiment + contrat_prestataire.cout_latrine + contrat_prestataire.cout_mobilier)) as pourcentage')
                        ->from($this->table)
                        ->join('attachement_travaux','attachement_travaux.id=facture_mpe.id_attachement_travaux')
                        ->join('contrat_prestataire','contrat_prestataire.id=attachement_travaux.id_contrat_prestataire')
                        ->where("attachement_travaux.id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("facture_mpe.validation", 4)
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
    }public function findByAttachement_travaux($id_attachement_travaux) {               
        $result =  $this->db->select('facture_mpe.*')
                        ->from($this->table)
                        ->join('attachement_travaux','attachement_travaux.id_facture_mpe=facture_mpe.id')
                        ->where("attachement_travaux.id", $id_attachement_travaux)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function finddecompte_mpeBycontratandfacture($id_contrat_prestataire,$id_facture_mpe)
    {               
        $sql=" select 
                       detail.id_contrat as id_contrat,
                       (sum(detail.montant_travaux_to)+sum(detail.montant_travaux_pe)) as montant_travaux_to,
                         (sum(detail.montant_rabais_to)+sum(detail.montant_rabais_pe)) as montant_rabais_to,
                         (sum(detail.montant_ht_to)+sum(detail.montant_ht_pe)) as montant_ht_to,
                         (sum(detail.montant_tva_to)+sum(detail.montant_tva_pe)) as montant_tva_to,
                         (sum(detail.montant_ttc_to)+sum(detail.montant_ttc_pe)) as montant_ttc_to,
                         (sum(detail.remboursement_acompte_to)+sum(detail.remboursement_acompte_pe)) as remboursement_acompte_to,
                         (sum(detail.penalite_retard_to)+sum(detail.penalite_retard_pe)) as penalite_retard_to,
                         (sum(detail.retenue_garantie_to)+sum(detail.retenue_garantie_pe)) as retenue_garantie_to,
                         (sum(detail.remboursement_plaque_to)+sum(detail.remboursement_plaque_pe)) as remboursement_plaque_to,
                         (sum(detail.taxe_marche_public_to)+sum(detail.taxe_marche_public_pe)) as taxe_marche_public_to,
                         (sum(detail.net_payer_to)+sum(detail.net_payer_pe)) as net_payer_to,

                         sum(detail.montant_travaux_pe) as montant_travaux_pe,
                         sum(detail.montant_rabais_pe) as montant_rabais_pe,
                         sum(detail.montant_ht_pe) as montant_ht_pe,
                         sum(detail.montant_tva_pe) as montant_tva_pe,
                         sum(detail.montant_ttc_pe) as montant_ttc_pe,
                         sum(detail.remboursement_acompte_pe) as remboursement_acompte_pe,
                         sum(detail.penalite_retard_pe) as penalite_retard_pe,
                         sum(detail.retenue_garantie_pe) as retenue_garantie_pe,
                         sum(detail.remboursement_plaque_pe) as remboursement_plaque_pe,
                         sum(detail.taxe_marche_public_pe) as taxe_marche_public_pe,
                         sum(detail.net_payer_pe) as net_payer_pe,

                         sum(detail.montant_travaux_ante) as montant_travaux_ante,
                         sum(detail.montant_rabais_ante) as montant_rabais_ante,
                         sum(detail.montant_ht_ante) as montant_ht_ante,
                         sum(detail.montant_tva_ante) as montant_tva_ante,
                         sum(detail.montant_ttc_ante) as montant_ttc_ante,
                         sum(detail.remboursement_acompte_ante) as remboursement_acompte_ante,
                         sum(detail.penalite_retard_ante) as penalite_retard_ante,
                         sum(detail.retenue_garantie_ante) as retenue_garantie_ante,
                         sum(detail.remboursement_plaque_ante) as remboursement_plaque_ante,
                         sum(detail.taxe_marche_public_ante) as taxe_marche_public_ante,
                         sum(detail.net_payer_ante) as net_payer_ante,
                         
                         sum(detail.nbr_fact) as nbr_fact,
                         sum(detail.net_payer_avanc) as net_payer_avanc

               from (
               
                (
                    select 
                        atta_tra.id_contrat_prestataire as id_contrat,
                         sum(fact_mpe.montant_travaux) as montant_travaux_to,
                         sum(fact_mpe.montant_rabais) as montant_rabais_to,
                         sum(fact_mpe.montant_ht) as montant_ht_to,
                         sum(fact_mpe.montant_tva) as montant_tva_to,
                         sum(fact_mpe.montant_ttc) as montant_ttc_to,
                         sum(fact_mpe.remboursement_acompte) as remboursement_acompte_to,
                         sum(fact_mpe.penalite_retard) as penalite_retard_to,
                         sum(fact_mpe.retenue_garantie) as retenue_garantie_to,
                         sum(fact_mpe.remboursement_plaque) as remboursement_plaque_to,
                         sum(fact_mpe.taxe_marche_public) as taxe_marche_public_to,
                         sum(fact_mpe.net_payer) as net_payer_to,
                         0 as montant_travaux_pe,
                         0 as montant_rabais_pe,
                         0 as montant_ht_pe,
                         0 as montant_tva_pe,
                         0 as montant_ttc_pe,
                         0 as remboursement_acompte_pe,
                         0 as penalite_retard_pe,
                         0 as retenue_garantie_pe,
                         0 as remboursement_plaque_pe,
                         0 as taxe_marche_public_pe,
                         0 as net_payer_pe,
                         0 as montant_travaux_ante,
                         0 as montant_rabais_ante,
                         0 as montant_ht_ante,
                         0 as montant_tva_ante,
                         0 as montant_ttc_ante,
                         0 as remboursement_acompte_ante,
                         0 as penalite_retard_ante,
                         0 as retenue_garantie_ante,
                         0 as remboursement_plaque_ante,
                         0 as taxe_marche_public_ante,
                         0 as net_payer_ante,                         
                         0 as nbr_fact,
                         0 as net_payer_avanc

                        from facture_mpe as fact_mpe

                        inner join attachement_travaux as atta_tra on atta_tra.id=fact_mpe.id_attachement_travaux
                        where fact_mpe.id< '".$id_facture_mpe."' and
                        atta_tra.id_contrat_prestataire= '".$id_contrat_prestataire."' and fact_mpe.validation = 4

                            group by id_contrat
                )
                UNION
                (
                    select 
                        atta_tra.id_contrat_prestataire as id_contrat,
                        0 as montant_travaux_to,
                        0 as montant_rabais_to,
                        0 as montant_ht_to,
                        0 as montant_tva_to,
                        0 as montant_ttc_to,
                        0 as remboursement_acompte_to,
                        0 as penalite_retard_to,
                        0 as retenue_garantie_to,
                        0 as remboursement_plaque_to,
                        0 as taxe_marche_public_to,
                        0 as net_payer_to,
                         sum(fact_mpe.montant_travaux) as montant_travaux_pe,
                         sum(fact_mpe.montant_rabais) as montant_rabais_pe,
                         sum(fact_mpe.montant_ht) as montant_ht_pe,
                         sum(fact_mpe.montant_tva) as montant_tva_pe,
                         sum(fact_mpe.montant_ttc) as montant_ttc_pe,
                         sum(fact_mpe.remboursement_acompte) as remboursement_acompte_pe,
                         sum(fact_mpe.penalite_retard) as penalite_retard_pe,
                         sum(fact_mpe.retenue_garantie) as retenue_garantie_pe,
                         sum(fact_mpe.remboursement_plaque) as remboursement_plaque_pe,
                         sum(fact_mpe.taxe_marche_public) as axe_marche_public_pe,
                         sum(fact_mpe.net_payer) as net_payer_pe,
                         0 as montant_travaux_ante,
                         0 as montant_rabais_ante,
                         0 as montant_ht_ante,
                         0 as montant_tva_ante,
                         0 as montant_ttc_ante,
                         0 as remboursement_acompte_ante,
                         0 as penalite_retard_ante,
                         0 as retenue_garantie_ante,
                         0 as remboursement_plaque_ante,
                         0 as taxe_marche_public_ante,
                         0 as net_payer_ante,                         
                         0 as nbr_fact,
                         0 as net_payer_avanc

                        from facture_mpe as fact_mpe

                        inner join attachement_travaux as atta_tra on atta_tra.id=fact_mpe.id_attachement_travaux
                        where 
                        atta_tra.id_contrat_prestataire= '".$id_contrat_prestataire."' and fact_mpe.id='".$id_facture_mpe."'
                            group by id_contrat
                )
                UNION
                (
                    select 
                        atta_tra.id_contrat_prestataire as id_contrat,
                        0 as montant_travaux_to,
                        0 as montant_rabais_to,
                        0 as montant_ht_to,
                        0 as montant_tva_to,
                        0 as montant_ttc_to,
                        0 as remboursement_acompte_to,
                        0 as penalite_retard_to,
                        0 as retenue_garantie_to,
                        0 as remboursement_plaque_to,
                        0 as taxe_marche_public_to,
                        0 as net_payer_to,
                         0 as montant_travaux_pe,
                         0 as montant_rabais_pe,
                         0 as montant_ht_pe,
                         0 as montant_tva_pe,
                         0 as montant_ttc_pe,
                         0 as remboursement_acompte_pe,
                         0 as penalite_retard_pe,
                         0 as retenue_garantie_pe,
                         0 as remboursement_plaque_pe,
                         0 as taxe_marche_public_pe,
                         0 as net_payer_pe,
                         sum(fact_mpe.montant_travaux) as montant_travaux_ante,
                         sum(fact_mpe.montant_rabais) as montant_rabais_ante,
                         sum(fact_mpe.montant_ht) as montant_ht_ante,
                         sum(fact_mpe.montant_tva) as montant_tva_ante,
                         sum(fact_mpe.montant_ttc) as montant_ttc_ante,
                         sum(fact_mpe.remboursement_acompte) as remboursement_acompte_ante,
                         sum(fact_mpe.penalite_retard) as penalite_retard_ante,
                         sum(fact_mpe.retenue_garantie) as retenue_garantie_ante,
                         sum(fact_mpe.remboursement_plaque) as remboursement_plaque_ante,
                         sum(fact_mpe.taxe_marche_public) as taxe_marche_public_ante,
                         sum(fact_mpe.net_payer) as net_payer_ante,                         
                         0 as nbr_fact,
                         0 as net_payer_avanc

                        from facture_mpe as fact_mpe

                        inner join attachement_travaux as atta_tra on atta_tra.id=fact_mpe.id_attachement_travaux
                        where 
                        atta_tra.id_contrat_prestataire= '".$id_contrat_prestataire."' and fact_mpe.validation = 4 and fact_mpe.id=(
                                    select max(factu_mpe.id) 
                                        from facture_mpe as factu_mpe
                                        inner join attachement_travaux as atta_trav on atta_trav.id=factu_mpe.id_attachement_travaux
                                            where factu_mpe.id < '".$id_facture_mpe."' and atta_trav.id_contrat_prestataire = '".$id_contrat_prestataire."')

                            group by id_contrat
                )

                UNION
                (
                    select 
                        atta_tra.id_contrat_prestataire as id_contrat,
                        0 as montant_travaux_to,
                        0 as montant_rabais_to,
                        0 as montant_ht_to,
                        0 as montant_tva_to,
                        0 as montant_ttc_to,
                        0 as remboursement_acompte_to,
                        0 as penalite_retard_to,
                        0 as retenue_garantie_to,
                        0 as remboursement_plaque_to,
                        0 as taxe_marche_public_to,
                        0 as net_payer_to,
                         0 as montant_travaux_pe,
                         0 as montant_rabais_pe,
                         0 as montant_ht_pe,
                         0 as montant_tva_pe,
                         0 as montant_ttc_pe,
                         0 as remboursement_acompte_pe,
                         0 as penalite_retard_pe,
                         0 as retenue_garantie_pe,
                         0 as remboursement_plaque_pe,
                         0 as taxe_marche_public_pe,
                         0 as net_payer_pe,
                         0 as montant_travaux_ante,
                         0 as montant_rabais_ante,
                         0 as montant_ht_ante,
                         0 as montant_tva_ante,
                         0 as montant_ttc_ante,
                         0 as remboursement_acompte_ante,
                         0 as penalite_retard_ante,
                         0 as retenue_garantie_ante,
                         0 as remboursement_plaque_ante,
                         0 as taxe_marche_public_ante,
                         0 as net_payer_ante,
                         count(fact_mpe.id) as nbr_fact,
                         0 as net_payer_avanc
                            
                            from facture_mpe as fact_mpe
                         inner join attachement_travaux as atta_tra on atta_tra.id=fact_mpe.id_attachement_travaux   
                        where 
                        atta_tra.id_contrat_prestataire= '".$id_contrat_prestataire."' and fact_mpe.validation = 4 and fact_mpe.id<= '".$id_facture_mpe."'

                            group by id_contrat
                )

                UNION
                (
                    select 
                        avance_dem.id_contrat_prestataire as id_contrat,
                        0 as montant_travaux_to,
                        0 as montant_rabais_to,
                        0 as montant_ht_to,
                        0 as montant_tva_to,
                        0 as montant_ttc_to,
                        0 as remboursement_acompte_to,
                        0 as penalite_retard_to,
                        0 as retenue_garantie_to,
                        0 as remboursement_plaque_to,
                        0 as taxe_marche_public_to,
                        0 as net_payer_to,
                         0 as montant_travaux_pe,
                         0 as montant_rabais_pe,
                         0 as montant_ht_pe,
                         0 as montant_tva_pe,
                         0 as montant_ttc_pe,
                         0 as remboursement_acompte_pe,
                         0 as penalite_retard_pe,
                         0 as retenue_garantie_pe,
                         0 as remboursement_plaque_pe,
                         0 as taxe_marche_public_pe,
                         0 as net_payer_pe,
                         0 as montant_travaux_ante,
                         0 as montant_rabais_ante,
                         0 as montant_ht_ante,
                         0 as montant_tva_ante,
                         0 as montant_ttc_ante,
                         0 as remboursement_acompte_ante,
                         0 as penalite_retard_ante,
                         0 as retenue_garantie_ante,
                         0 as remboursement_plaque_ante,
                         0 as taxe_marche_public_ante,
                         0 as net_payer_ante,
                         0 as nbr_fact,
                         sum(avance_dem.net_payer) as net_payer_avanc
                            
                            from avance_demarrage as avance_dem

                        where 
                        avance_dem.id_contrat_prestataire= '".$id_contrat_prestataire."' and avance_dem.validation = 4

                            group by id_contrat
                )

                )detail

                group by id_contrat

            ";
            return $this->db->query($sql)->result();             
    }

    public function finddecompte_mpeBycontrat($id_contrat_prestataire,$id_facture_mpe)
    {               
        $sql=" select 
                       detail.id_contrat as id_contrat,
                       sum(detail.montant_travaux_to) as montant_travaux_to,
                         sum(detail.montant_rabais_to) as montant_rabais_to,
                         sum(detail.montant_ht_to) as montant_ht_to,
                         sum(detail.montant_tva_to) as montant_tva_to,
                         sum(detail.montant_ttc_to) as montant_ttc_to,
                         sum(detail.remboursement_acompte_to) as remboursement_acompte_to,
                         sum(detail.penalite_retard_to) as penalite_retard_to,
                         sum(detail.retenue_garantie_to) as retenue_garantie_to,
                         sum(detail.remboursement_plaque_to) as remboursement_plaque_to,
                         sum(detail.taxe_marche_public_to) as taxe_marche_public_to,
                         sum(detail.net_payer_to) as net_payer_to,

                         sum(detail.montant_travaux_pe) as montant_travaux_pe,
                         sum(detail.montant_rabais_pe) as montant_rabais_pe,
                         sum(detail.montant_ht_pe) as montant_ht_pe,
                         sum(detail.montant_tva_pe) as montant_tva_pe,
                         sum(detail.montant_ttc_pe) as montant_ttc_pe,
                         sum(detail.remboursement_acompte_pe) as remboursement_acompte_pe,
                         sum(detail.penalite_retard_pe) as penalite_retard_pe,
                         sum(detail.retenue_garantie_pe) as retenue_garantie_pe,
                         sum(detail.remboursement_plaque_pe) as remboursement_plaque_pe,
                         sum(detail.taxe_marche_public_pe) as taxe_marche_public_pe,
                         sum(detail.net_payer_pe) as net_payer_pe,

                         sum(detail.montant_travaux_ante) as montant_travaux_ante,
                         sum(detail.montant_rabais_ante) as montant_rabais_ante,
                         sum(detail.montant_ht_ante) as montant_ht_ante,
                         sum(detail.montant_tva_ante) as montant_tva_ante,
                         sum(detail.montant_ttc_ante) as montant_ttc_ante,
                         sum(detail.remboursement_acompte_ante) as remboursement_acompte_ante,
                         sum(detail.penalite_retard_ante) as penalite_retard_ante,
                         sum(detail.retenue_garantie_ante) as retenue_garantie_ante,
                         sum(detail.remboursement_plaque_ante) as remboursement_plaque_ante,
                         sum(detail.taxe_marche_public_ante) as taxe_marche_public_ante,
                         sum(detail.net_payer_ante) as net_payer_ante,
                         
                         sum(detail.nbr_fact) as nbr_fact,
                         sum(detail.net_payer_avanc) as net_payer_avanc

               from (
               
                (
                    select 
                        atta_tra.id_contrat_prestataire as id_contrat,
                         sum(fact_mpe.montant_travaux) as montant_travaux_to,
                         sum(fact_mpe.montant_rabais) as montant_rabais_to,
                         sum(fact_mpe.montant_ht) as montant_ht_to,
                         sum(fact_mpe.montant_tva) as montant_tva_to,
                         sum(fact_mpe.montant_ttc) as montant_ttc_to,
                         sum(fact_mpe.remboursement_acompte) as remboursement_acompte_to,
                         sum(fact_mpe.penalite_retard) as penalite_retard_to,
                         sum(fact_mpe.retenue_garantie) as retenue_garantie_to,
                         sum(fact_mpe.remboursement_plaque) as remboursement_plaque_to,
                         sum(fact_mpe.taxe_marche_public) as taxe_marche_public_to,
                         sum(fact_mpe.net_payer) as net_payer_to,
                         0 as montant_travaux_pe,
                         0 as montant_rabais_pe,
                         0 as montant_ht_pe,
                         0 as montant_tva_pe,
                         0 as montant_ttc_pe,
                         0 as remboursement_acompte_pe,
                         0 as penalite_retard_pe,
                         0 as retenue_garantie_pe,
                         0 as remboursement_plaque_pe,
                         0 as taxe_marche_public_pe,
                         0 as net_payer_pe,
                         0 as montant_travaux_ante,
                         0 as montant_rabais_ante,
                         0 as montant_ht_ante,
                         0 as montant_tva_ante,
                         0 as montant_ttc_ante,
                         0 as remboursement_acompte_ante,
                         0 as penalite_retard_ante,
                         0 as retenue_garantie_ante,
                         0 as remboursement_plaque_ante,
                         0 as taxe_marche_public_ante,
                         0 as net_payer_ante,                         
                         0 as nbr_fact,
                         0 as net_payer_avanc

                        from facture_mpe as fact_mpe

                        inner join attachement_travaux as atta_tra on atta_tra.id=fact_mpe.id_attachement_travaux
                        where fact_mpe.id<= '".$id_facture_mpe."' and
                        atta_tra.id_contrat_prestataire= '".$id_contrat_prestataire."' and fact_mpe.validation = 4

                            group by id_contrat
                )
                UNION
                (
                    select 
                        atta_tra.id_contrat_prestataire as id_contrat,
                        0 as montant_travaux_to,
                        0 as montant_rabais_to,
                        0 as montant_ht_to,
                        0 as montant_tva_to,
                        0 as montant_ttc_to,
                        0 as remboursement_acompte_to,
                        0 as penalite_retard_to,
                        0 as retenue_garantie_to,
                        0 as remboursement_plaque_to,
                        0 as taxe_marche_public_to,
                        0 as net_payer_to,
                         sum(fact_mpe.montant_travaux) as montant_travaux_pe,
                         sum(fact_mpe.montant_rabais) as montant_rabais_pe,
                         sum(fact_mpe.montant_ht) as montant_ht_pe,
                         sum(fact_mpe.montant_tva) as montant_tva_pe,
                         sum(fact_mpe.montant_ttc) as montant_ttc_pe,
                         sum(fact_mpe.remboursement_acompte) as remboursement_acompte_pe,
                         sum(fact_mpe.penalite_retard) as penalite_retard_pe,
                         sum(fact_mpe.retenue_garantie) as retenue_garantie_pe,
                         sum(fact_mpe.remboursement_plaque) as remboursement_plaque_pe,
                         sum(fact_mpe.taxe_marche_public) as taxe_marche_public_pe,
                         sum(fact_mpe.net_payer) as net_payer_pe,
                         0 as montant_travaux_ante,
                         0 as montant_rabais_ante,
                         0 as montant_ht_ante,
                         0 as montant_tva_ante,
                         0 as montant_ttc_ante,
                         0 as remboursement_acompte_ante,
                         0 as penalite_retard_ante,
                         0 as retenue_garantie_ante,
                         0 as remboursement_plaque_ante,
                         0 as taxe_marche_public_ante,
                         0 as net_payer_ante,                         
                         0 as nbr_fact,
                         0 as net_payer_avanc

                        from facture_mpe as fact_mpe

                        inner join attachement_travaux as atta_tra on atta_tra.id=fact_mpe.id_attachement_travaux
                        where 
                        atta_tra.id_contrat_prestataire= '".$id_contrat_prestataire."' and fact_mpe.validation = 4 and fact_mpe.id='".$id_facture_mpe."'
                            group by id_contrat
                )
                UNION
                (
                    select 
                        atta_tra.id_contrat_prestataire as id_contrat,
                        0 as montant_travaux_to,
                        0 as montant_rabais_to,
                        0 as montant_ht_to,
                        0 as montant_tva_to,
                        0 as montant_ttc_to,
                        0 as remboursement_acompte_to,
                        0 as penalite_retard_to,
                        0 as retenue_garantie_to,
                        0 as remboursement_plaque_to,
                        0 as taxe_marche_public_to,
                        0 as net_payer_to,
                         0 as montant_travaux_pe,
                         0 as montant_rabais_pe,
                         0 as montant_ht_pe,
                         0 as montant_tva_pe,
                         0 as montant_ttc_pe,
                         0 as remboursement_acompte_pe,
                         0 as penalite_retard_pe,
                         0 as retenue_garantie_pe,
                         0 as remboursement_plaque_pe,
                         0 as taxe_marche_public_pe,
                         0 as net_payer_pe,
                         sum(fact_mpe.montant_travaux) as montant_travaux_ante,
                         sum(fact_mpe.montant_rabais) as montant_rabais_ante,
                         sum(fact_mpe.montant_ht) as montant_ht_ante,
                         sum(fact_mpe.montant_tva) as montant_tva_ante,
                         sum(fact_mpe.montant_ttc) as montant_ttc_ante,
                         sum(fact_mpe.remboursement_acompte) as remboursement_acompte_ante,
                         sum(fact_mpe.penalite_retard) as penalite_retard_ante,
                         sum(fact_mpe.retenue_garantie) as retenue_garantie_ante,
                         sum(fact_mpe.remboursement_plaque) as remboursement_plaque_ante,
                         sum(fact_mpe.taxe_marche_public) as taxe_marche_public_ante,
                         sum(fact_mpe.net_payer) as net_payer_ante,                         
                         0 as nbr_fact,
                         0 as net_payer_avanc

                        from facture_mpe as fact_mpe

                        inner join attachement_travaux as atta_tra on atta_tra.id=fact_mpe.id_attachement_travaux
                        where 
                        atta_tra.id_contrat_prestataire= '".$id_contrat_prestataire."' and fact_mpe.validation = 4 and fact_mpe.id=(
                                    select max(factu_mpe.id) 
                                        from facture_mpe as factu_mpe
                                        inner join attachement_travaux as atta_trav on atta_trav.id=factu_mpe.id_attachement_travaux
                                            where factu_mpe.id < '".$id_facture_mpe."' and atta_trav.id_contrat_prestataire = '".$id_contrat_prestataire."')

                            group by id_contrat
                )

                UNION
                (
                    select 
                        atta_tra.id_contrat_prestataire as id_contrat,
                        0 as montant_travaux_to,
                        0 as montant_rabais_to,
                        0 as montant_ht_to,
                        0 as montant_tva_to,
                        0 as montant_ttc_to,
                        0 as remboursement_acompte_to,
                        0 as penalite_retard_to,
                        0 as retenue_garantie_to,
                        0 as remboursement_plaque_to,
                        0 as taxe_marche_public_to,
                        0 as net_payer_to,
                         0 as montant_travaux_pe,
                         0 as montant_rabais_pe,
                         0 as montant_ht_pe,
                         0 as montant_tva_pe,
                         0 as montant_ttc_pe,
                         0 as remboursement_acompte_pe,
                         0 as penalite_retard_pe,
                         0 as retenue_garantie_pe,
                         0 as remboursement_plaque_pe,
                         0 as taxe_marche_public_pe,
                         0 as net_payer_pe,
                         0 as montant_travaux_ante,
                         0 as montant_rabais_ante,
                         0 as montant_ht_ante,
                         0 as montant_tva_ante,
                         0 as montant_ttc_ante,
                         0 as remboursement_acompte_ante,
                         0 as penalite_retard_ante,
                         0 as retenue_garantie_ante,
                         0 as remboursement_plaque_ante,
                         0 as remboursement_plaque_ante,
                         0 as net_payer_ante,
                         count(fact_mpe.id) as nbr_fact,
                         0 as net_payer_avanc
                            
                            from facture_mpe as fact_mpe
                         inner join attachement_travaux as atta_tra on atta_tra.id=fact_mpe.id_attachement_travaux   
                        where 
                        atta_tra.id_contrat_prestataire= '".$id_contrat_prestataire."' and fact_mpe.validation = 4 and fact_mpe.id<= '".$id_facture_mpe."'

                            group by id_contrat
                )

                UNION
                (
                    select 
                        avance_dem.id_contrat_prestataire as id_contrat,
                        0 as montant_travaux_to,
                        0 as montant_rabais_to,
                        0 as montant_ht_to,
                        0 as montant_tva_to,
                        0 as montant_ttc_to,
                        0 as remboursement_acompte_to,
                        0 as penalite_retard_to,
                        0 as retenue_garantie_to,
                        0 as remboursement_plaque_to,
                        0 as taxe_marche_public_to,
                        0 as net_payer_to,
                         0 as montant_travaux_pe,
                         0 as montant_rabais_pe,
                         0 as montant_ht_pe,
                         0 as montant_tva_pe,
                         0 as montant_ttc_pe,
                         0 as remboursement_acompte_pe,
                         0 as penalite_retard_pe,
                         0 as retenue_garantie_pe,
                         0 as remboursement_plaque_pe,
                         0 as taxe_marche_public_pe,
                         0 as net_payer_pe,
                         0 as montant_travaux_ante,
                         0 as montant_rabais_ante,
                         0 as montant_ht_ante,
                         0 as montant_tva_ante,
                         0 as montant_ttc_ante,
                         0 as remboursement_acompte_ante,
                         0 as penalite_retard_ante,
                         0 as retenue_garantie_ante,
                         0 as remboursement_plaque_ante,
                         0 as taxe_marche_public_ante,
                         0 as net_payer_ante,
                         0 as nbr_fact,
                         sum(avance_dem.net_payer) as net_payer_avanc
                            
                            from avance_demarrage as avance_dem

                        where 
                        avance_dem.id_contrat_prestataire= '".$id_contrat_prestataire."' and avance_dem.validation = 4

                            group by id_contrat
                )

                )detail

                group by id_contrat

            ";
            return $this->db->query($sql)->result();             
    }
        

}
