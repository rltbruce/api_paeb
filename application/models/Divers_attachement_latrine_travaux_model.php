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
            'montant_periode'       =>      $attachement['montant_periode'],
            'montant_anterieur'       =>      $attachement['montant_anterieur'],
            'montant_cumul'       =>      $attachement['montant_cumul'],
            'pourcentage'       =>      $attachement['pourcentage'],
            'id_demande_latrine_mpe'   =>      $attachement['id_demande_latrine_mpe'],
            'id_divers_attachement_latrine_prevu'    => $attachement['id_divers_attachement_latrine_prevu']                       
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
    public function finddivers_attachementByDemande($id_demande_latrine_mpe)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_demande_latrine_mpe',$id_demande_latrine_mpe)
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
    public function findmaxattachement_travauxByattachement_prevu($id_divers_attachement_latrine_prevu,$id_contrat_prestataire)
    {               
        $sql = "select divers_attachement_latrine_travaux.*
                        from divers_attachement_latrine_travaux
                        inner join demande_latrine_presta on demande_latrine_presta.id=divers_attachement_latrine_travaux.id_demande_latrine_mpe
                        inner join attachement_travaux on attachement_travaux.id=demande_latrine_presta.id_attachement_travaux
                        inner join facture_mpe on facture_mpe.id=attachement_travaux.id_facture_mpe
                        where divers_attachement_latrine_travaux.id=(select max(id) from divers_attachement_latrine_travaux) and id_divers_attachement_latrine_prevu =".$id_divers_attachement_latrine_prevu." and facture_mpe.id_contrat_prestataire =".$id_contrat_prestataire."";
        return $this->db->query($sql)->result();                  
    }
  /*  public function finddivers_attachementByDemande($id_contrat_prestataire,$id_demande_latrine_mpe) {
        $sql="
                select detail.description as description, 
                        detail.libelle as libelle, 
                        detail.id_attache_latrine as id_attache_latrine,
                        detail.id as id,
                        detail.id_contrat_prestataire as id_contrat_prestataire,
                        detail.montant_prevu as montant_prevu, 
                        detail.id_divers_attachement_latrine_travaux as id_divers_attachement_latrine_travaux,
                        detail.montant_periode as montant_periode,
                        detail.montant_anterieur as montant_anterieur,
                        detail.montant_cumul as montant_cumul,
                        detail.pourcentage as pourcentage

                    from
                (select  
                        attache_latrine.description as description, 
                        attache_latrine.libelle as libelle, 
                        attache_latrine.id as id_attache_latrine,
                        attache_prevu.id as id,
                        attache_prevu.id_contrat_prestataire as id_contrat_prestataire,
                        attache_prevu.montant_prevu as montant_prevu, 
                        attache_travaux.id as id_divers_attachement_latrine_travaux,
                        attache_travaux.montant_periode as montant_periode,
                        attache_travaux.montant_anterieur as montant_anterieur,
                        attache_travaux.montant_cumul as montant_cumul,
                        attache_travaux.pourcentage as pourcentage

                    from divers_attachement_latrine_travaux as attache_travaux
            
                        right join divers_attachement_latrine_prevu as attache_prevu on attache_travaux.id_divers_attachement_latrine_prevu = attache_prevu.id 
                        inner join divers_attachement_latrine as attache_latrine on attache_prevu.id_divers_attachement_latrine = attache_latrine.id
            
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_travaux.id_demande_latrine_mpe = ".$id_demande_latrine_mpe."
            
                        group by attache_prevu.id_divers_attachement_latrine 
                UNION 

                select  
                        attache_latrine.description as description, 
                        attache_latrine.libelle as libelle, 
                        attache_latrine.id as id_attache_latrine,
                        attache_prevu.id as id,
                        attache_prevu.id_contrat_prestataire as id_contrat_prestataire,
                        attache_prevu.montant_prevu as montant_prevu, 
                        0 as id_divers_attachement_latrine_travaux,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul,
                        0 as pourcentage

                    from divers_attachement_latrine_prevu as attache_prevu
                        inner join divers_attachement_latrine as attache_latrine on attache_prevu.id_divers_attachement_latrine = attache_latrine.id
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire."
            
                        group by attache_prevu.id_divers_attachement_latrine) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }*/


}
