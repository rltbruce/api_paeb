<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divers_attachement_latrine_model extends CI_Model {
    protected $table = 'divers_attachement_latrine';

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
            'libelle'       =>      $attachement['libelle'],
            'description'   =>      $attachement['description'],
            'numero'    => $attachement['numero']                       
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
                        ->order_by('numero')
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

     public function getrubrique_attachement_withmontant_prevu($id_contrat_prestataire) {
        $sql="
                select detail.id as id, 
                        detail.numero as numero, 
                        detail.libelle as libelle,
                        sum(detail.montant_prevu) as montant_prevu 

                    from
                (
                select 
                        attache_latrine.id as id, 
                        attache_latrine.numero as numero, 
                        attache_latrine.libelle as libelle,
                        sum(attache_latrine_prevu.montant_prevu) as montant_prevu   

                    from divers_attachement_latrine_prevu as attache_latrine_prevu
            
                        left join divers_attachement_latrine_detail as attache_latrine_detail on attache_latrine_detail.id = attache_latrine_prevu.id_attachement_latrine_detail
                        left join divers_attachement_latrine as attache_latrine on attache_latrine.id = attache_latrine_detail.id_attachement_latrine 
            
                        where attache_latrine_prevu.id_contrat_prestataire = ".$id_contrat_prestataire."
            
                        group by attache_latrine.id
                UNION 

                
                select 
                        attache_latrine.id as id, 
                        attache_latrine.numero as numero, 
                        attache_latrine.libelle as libelle,
                        0 as montant_prevu   

                    from divers_attachement_latrine as attache_latrine
            
                        group by attache_latrine.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

     public function getrubrique_attachement_withmontantbycontrat($id_contrat_prestataire,$id_demande_latrine) {
        $sql="
                select detail.id as id, 
                        detail.numero as numero, 
                        detail.libelle as libelle,
                        sum(detail.montant_prevu) as montant_prevu,
                        sum(detail.montant_periode) as montant_periode,
                        sum(detail.montant_anterieur) as montant_anterieur,
                        (sum(detail.montant_anterieur)+sum(detail.montant_periode)) as montant_cumul,
                        (((sum(detail.montant_anterieur)+sum(detail.montant_periode))*100)/sum(detail.montant_prevu)) as pourcentage,
                        ((sum(detail.montant_periode)*100)/sum(detail.montant_prevu)) as pourcentage_periode,
                        ((sum(detail.montant_anterieur)*100)/sum(detail.montant_prevu)) as pourcentage_anterieur 

                    from
                (
                select 
                        attache_latrine.id as id, 
                        attache_latrine.numero as numero, 
                        attache_latrine.libelle as libelle,
                        sum(attache_latrine_prevu.montant_prevu) as montant_prevu,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul   

                    from divers_attachement_latrine_prevu as attache_latrine_prevu
            
                        inner join divers_attachement_latrine_detail as attache_latrine_detail on attache_latrine_detail.id = attache_latrine_prevu.id_attachement_latrine_detail
                        inner join divers_attachement_latrine as attache_latrine on attache_latrine.id = attache_latrine_detail.id_attachement_latrine 
            
                        where attache_latrine_prevu.id_contrat_prestataire = ".$id_contrat_prestataire."
            
                        group by attache_latrine.id
                UNION 

                select 
                        attache_latrine.id as id, 
                        attache_latrine.numero as numero, 
                        attache_latrine.libelle as libelle,
                        0 as montant_prevu,
                        sum(attache_latrine_travaux.montant_periode) as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul   

                    from demande_latrine_presta as demande
            
                        inner join divers_attachement_latrine_travaux as attache_latrine_travaux  on demande.id = attache_latrine_travaux .id_demande_latrine_mpe
                        inner join divers_attachement_latrine_prevu as attache_latrine_prevu on attache_latrine_prevu.id = attache_latrine_travaux.id_attachement_latrine_prevu
                        inner join divers_attachement_latrine_detail as attache_latrine_detail on attache_latrine_detail.id = attache_latrine_prevu.id_attachement_latrine_detail
                        inner join divers_attachement_latrine as attache_latrine on attache_latrine.id = attache_latrine_detail.id_attachement_latrine 
            
                        where attache_latrine_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and demande.id = ".$id_demande_latrine."
            
                        group by attache_latrine.id
                UNION

                select 
                        attache_latrine.id as id, 
                        attache_latrine.numero as numero, 
                        attache_latrine.libelle as libelle,
                        0 as montant_prevu,
                        0 as montant_periode,
                        sum(attache_latrine_travaux.montant_periode) as montant_anterieur,
                        0 as montant_cumul   

                    from demande_latrine_presta as demande
            
                        inner join divers_attachement_latrine_travaux as attache_latrine_travaux  on demande.id = attache_latrine_travaux .id_demande_latrine_mpe
                        inner join divers_attachement_latrine_prevu as attache_latrine_prevu on attache_latrine_prevu.id = attache_latrine_travaux.id_attachement_latrine_prevu
                        inner join divers_attachement_latrine_detail as attache_latrine_detail on attache_latrine_detail.id = attache_latrine_prevu.id_attachement_latrine_detail
                        inner join divers_attachement_latrine as attache_latrine on attache_latrine.id = attache_latrine_detail.id_attachement_latrine 
                        inner join attachement_travaux as atta_tra on atta_tra.id=demande.id_attachement_travaux
                        inner join facture_mpe as fact_mpe on fact_mpe.id_attachement_travaux=atta_tra.id
                        where attache_latrine_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and fact_mpe.validation=4 and demande.id= (select max(dem_latrine.id) from demande_latrine_presta as dem_latrine 
                            inner join attachement_travaux as atta_tra on atta_tra.id=dem_latrine.id_attachement_travaux
                            inner join facture_mpe as fact_mpe on fact_mpe.id_attachement_travaux=atta_tra.id where attache_latrine_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and fact_mpe.validation=4 and dem_latrine.id<".$id_demande_latrine.") 
            
                        group by attache_latrine.id
                UNION

                select 
                        attache_latrine.id as id, 
                        attache_latrine.numero as numero, 
                        attache_latrine.libelle as libelle,
                        0 as montant_prevu,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul  

                    from divers_attachement_latrine as attache_latrine
            
                        group by attache_latrine.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }
    /* public function getrubrique_attachement_withmontantbycontrat($id_contrat_prestataire,$id_demande_latrine) {
        $sql="
                select detail.id as id, 
                        detail.numero as numero, 
                        detail.libelle as libelle,
                        sum(detail.montant_prevu) as montant_prevu,
                        sum(detail.montant_periode) as montant_periode,
                        sum(detail.montant_anterieur) as montant_anterieur,
                        sum(detail.montant_cumul) as montant_cumul,
                        (sum(detail.montant_cumul)*100)/sum(detail.montant_prevu) as pourcentage 

                    from
                (select 
                        attache_latrine.id as id, 
                        attache_latrine.numero as numero, 
                        attache_latrine.libelle as libelle,
                        0 as montant_prevu,
                        sum(attache_latrine_travaux.montant_periode) as montant_periode,
                        sum(attache_latrine_travaux.montant_anterieur) as montant_anterieur,
                        sum(attache_latrine_travaux.montant_cumul) as montant_cumul   

                    from demande_latrine_presta as demande
            
                        inner join divers_attachement_latrine_travaux as attache_latrine_travaux  on demande.id = attache_latrine_travaux .id_demande_latrine_mpe
                        inner join divers_attachement_latrine_prevu as attache_latrine_prevu on attache_latrine_prevu.id = attache_latrine_travaux.id_attachement_latrine_prevu
                        inner join divers_attachement_latrine_detail as attache_latrine_detail on attache_latrine_detail.id = attache_latrine_prevu.id_attachement_latrine_detail
                        inner join divers_attachement_latrine as attache_latrine on attache_latrine.id = attache_latrine_detail.id_attachement_latrine 
            
                        where attache_latrine_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and demande.id = ".$id_demande_latrine."
            
                        group by demande.id,attache_latrine.id
                UNION
                select 
                        attache_latrine.id as id, 
                        attache_latrine.numero as numero, 
                        attache_latrine.libelle as libelle,
                        sum(attache_latrine_prevu.montant_prevu) as montant_prevu,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul   

                    from divers_attachement_latrine_prevu as attache_latrine_prevu
            
                        inner join divers_attachement_latrine_detail as attache_latrine_detail on attache_latrine_detail.id = attache_latrine_prevu.id_attachement_latrine_detail
                        inner join divers_attachement_latrine as attache_latrine on attache_latrine.id = attache_latrine_detail.id_attachement_latrine 
            
                        where attache_latrine_prevu.id_contrat_prestataire = ".$id_contrat_prestataire."
            
                        group by attache_latrine.id
                UNION 

                select 
                        attache_latrine.id as id, 
                        attache_latrine.numero as numero, 
                        attache_latrine.libelle as libelle,
                        0 as montant_prevu,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul  

                    from divers_attachement_latrine as attache_latrine
            
                        group by attache_latrine.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }*/
     public function findattachementBycontrat($id_contrat_prestataire,$id_type_latrine) {
        $sql="
                select detail.id as id, 
                        detail.description as description, 
                        detail.libelle as libelle,
                        detail.id_divers_attachement_latrine_prevu as id_divers_attachement_latrine_prevu,
                        detail.id_contrat_prestataire as id_contrat_prestataire,
                        detail.montant_prevu as montant_prevu

                    from
                (select 
                        attache_latrine.id as id, 
                        attache_latrine.description as description, 
                        attache_latrine.libelle as libelle,
                        attache_prevu.id as id_divers_attachement_latrine_prevu,
                        attache_prevu.id_contrat_prestataire as id_contrat_prestataire,
                        attache_prevu.montant_prevu as montant_prevu 

                    from divers_attachement_latrine_prevu as attache_prevu
            
                        right join divers_attachement_latrine as attache_latrine on attache_prevu.id_divers_attachement_latrine = attache_latrine.id 
            
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_latrine.id_type_latrine = ".$id_type_latrine."
            
                        group by attache_latrine.id 
                UNION 

                select 
                        attache_latrine.id as id, 
                        attache_latrine.description as description, 
                        attache_latrine.libelle as libelle,
                        null as id_divers_attachement_latrine_prevu,
                        null as id_contrat_prestataire,
                        null as montant_prevu  

                    from divers_attachement_latrine as attache_latrine
                        where attache_latrine.id_type_latrine = ".$id_type_latrine."
                        group by attache_latrine.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }



}
