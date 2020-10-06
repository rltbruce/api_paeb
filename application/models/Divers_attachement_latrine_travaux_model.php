<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divers_attachement_latrine_travaux_model extends CI_Model {
    protected $table = 'divers_attachement_latrine_travaux';

    public function add($attachement) {
        $this->db->set($this->_set($attachement))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $attachement) {
        $this->db->set($this->_set($attachement))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($attachement) {
        return array(
            'quantite_periode'       =>      $attachement['quantite_periode'],
            'quantite_anterieur'       =>      $attachement['quantite_anterieur'],
            'quantite_cumul'       =>      $attachement['quantite_cumul'],
            'montant_periode'       =>      $attachement['montant_periode'],
            'montant_anterieur'       =>      $attachement['montant_anterieur'],
            'montant_cumul'       =>      $attachement['montant_cumul'],
            'pourcentage'       =>      $attachement['pourcentage'],
            'id_demande_latrine_mpe'   =>      $attachement['id_demande_latrine_mpe'],
            'id_attachement_latrine_prevu'    => $attachement['id_attachement_latrine_prevu']                       
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
    public function finddivers_attachementByDemande($id_contrat_prestataire,$id_demande_latrine_mpe,$id_attache_latrine) {
        $sql="
                select  detail.libelle as libelle,
                        detail.numero as numero,
                        detail.id_attachement_latrine_detail as id_attachement_latrine_detail,
                        detail.id_attachement_latrine_prevu as id_attachement_latrine_prevu,
                        detail.id as id,
                        sum(detail.montant_periode) as montant_periode,
                        ((sum(detail.montant_periode) *100)/sum(detail.montant_prevu)) as pourcentage_periode,
                        sum(detail.montant_anterieur) as montant_anterieur,
                        ((sum(detail.montant_anterieur) *100)/sum(detail.montant_prevu)) as pourcentage_anterieur,
                        (sum(detail.montant_cumul)+sum(detail.montant_periode)) as montant_cumul,
                        (((sum(detail.montant_cumul)+sum(detail.montant_periode)) *100)/sum(detail.montant_prevu)) as pourcentage_cumul,
                        sum(detail.quantite_periode) as quantite_periode,
                        sum(detail.quantite_anterieur) as quantite_anterieur,
                        (sum(detail.quantite_cumul)+sum(detail.quantite_periode)) as quantite_cumul,
                        sum(detail.montant_prevu) as montant_prevu,
                        sum(detail.prix_unitaire) as prix_unitaire,
                        sum(detail.quantite_prevu) as quantite_prevu,
                        detail.unite as unite 

                    from
                (select  
                        attache_detail.id as id_attachement_latrine_detail,
                        attache_prevu.id as id_attachement_latrine_prevu,
                        attache_detail.libelle as libelle,
                        attache_detail.numero as numero,
                        attache_travaux.id as id,
                        attache_travaux.montant_periode as montant_periode,
                        attache_travaux.quantite_periode as quantite_periode,
                        0 as montant_anterieur,
                        0 as quantite_anterieur,
                        0 as montant_cumul,
                        0 as quantite_cumul,
                        0 as montant_prevu,
                        0 as quantite_prevu,
                        0 as prix_unitaire,                        
                        attache_prevu.unite as unite

                    from divers_attachement_latrine_travaux as attache_travaux
            
                        inner join divers_attachement_latrine_prevu as attache_prevu on attache_travaux.id_attachement_latrine_prevu = attache_prevu.id
                        inner join divers_attachement_latrine_detail as attache_detail on attache_prevu.id_attachement_latrine_detail = attache_detail.id 
                        inner join divers_attachement_latrine as attache_latrine on attache_detail.id_attachement_latrine = attache_latrine.id
            
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_travaux.id_demande_latrine_mpe = ".$id_demande_latrine_mpe." and attache_latrine.id = ".$id_attache_latrine."
            
                        group by attache_detail.id 
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_latrine_detail,
                        attache_prevu.id as id_attachement_latrine_prevu,
                        attache_detail.libelle as libelle,
                        attache_detail.numero as numero,
                        attache_travaux.id as id,
                        0 as montant_periode,
                        0 as quantite_periode,
                        attache_travaux.montant_periode as montant_anterieur,
                        attache_travaux.quantite_periode as quantite_anterieur,
                        0 as montant_cumul,
                        0 as quantite_cumul,
                        0 as montant_prevu,
                        0 as quantite_prevu,
                        0 as prix_unitaire,
                        attache_prevu.unite as unite

                    from divers_attachement_latrine_travaux as attache_travaux
            
                        inner join divers_attachement_latrine_prevu as attache_prevu on attache_travaux.id_attachement_latrine_prevu = attache_prevu.id
                        inner join divers_attachement_latrine_detail as attache_detail on attache_prevu.id_attachement_latrine_detail = attache_detail.id 
                        inner join divers_attachement_latrine as attache_latrine on attache_detail.id_attachement_latrine = attache_latrine.id
                        inner join facture_mpe as fact on fact.id_attachement_travaux = attache_travaux.id
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_latrine.id = ".$id_attache_latrine." and attache_travaux.id_demande_latrine_mpe =(select max(id) from divers_attachement_latrine_travaux as div_atta_bat_tra where div_atta_bat_tra.id_demande_latrine_mpe <".$id_demande_latrine_mpe.") and fact.validation=4
            
                        group by attache_detail.id
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_latrine_detail,
                        attache_prevu.id as id_attachement_latrine_prevu,
                        attache_detail.libelle as libelle,
                        attache_detail.numero as numero,
                        attache_travaux.id as id,
                        0 as montant_periode,
                        0 as quantite_periode,
                        0 as montant_anterieur,
                        0 as quantite_anterieur,
                        sum(attache_travaux.montant_periode) as montant_cumul,
                        sum(attache_travaux.quantite_periode) as quantite_cumul,
                        0 as montant_prevu,
                        0 as quantite_prevu,
                        0 as prix_unitaire,
                        attache_prevu.unite as unite

                    from divers_attachement_latrine_travaux as attache_travaux
            
                        inner join divers_attachement_latrine_prevu as attache_prevu on attache_travaux.id_attachement_latrine_prevu = attache_prevu.id
                        inner join divers_attachement_latrine_detail as attache_detail on attache_prevu.id_attachement_latrine_detail = attache_detail.id 
                        inner join divers_attachement_latrine as attache_latrine on attache_detail.id_attachement_latrine = attache_latrine.id
                        inner join facture_mpe as fact on fact.id_attachement_travaux = attache_travaux.id
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_latrine.id = ".$id_attache_latrine." and attache_travaux.id_demande_latrine_mpe <".$id_demande_latrine_mpe." and fact.validation=4
            
                        group by attache_detail.id
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_latrine_detail,
                        attache_prevu.id as id_attachement_latrine_prevu,
                        attache_detail.libelle as libelle,
                        attache_detail.numero as numero,
                        0 as id,
                        0 as montant_periode,
                        0 as quantite_periode,
                        0 as montant_anterieur,
                        0 as quantite_anterieur,
                        0 as montant_cumul,
                        0 as quantite_cumul,
                        attache_prevu.montant_prevu as montant_prevu,
                        attache_prevu.quantite_prevu as quantite_prevu,
                        attache_prevu.prix_unitaire as prix_unitaire,
                        attache_prevu.unite as unite

                    from divers_attachement_latrine_prevu as attache_prevu
                        inner join divers_attachement_latrine_detail as attache_detail on attache_prevu.id_attachement_latrine_detail = attache_detail.id 
                        inner join divers_attachement_latrine as attache_latrine on attache_detail.id_attachement_latrine = attache_latrine.id
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_latrine.id = ".$id_attache_latrine."
            
                        group by attache_detail.id
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_latrine_detail,
                        attache_prevu.id as id_attachement_latrine_prevu,
                        attache_detail.libelle as libelle,
                        attache_detail.numero as numero,
                        0 as id,
                        0 as montant_periode,
                        0 as quantite_periode,
                        0 as montant_anterieur,
                        0 as quantite_anterieur,
                        0 as montant_cumul,
                        0 as quantite_cumul,
                        0 as montant_prevu,
                        0 as quantite_prevu,
                        0 as prix_unitaire,
                        attache_prevu.unite as unite

                    from divers_attachement_latrine_detail as attache_detail
                        inner join divers_attachement_latrine as attache_latrine on attache_detail.id_attachement_latrine = attache_latrine.id
                        inner join divers_attachement_latrine_prevu as attache_prevu on attache_detail.id= attache_prevu.id_attachement_latrine_detail
                        where attache_latrine.id = ".$id_attache_latrine."
            
                        group by attache_detail.id) detail
                group by detail.id_attachement_latrine_detail  ";
        return $this->db->query($sql)->result();                
    }
   /* public function findmaxattachement_travauxByattachement_prevu($id_attachement_latrine_prevu,$id_contrat_prestataire)
    {               
        $sql = "select divers_attachement_latrine_travaux.*
                        from divers_attachement_latrine_travaux
                        inner join divers_attachement_latrine_prevu on divers_attachement_latrine_prevu.id=divers_attachement_latrine_travaux.id_attachement_latrine_prevu
                        where divers_attachement_latrine_travaux.id=(select max(id) from divers_attachement_latrine_travaux) and divers_attachement_latrine_prevu.id =".$id_attachement_latrine_prevu." and divers_attachement_latrine_prevu.id_contrat_prestataire =".$id_contrat_prestataire."";
        return $this->db->query($sql)->result();                  
    }
    public function findmax_1attachement_travauxByattachement_prevu($id_attachement_latrine_prevu,$id_contrat_prestataire)
    {               
        $sql = "select divers_attachement_latrine_travaux.*
                        from divers_attachement_latrine_travaux
                        inner join divers_attachement_latrine_prevu on divers_attachement_latrine_prevu.id=divers_attachement_latrine_travaux.id_attachement_latrine_prevu
                        where divers_attachement_latrine_travaux.id=(select max(id) from divers_attachement_latrine_travaux as attache_lat where attache_lat.id <(select max(id) from divers_attachement_latrine_travaux)) and divers_attachement_latrine_prevu.id =".$id_attachement_latrine_prevu." and divers_attachement_latrine_prevu.id_contrat_prestataire =".$id_contrat_prestataire."";
        return $this->db->query($sql)->result();                  
    }*/

}
