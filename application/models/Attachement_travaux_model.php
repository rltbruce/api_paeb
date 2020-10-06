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
            'id_contrat_prestataire' => $attachement_travaux['id_contrat_prestataire'],
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
    public function getattachement_travauxneedvalidationdpfiBycontrat($id_contrat_prestataire)
    {

        $sql="select 
                        attachement_trav.*

                    from attachement_travaux as attachement_trav
            
                        inner join facture_mpe as fact on attachement_trav.id = fact.id_attachement_travaux 
            
                        where attachement_trav.id_contrat_prestataire = ".$id_contrat_prestataire." and fact.validation IN(1,2)
            
                        group by attachement_trav.id ";
        return $this->db->query($sql)->result();               
    }
    public function findetatattachement_travauxBycontrat($id_contrat_prestataire)
    {  

        $sql="select 
                        attachement_trav.id as id, 
                        attachement_trav.numero as numero, 
                        attachement_trav.date_debut as date_debut, 
                        attachement_trav.date_fin as date_fin, 
                        attachement_trav.total_prevu as total_prevu, 
                        attachement_trav.total_periode as total_periode, 
                        attachement_trav.total_anterieur as total_anterieur, 
                        attachement_trav.total_cumul as total_cumul, 
                        attachement_trav.id_contrat_prestataire as id_contrat_prestataire, 
                        attachement_trav.validation as validation,
                        fact.id as id_fact,
                        fact.validation as validation_fact 

                    from attachement_travaux as attachement_trav
            
                        inner join facture_mpe as fact on attachement_trav.id = fact.id_attachement_travaux 
            
                        where attachement_trav.id_contrat_prestataire = ".$id_contrat_prestataire." and fact.validation>0
            
                        group by attachement_trav.id ";
        return $this->db->query($sql)->result();               
    }
    public function findattachement_travauxBycontrat($id_contrat_prestataire) {               
       /* $result =  $this->db->select('attachement_travaux.*,')
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
        } */ 

        $sql="select 
                        attachement_trav.id as id, 
                        attachement_trav.numero as numero, 
                        attachement_trav.date_debut as date_debut, 
                        attachement_trav.date_fin as date_fin, 
                        attachement_trav.total_prevu as total_prevu, 
                        attachement_trav.total_periode as total_periode, 
                        attachement_trav.total_anterieur as total_anterieur, 
                        attachement_trav.total_cumul as total_cumul, 
                        attachement_trav.id_contrat_prestataire as id_contrat_prestataire, 
                        attachement_trav.validation as validation,
                        fact.id as id_fact,
                        fact.validation as validation_fact 

                    from attachement_travaux as attachement_trav
            
                        left join facture_mpe as fact on attachement_trav.id = fact.id_attachement_travaux 
            
                        where attachement_trav.id_contrat_prestataire = ".$id_contrat_prestataire."
            
                        group by attachement_trav.id ";
        return $this->db->query($sql)->result();               
    }

    public function findattachement_travauxinvalideBycontrat($id_contrat_prestataire)
    { 

        $sql="select 
                        attachement_trav.id as id, 
                        attachement_trav.numero as numero, 
                        attachement_trav.date_debut as date_debut, 
                        attachement_trav.date_fin as date_fin, 
                        attachement_trav.total_prevu as total_prevu, 
                        attachement_trav.total_periode as total_periode, 
                        attachement_trav.total_anterieur as total_anterieur, 
                        attachement_trav.total_cumul as total_cumul, 
                        attachement_trav.id_contrat_prestataire as id_contrat_prestataire, 
                        attachement_trav.validation as validation,
                        fact.id as id_fact,
                        fact.validation as validation_fact 

                    from attachement_travaux as attachement_trav
            
                        left join facture_mpe as fact on attachement_trav.id = fact.id_attachement_travaux 
            
                        where attachement_trav.id_contrat_prestataire = ".$id_contrat_prestataire."
            ";
        return $this->db->query($sql)->result();               
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

    public function getavance_a_inserer($id_attachement_travaux)
    {               
        $this->db->select("attachement_travaux.id as id_attachement_travaux,attachement_travaux.id_contrat_prestataire as id_contrat_prestataire");
        
        $this->db ->select("(
            select sum(atta_bat_tra.quantite_cumul) from divers_attachement_batiment_travaux as atta_bat_tra
            
            inner join demande_batiment_presta as demande_bat_mpe on demande_bat_mpe.id= atta_bat_tra.id_demande_batiment_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_bat_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as sum_quantite_cumul_bat",FALSE);
        
        $this->db ->select("(
            select sum(atta_lat_tra.quantite_cumul) from divers_attachement_latrine_travaux as atta_lat_tra
            
            inner join demande_latrine_presta as demande_lat_mpe on demande_lat_mpe.id= atta_lat_tra.id_demande_latrine_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_lat_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as sum_quantite_cumul_lat",FALSE);

        $this->db ->select("(
            select sum(atta_mob_tra.quantite_cumul) from divers_attachement_mobilier_travaux as atta_mob_tra
            
            inner join demande_mobilier_presta as demande_mob_mpe on demande_mob_mpe.id= atta_mob_tra.id_demande_mobilier_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_mob_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as sum_quantite_cumul_mob",FALSE);
        
        $this->db ->select("(
            select sum(atta_bat_prevu.quantite_prevu) from divers_attachement_batiment_prevu as atta_bat_prevu
            
            where 
                atta_bat_prevu.id_contrat_prestataire= id_contrat_prestataire) as sum_quantite_prevu_bat",FALSE);

        $this->db ->select("(
            select sum(atta_lat_prevu.quantite_prevu) from divers_attachement_latrine_prevu as atta_lat_prevu
            
            where 
                atta_lat_prevu.id_contrat_prestataire= id_contrat_prestataire) as sum_quantite_prevu_lat",FALSE);

        $this->db ->select("(
            select sum(atta_mob_prevu.quantite_prevu) from divers_attachement_mobilier_prevu as atta_mob_prevu
            
            where 
                atta_mob_prevu.id_contrat_prestataire= id_contrat_prestataire) as sum_quantite_prevu_mob",FALSE);

        $this->db ->select("(
            select max(atta_bat_prevu.id_attachement_batiment_detail)
                
                from divers_attachement_batiment_prevu as atta_bat_prevu
                
                inner join divers_attachement_batiment_travaux as atta_bat_trav on atta_bat_trav.id_attachement_batiment_prevu= atta_bat_prevu.id
                
                inner join demande_batiment_presta as demande_bat_mpe on demande_bat_mpe.id=atta_bat_trav.id_demande_batiment_mpe
                        where 
                         demande_bat_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_bat_detail",FALSE);

        $this->db ->select("(
            select max(atta_lat_prevu.id_attachement_latrine_detail)
                
                from divers_attachement_latrine_prevu as atta_lat_prevu
                
                inner join divers_attachement_latrine_travaux as atta_lat_trav on atta_lat_trav.id_attachement_latrine_prevu= atta_lat_prevu.id
                
                inner join demande_latrine_presta as demande_lat_mpe on demande_lat_mpe.id=atta_lat_trav.id_demande_latrine_mpe
                        where 
                         demande_lat_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_lat_detail",FALSE);

        $this->db ->select("(
            select max(atta_mob_prevu.id_attachement_mobilier_detail)
                
                from divers_attachement_mobilier_prevu as atta_mob_prevu
                
                inner join divers_attachement_mobilier_travaux as atta_mob_trav on atta_mob_trav.id_attachement_mobilier_prevu= atta_mob_prevu.id
                
                inner join demande_mobilier_presta as demande_mob_mpe on demande_mob_mpe.id=atta_mob_trav.id_demande_mobilier_mpe
                        where 
                         demande_mob_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_mob_detail",FALSE);
        
        $this->db ->select("(
            select attachement_travaux.date_fin
                
                from attachement_travaux
                where 
                         attachement_travaux.id= id_attachement_travaux ) as date",FALSE);

        $result =  $this->db->from('attachement_travaux')
                    
                    ->where('attachement_travaux.id',$id_attachement_travaux)
                    ->group_by('id_attachement_travaux')
                                       
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

   /* public function getavance_a_inserer($id_attachement_travaux)
    {               
        $this->db->select("attachement_travaux.id as id_attachement_travaux,attachement_travaux.id_contrat_prestataire as id_contrat_prestataire");
        
        $this->db ->select("(
            select sum(atta_bat_tra.pourcentage) from divers_attachement_batiment_travaux as atta_bat_tra
            
            inner join demande_batiment_presta as demande_bat_mpe on demande_bat_mpe.id= atta_bat_tra.id_demande_batiment_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_bat_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as pourcentage_bat",FALSE);
        
        $this->db ->select("(
            select sum(atta_lat_tra.pourcentage) from divers_attachement_latrine_travaux as atta_lat_tra
            
            inner join demande_latrine_presta as demande_lat_mpe on demande_lat_mpe.id= atta_lat_tra.id_demande_latrine_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_lat_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as pourcentage_lat",FALSE);

        $this->db ->select("(
            select sum(atta_mob_tra.pourcentage) from divers_attachement_mobilier_travaux as atta_mob_tra
            
            inner join demande_mobilier_presta as demande_mob_mpe on demande_mob_mpe.id= atta_mob_tra.id_demande_mobilier_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_mob_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as pourcentage_mob",FALSE);

         $this->db ->select("(
            select count(atta_bat_prevu.id) from divers_attachement_batiment_prevu as atta_bat_prevu                    
            
            where 
                    atta_bat_prevu.id_contrat_prestataire = (select atta_trava.id_contrat_prestataire from attachement_travaux as atta_trava where atta_trava.id= '".$id_attachement_travaux."') ) as nbr_attache_bat_prevu ",FALSE);


         $this->db ->select("(
            select count(atta_lat_prevu.id) from divers_attachement_latrine_prevu as atta_lat_prevu                    
            
            where 
                    atta_lat_prevu.id_contrat_prestataire = (select atta_trava.id_contrat_prestataire from attachement_travaux as atta_trava where atta_trava.id= '".$id_attachement_travaux."') ) as nbr_attache_lat_prevu ",FALSE);

         $this->db ->select("(
            select count(atta_mob_prevu.id) from divers_attachement_mobilier_prevu as atta_mob_prevu                    
            
            where 
                    atta_mob_prevu.id_contrat_prestataire = (select atta_trava.id_contrat_prestataire from attachement_travaux as atta_trava where atta_trava.id= '".$id_attachement_travaux."') ) as nbr_attache_mob_prevu ",FALSE);

        $this->db ->select("(
            select max(atta_bat_prevu.id_attachement_batiment_detail)
                
                from divers_attachement_batiment_prevu as atta_bat_prevu
                
                inner join divers_attachement_batiment_travaux as atta_bat_trav on atta_bat_trav.id_attachement_batiment_prevu= atta_bat_prevu.id
                
                inner join demande_batiment_presta as demande_bat_mpe on demande_bat_mpe.id=atta_bat_trav.id_demande_batiment_mpe
                        where 
                         demande_bat_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_bat_detail",FALSE);

        $this->db ->select("(
            select max(atta_lat_prevu.id_attachement_latrine_detail)
                
                from divers_attachement_latrine_prevu as atta_lat_prevu
                
                inner join divers_attachement_latrine_travaux as atta_lat_trav on atta_lat_trav.id_attachement_latrine_prevu= atta_lat_prevu.id
                
                inner join demande_latrine_presta as demande_lat_mpe on demande_lat_mpe.id=atta_lat_trav.id_demande_latrine_mpe
                        where 
                         demande_lat_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_lat_detail",FALSE);

        $this->db ->select("(
            select max(atta_mob_prevu.id_attachement_mobilier_detail)
                
                from divers_attachement_mobilier_prevu as atta_mob_prevu
                
                inner join divers_attachement_mobilier_travaux as atta_mob_trav on atta_mob_trav.id_attachement_mobilier_prevu= atta_mob_prevu.id
                
                inner join demande_mobilier_presta as demande_mob_mpe on demande_mob_mpe.id=atta_mob_trav.id_demande_mobilier_mpe
                        where 
                         demande_mob_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_mob_detail",FALSE);
        
        $this->db ->select("(
            select attachement_travaux.date_fin
                
                from attachement_travaux
                where 
                         attachement_travaux.id= id_attachement_travaux ) as date",FALSE);

        $result =  $this->db->from('attachement_travaux')
                    
                    ->where('attachement_travaux.id',$id_attachement_travaux)
                    ->group_by('id_attachement_travaux')
                                       
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
    
    }*/

        

}
