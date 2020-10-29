<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divers_attachement_mobilier_model extends CI_Model {
    protected $table = 'divers_attachement_mobilier';

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
                        attache_mobilier.id as id, 
                        attache_mobilier.numero as numero, 
                        attache_mobilier.libelle as libelle,
                        sum(attache_mobilier_prevu.montant_prevu) as montant_prevu   

                    from divers_attachement_mobilier_prevu as attache_mobilier_prevu
            
                        left join divers_attachement_mobilier_detail as attache_mobilier_detail on attache_mobilier_detail.id = attache_mobilier_prevu.id_attachement_mobilier_detail
                        left join divers_attachement_mobilier as attache_mobilier on attache_mobilier.id = attache_mobilier_detail.id_attachement_mobilier 
            
                        where attache_mobilier_prevu.id_contrat_prestataire = ".$id_contrat_prestataire."
            
                        group by attache_mobilier.id
                UNION 

                
                select 
                        attache_mobilier.id as id, 
                        attache_mobilier.numero as numero, 
                        attache_mobilier.libelle as libelle,
                        0 as montant_prevu   

                    from divers_attachement_mobilier as attache_mobilier
            
                        group by attache_mobilier.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }
     public function getrubrique_attachement_withmontantbycontrat($id_contrat_prestataire,$id_demande_mobilier) {
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
                        attache_mobilier.id as id, 
                        attache_mobilier.numero as numero, 
                        attache_mobilier.libelle as libelle,
                        sum(attache_mobilier_prevu.montant_prevu) as montant_prevu,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul   

                    from divers_attachement_mobilier_prevu as attache_mobilier_prevu
            
                        inner join divers_attachement_mobilier_detail as attache_mobilier_detail on attache_mobilier_detail.id = attache_mobilier_prevu.id_attachement_mobilier_detail
                        inner join divers_attachement_mobilier as attache_mobilier on attache_mobilier.id = attache_mobilier_detail.id_attachement_mobilier 
            
                        where attache_mobilier_prevu.id_contrat_prestataire = ".$id_contrat_prestataire."
            
                        group by attache_mobilier.id
                UNION 

                select 
                        attache_mobilier.id as id, 
                        attache_mobilier.numero as numero, 
                        attache_mobilier.libelle as libelle,
                        0 as montant_prevu,
                        sum(attache_mobilier_travaux.montant_periode) as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul   

                    from demande_mobilier_presta as demande
            
                        inner join divers_attachement_mobilier_travaux as attache_mobilier_travaux  on demande.id = attache_mobilier_travaux .id_demande_mobilier_mpe
                        inner join divers_attachement_mobilier_prevu as attache_mobilier_prevu on attache_mobilier_prevu.id = attache_mobilier_travaux.id_attachement_mobilier_prevu
                        inner join divers_attachement_mobilier_detail as attache_mobilier_detail on attache_mobilier_detail.id = attache_mobilier_prevu.id_attachement_mobilier_detail
                        inner join divers_attachement_mobilier as attache_mobilier on attache_mobilier.id = attache_mobilier_detail.id_attachement_mobilier 
            
                        where attache_mobilier_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and demande.id = ".$id_demande_mobilier."
            
                        group by attache_mobilier.id
                UNION

                select 
                        attache_mobilier.id as id, 
                        attache_mobilier.numero as numero, 
                        attache_mobilier.libelle as libelle,
                        0 as montant_prevu,
                        0 as montant_periode,
                        sum(attache_mobilier_travaux.montant_periode) as montant_anterieur,
                        0 as montant_cumul   

                    from demande_mobilier_presta as demande
            
                        inner join divers_attachement_mobilier_travaux as attache_mobilier_travaux  on demande.id = attache_mobilier_travaux .id_demande_mobilier_mpe
                        inner join divers_attachement_mobilier_prevu as attache_mobilier_prevu on attache_mobilier_prevu.id = attache_mobilier_travaux.id_attachement_mobilier_prevu
                        inner join divers_attachement_mobilier_detail as attache_mobilier_detail on attache_mobilier_detail.id = attache_mobilier_prevu.id_attachement_mobilier_detail
                        inner join divers_attachement_mobilier as attache_mobilier on attache_mobilier.id = attache_mobilier_detail.id_attachement_mobilier 
                        inner join attachement_travaux as atta_tra on atta_tra.id=demande.id_attachement_travaux
                        inner join facture_mpe as fact_mpe on fact_mpe.id_attachement_travaux=atta_tra.id
                        where attache_mobilier_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and fact_mpe.validation=4 and demande.id<".$id_demande_mobilier." 
            
                        group by attache_mobilier.id
                UNION

                select 
                        attache_mobilier.id as id, 
                        attache_mobilier.numero as numero, 
                        attache_mobilier.libelle as libelle,
                        0 as montant_prevu,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul  

                    from divers_attachement_mobilier as attache_mobilier
            
                        group by attache_mobilier.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }
     public function findattachementBycontrat($id_contrat_prestataire,$id_type_mobilier) {
        $sql="
                select detail.id as id, 
                        detail.description as description, 
                        detail.libelle as libelle,
                        detail.id_divers_attachement_mobilier_prevu as id_divers_attachement_mobilier_prevu,
                        detail.id_contrat_prestataire as id_contrat_prestataire,
                        detail.montant_prevu as montant_prevu

                    from
                (select 
                        attache_mobilier.id as id, 
                        attache_mobilier.description as description, 
                        attache_mobilier.libelle as libelle,
                        attache_prevu.id as id_divers_attachement_mobilier_prevu,
                        attache_prevu.id_contrat_prestataire as id_contrat_prestataire,
                        attache_prevu.montant_prevu as montant_prevu 

                    from divers_attachement_mobilier_prevu as attache_prevu
            
                        right join divers_attachement_mobilier as attache_mobilier on attache_prevu.id_divers_attachement_mobilier = attache_mobilier.id 
            
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_mobilier.id_type_mobilier = ".$id_type_mobilier."
            
                        group by attache_mobilier.id 
                UNION 

                select 
                        attache_mobilier.id as id, 
                        attache_mobilier.description as description, 
                        attache_mobilier.libelle as libelle,
                        null as id_divers_attachement_mobilier_prevu,
                        null as id_contrat_prestataire,
                        null as montant_prevu  

                    from divers_attachement_mobilier as attache_mobilier
                        where attache_mobilier.id_type_mobilier = ".$id_type_mobilier."
                        group by attache_mobilier.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }



}
