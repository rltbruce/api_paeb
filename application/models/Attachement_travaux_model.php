<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attachement_travaux_model extends CI_Model {
    protected $table = 'attachement_travaux';

    public function add($attachement_travaux) {
        $this->db->set($this->_set($attachement_travaux))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $attachement_travaux) {
        $this->db->set($this->_set($attachement_travaux))
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
    public function _set($attachement_travaux) {
        return array(
            'numero' => $attachement_travaux['numero'],
            'date_fin' => $attachement_travaux['date_fin'],
            'date_debut' => $attachement_travaux['date_debut'],
            'total_prevu' => $attachement_travaux['total_prevu'],
            'total_cumul' => $attachement_travaux['total_cumul'],
            'total_anterieur' => $attachement_travaux['total_anterieur'],
            'total_periode' => $attachement_travaux['total_periode'],
            'id_facture_mpe' => $attachement_travaux['id_facture_mpe'],
            'validation'    =>  $attachement_travaux['validation']                      
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
    public function findattachement_travauxByfacture($id_facture_mpe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_facture_mpe", $id_facture_mpe)
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
    public function findmontant_attachement_prevuBycontrat($id_contrat_prestataire)
    {               
        $sql=" select 
                       detail.id_contrat as id_contrat,
                       sum(detail.montant_prevu_bat) as montant_prevu_batiment,
                       sum( detail.montant_prevu_lat) as montant_prevu_latrine,
                       sum(detail.montant_prevu_mob) as montant_prevu_mobilier,
                       sum(detail.montant_prevu_bat) + sum( detail.montant_prevu_lat) + sum(detail.montant_prevu_mob) as total_prevu
               from (
               
                (
                    select 
                        atta_bat.id_contrat_prestataire as id_contrat,
                         sum(atta_bat.montant_prevu) as montant_prevu_bat,
                         0 as montant_prevu_lat,
                         0 as montant_prevu_mob

                        from divers_attachement_batiment_prevu as atta_bat

                        where 
                        atta_bat.id_contrat_prestataire= '".$id_contrat_prestataire."'

                            group by id_contrat
                )
                UNION
                (
                    select 
                        atta_lat.id_contrat_prestataire as id_contrat,
                         0 as montant_prevu_bat,
                         sum(atta_lat.montant_prevu) as montant_prevu_lat,
                         0 as montant_prevu_mob

                        from divers_attachement_latrine_prevu as atta_lat

                        where 
                            atta_lat.id_contrat_prestataire= '".$id_contrat_prestataire."'

                            group by id_contrat
                )
                UNION
                (
                    select 
                        atta_mob.id_contrat_prestataire as id_contrat,
                         0 as montant_prevu_bat,
                         0 as montant_prevu_lat,
                         sum(atta_mob.montant_prevu) as montant_prevu_mob

                        from divers_attachement_mobilier_prevu as atta_mob

                        where 
                            atta_mob.id_contrat_prestataire= '".$id_contrat_prestataire."'

                            group by id_contrat
                ) 

                )detail

                group by id_contrat

            ";
            return $this->db->query($sql)->result();             
    }
        

}
