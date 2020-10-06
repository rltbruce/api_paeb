<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facture_moe_detail_model extends CI_Model {
    protected $table = 'facture_moe_detail';

    public function add($facture_moe_detail) {
        $this->db->set($this->_set($facture_moe_detail))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $facture_moe_detail) {
        $this->db->set($this->_set($facture_moe_detail))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($facture_moe_detail) {
        return array(
            'montant_periode'       =>      $facture_moe_detail['montant_periode'],
            'observation'       =>      $facture_moe_detail['observation'],
            'id_calendrier_paie_moe_prevu'   =>      $facture_moe_detail['id_calendrier_paie_moe_prevu'],
            'id_facture_moe_entete'    => $facture_moe_detail['id_facture_moe_entete']                       
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


     public function getfacture_moe_detailwithcalendrier_detailbyentete($id_contrat_bureau_etude,$id_facture_moe_entete,$id_sousrubrique) {
        $sql="
                select detail.id as id, 
                        detail.id_calendrier_paie_moe_prevu as id_calendrier_paie_moe_prevu, 
                        detail.libelle as libelle,
                        sum(detail.montant_prevu) as montant_prevu ,
                        sum(detail.pourcentage) as pourcentage,
                        sum(detail.montant_periode) as montant_periode ,
                        detail.observation as observation ,
                        sum(detail.montant_anterieur) as montant_anterieur,
                        (sum(detail.montant_cumul)+sum(detail.montant_periode)) as montant_cumul,
                        ((sum(detail.montant_periode)*100)/sum(detail.montant_prevu)) as pourcentage_periode,
                        ((sum(detail.montant_anterieur)*100)/sum(detail.montant_prevu)) as pourcentage_anterieur,
                        (((sum(detail.montant_cumul)+sum(detail.montant_periode))*100)/sum(detail.montant_prevu)) as pourcentage_cumul

                    from
                (
                select 
                        calendrier_paie_moe_prevu.id as id_calendrier_paie_moe_prevu, 
                        sousrubrique_calendrier_detail.libelle as libelle,
                        fact_detail.id as id,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        fact_detail.observation as observation,
                        0 as montant_anterieur,
                        0 as montant_cumul  

                    from divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu
            
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail  
                        left join facture_moe_detail as fact_detail on fact_detail.id_calendrier_paie_moe_prevu=calendrier_paie_moe_prevu.id
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
            
                        group by sousrubrique_calendrier_detail.id 
                UNION 

                select 
                        calendrier_paie_moe_prevu.id as id_calendrier_paie_moe_prevu, 
                        sousrubrique_calendrier_detail.libelle as libelle,
                        fact_detail.id as id,
                        0 as montant_prevu,
                        sum(sousrubrique_calendrier_detail.pourcentage) as pourcentage,
                        0 as montant_periode,
                        fact_detail.observation as observation,
                        0 as montant_anterieur,
                        0 as montant_cumul   

                    from divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail
                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id_sousrubrique_detail = sousrubrique_calendrier_detail.id
                        left join facture_moe_detail as fact_detail on fact_detail.id_calendrier_paie_moe_prevu=calendrier_paie_moe_prevu.id
                        where  sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."

                        group by sousrubrique_calendrier_detail.id 
                UNION 

                select 
                        calendrier_paie_moe_prevu.id as id_calendrier_paie_moe_prevu, 
                        sousrubrique_calendrier_detail.libelle as libelle,
                        fact_detail.id as id,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        sum(fact_detail.montant_periode) as montant_periode,
                        fact_detail.observation as observation,
                        0 as montant_anterieur,
                        0 as montant_cumul  

                    from facture_moe_detail as fact_detail
                        left join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique."
            
                        group by sousrubrique_calendrier_detail.id 
                UNION

                select 
                        calendrier_paie_moe_prevu.id as id_calendrier_paie_moe_prevu,  
                        sousrubrique_calendrier_detail.libelle as libelle,
                        fact_detail.id as id,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        0 as montant_periode,
                        fact_detail.observation as observation, 
                        sum(fact_detail.montant_periode) as montant_anterieur,
                        0 as montant_cumul  

                    from facture_moe_detail as fact_detail
                        left join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique." and fact_detail.id_facture_moe_entete = (select max(f_entete.id) from facture_moe_entete as f_entete where f_entete.id<".$id_facture_moe_entete." and f_entete.id_contrat_bureau_etude = ".$id_contrat_bureau_etude.") 
            
                        group by sousrubrique_calendrier_detail.id 
                UNION

                select 
                        calendrier_paie_moe_prevu.id as id_calendrier_paie_moe_prevu,  
                        sousrubrique_calendrier_detail.libelle as libelle,
                        fact_detail.id as id,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        0 as montant_periode,
                        fact_detail.observation as observation, 
                        0 as montant_anterieur, 
                        sum(fact_detail.montant_periode) as montant_cumul  

                    from facture_moe_detail as fact_detail
                        left join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_detail.id_facture_moe_entete<".$id_facture_moe_entete." and sousrubrique_calendrier_detail.id_sousrubrique = ".$id_sousrubrique." 
            
                        group by sousrubrique_calendrier_detail.id) detail
                group by detail.id_calendrier_paie_moe_prevu order by detail.id_calendrier_paie_moe_prevu ";
        return $this->db->query($sql)->result();                
    }

   


}
