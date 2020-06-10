<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convention_ufp_daaf_entete_model extends CI_Model {
    protected $table = 'convention_ufp_daaf_entete';

    public function add($convention_ufp_daaf_entete) {
        $this->db->set($this->_set($convention_ufp_daaf_entete))
                            ->set('date_creation', 'NOW()', false)
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $convention_ufp_daaf_entete) {
        $this->db->set($this->_set($convention_ufp_daaf_entete))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($convention_ufp_daaf_entete) {
        return array(
            'ref_convention' => $convention_ufp_daaf_entete['ref_convention'],
            'objet' =>    $convention_ufp_daaf_entete['objet'],
            'ref_financement'    => $convention_ufp_daaf_entete['ref_financement'],
            'montant_convention' => $convention_ufp_daaf_entete['montant_convention'],
            'montant_trans_comm' => $convention_ufp_daaf_entete['montant_trans_comm'],
            'frais_bancaire' => $convention_ufp_daaf_entete['frais_bancaire'],
            'num_vague' => $convention_ufp_daaf_entete['num_vague'],
            'nbr_beneficiaire' => $convention_ufp_daaf_entete['nbr_beneficiaire'],
            'validation' => $convention_ufp_daaf_entete['validation']                      
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
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findconventionByfiltre($requete)
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('convention_ufp_daaf_detail','convention_ufp_daaf_detail.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where($requete)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findconvention_invalideByfiltre($requete)
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('convention_ufp_daaf_detail','convention_ufp_daaf_detail.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where('validation',0)
                        ->where($requete)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findconventionBydemandevalidedaaf()
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('demande_deblocage_daaf','demande_deblocage_daaf.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where('demande_deblocage_daaf.validation',1)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findConventionByinvalidedemande()
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('demande_deblocage_daaf','demande_deblocage_daaf.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where('demande_deblocage_daaf.validation',0)
                        //->where("DATE_FORMAT(convention_ufp_daaf_detail.date_signature,'%Y')",$annee)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findConvention_now($annee)
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('convention_ufp_daaf_detail','convention_ufp_daaf_detail.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where("DATE_FORMAT(convention_ufp_daaf_detail.date_signature,'%Y')",$annee)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findConvention_invalide_now($annee)
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('convention_ufp_daaf_detail','convention_ufp_daaf_detail.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where('validation',0)
                        ->where("DATE_FORMAT(convention_ufp_daaf_detail.date_signature,'%Y')",$annee)
                        ->order_by('ref_convention')
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
    public function findByIdObjet($id) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findconventionmaxBydate($date_today)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id=(select max(id) from convention_ufp_daaf_entete)")
                        ->where("date_creation",$date_today)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function avancement_convention()
    {               
        $sql="
        select 
                       niveau1.id_conv_ufp as id_conv_ufp,
                       sum(niveau1.avancement_batiment) as avancement_batiment,
                       sum(niveau1.avancement_latrine) as avancement_latrine,
                       sum(niveau1.avancement_mobilier) as avancement_mobilier,
                       count(niveau1.id_conv) as nbr_conv

            from(

                    select 
                       detail.id_conv_ufp as id_conv_ufp,
                       detail.id_conv as id_conv,
                        CASE  WHEN 
                                sum(detail.nbr_batiment) =0 THEN 0
                             ELSE 
                            (sum(detail.avancement_bat)/sum(detail.nbr_batiment))
                        END as avancement_batiment,

                        CASE  WHEN 
                                sum(detail.nbr_latrine) =0 THEN 0
                             ELSE 
                            (sum(detail.avancement_lat)/sum(detail.nbr_latrine))
                        END as avancement_latrine,

                        CASE  WHEN 
                                sum(detail.nbr_mobilier) =0 THEN 0
                             ELSE 
                            (sum(detail.avancement_mob)/sum(detail.nbr_mobilier))
                        END as avancement_mobilier
               from (

               (
                select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        bat_const.id as id_bat_const,
                        count(bat_const.id) as nbr_batiment,
                        0 as avancement_bat,
                        0 as avancement_lat,
                        0 as nbr_latrine,
                        0 as avancement_mob,
                        0 as nbr_mobilier


                        from batiment_construction as bat_const
                            inner join convention_cisco_feffi_entete as conv on conv.id = bat_const.id_convention_entete 
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     

                            group by conv_ufp.id,conv.id, bat_const.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        bat_const.id as id_bat_const,
                        0 as nbr_batiment,
                         max(atta_bat.ponderation_batiment) as avancement_bat,
                         0 as avancement_lat,
                         0 as nbr_latrine,
                         0 as avancement_mob,
                         0 as nbr_mobilier

                        from attachement_batiment as atta_bat

                            inner join avancement_batiment as avanc on avanc.id_attachement_batiment = atta_bat.id
                            inner join batiment_construction as bat_const on bat_const.id=avanc.id_batiment_construction
                            inner join convention_cisco_feffi_entete as conv on conv.id = bat_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     

                            group by conv_ufp.id,conv.id, bat_const.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        bat_const.id as id_bat_const,
                        0 as nbr_batiment,
                        0 as avancement_bat,
                        max(atta_lat.ponderation_latrine) as avancement_lat,
                        0 as nbr_latrine,
                        0 as avancement_mob,
                        0 as nbr_mobilier

                        from attachement_latrine as atta_lat

                            inner join avancement_latrine as avanc_lat on avanc_lat.id_attachement_latrine = atta_lat.id
                            inner join latrine_construction as lat_const on lat_const.id=avanc_lat.id_latrine_construction
                            inner join batiment_construction as bat_const on bat_const.id=lat_const.id_batiment_construction
                            inner join convention_cisco_feffi_entete as conv on conv.id = bat_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf

                            group by conv_ufp.id,conv.id, bat_const.id,lat_const.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        bat_const.id as id_bat_const,
                        0 as nbr_batiment,
                        0 as avancement_bat,
                        0 as avancement_lat,
                        count(lat_const.id) as nbr_latrine,
                        0 as avancement_mob,
                        0 as nbr_mobilier

                        from latrine_construction as lat_const
                            inner join batiment_construction as bat_const on bat_const.id=lat_const.id_batiment_construction
                            inner join convention_cisco_feffi_entete as conv on conv.id = bat_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf 
                       
                            group by conv_ufp.id, conv.id, bat_const.id
                )
                UNION
                (
                    select
                        conv_ufp.id as id_conv_ufp, 
                        conv.id as id_conv,
                        bat_const.id as id_bat_const,
                        0 as nbr_batiment,
                        0 as avancement_bat,
                        0 as avancement_lat,
                        0 as nbr_latrine,
                        max(atta_mob.ponderation_mobilier) as avancement_mob,
                        0 as nbr_mobilier

                        from attachement_mobilier as atta_mob

                            inner join avancement_mobilier as avanc_mob on avanc_mob.id_attachement_mobilier = atta_mob.id
                            inner join mobilier_construction as mob_const on mob_const.id=avanc_mob.id_mobilier_construction
                            inner join batiment_construction as bat_const on bat_const.id=mob_const.id_batiment_construction
                            inner join convention_cisco_feffi_entete as conv on conv.id = bat_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf 

                            group by conv_ufp.id, conv.id, bat_const.id,mob_const.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        bat_const.id as id_bat_const,
                        0 as nbr_batiment,
                        0 as avancement_bat,
                        0 as avancement_lat,
                        0 as nbr_latrine,
                        0 as avancement_mob,
                        count(mob_const.id) as nbr_mobilier

                        from mobilier_construction as mob_const
                            inner join batiment_construction as bat_const on bat_const.id=mob_const.id_batiment_construction
                            inner join convention_cisco_feffi_entete as conv on conv.id = bat_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf 

                            group by conv_ufp.id, conv.id, bat_const.id
                ) 

                )detail

                group by detail.id_conv_ufp,detail.id_conv) niveau1

                group by niveau1.id_conv_ufp
            ";
            return $this->db->query($sql)->result();             
    }

   /* public function avancement_convention()
    {               
        $sql="
        select 
                       niveau1.id_conv_ufp as id_conv_ufp,
                       sum(niveau1.avancement_batiment) as avancement_batiment,
                       sum(niveau1.avancement_latrine) as avancement_latrine,
                       sum(niveau1.avancement_mobilier) as avancement_mobilier,
                       count(niveau1.id_conv) as nbr_conv

            from(

                    select 
                       detail.id_conv_ufp as id_conv_ufp,
                       detail.id_conv as id_conv,
                       sum(detail.avancement_bat) as avancement_batiment,
                        sum(detail.avancement_lat) as avancement_latrine,
                        sum(detail.avancement_mob) as avancement_mobilier
               from (

               (
                    select
                        conv_ufp.id as id_conv_ufp ,
                        conv.id as id_conv,
                         max(atta_bat.ponderation_batiment) as avancement_bat,
                         0 as avancement_lat,
                         0 as avancement_mob

                        from attachement_batiment as atta_bat

                            inner join avancement_batiment as avanc on avanc.id_attachement_batiment = atta_bat.id
                            inner join contrat_prestataire as cont_prest on cont_prest.id=avanc.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_prest.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     

                            group by conv_ufp.id,conv.id
                )
                UNION
                (
                    select
                        conv_ufp.id as id_conv_ufp, 
                        conv.id as id_conv,
                        0 as avancement_bat,
                        max(atta_lat.ponderation_latrine) as avancement_lat,
                        0 as avancement_mob

                        from attachement_latrine as atta_lat

                            inner join avancement_latrine as avanc_lat on avanc_lat.id_attachement_latrine = atta_lat.id
                            inner join contrat_prestataire as cont_prest on cont_prest.id=avanc_lat.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_prest.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     

                            group by conv_ufp.id,conv.id
                )
                UNION
                (
                    select
                        conv_ufp.id as id_conv_ufp, 
                        conv.id as id_conv,
                        0 as avancement_bat,
                        0 as avancement_lat,
                        max(atta_mob.ponderation_mobilier) as avancement_mob

                        from attachement_mobilier as atta_mob

                            inner join avancement_mobilier as avanc_mob on avanc_mob.id_attachement_mobilier = atta_mob.id
                            inner join contrat_prestataire as cont_prest on cont_prest.id=avanc_mob.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_prest.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     

                            group by conv_ufp.id,conv.id
                ) 

                )detail

                group by detail.id_conv_ufp,detail.id_conv) niveau1

                group by niveau1.id_conv_ufp
            ";
            return $this->db->query($sql)->result();             
    }*/
    public function findDetailcoutByConvention($id_convention_ufp_daaf_entete)
    {               
        $sql="
        select 
                       niveau1.id_conv_ufp as id_conv_ufp,
                        sum(niveau1.cout_batiment) as cout_batiment,
                        sum(niveau1.cout_latrine) as cout_latrine,
                        sum(niveau1.cout_mobilier) as cout_mobilier,
                        sum(niveau1.cout_divers) as cout_divers

            from(

                    select 
                        detail.id_conv_ufp as id_conv_ufp,
                        detail.id_conv as id_conv,
                        sum(detail.cout_batiment) as cout_batiment,
                        sum(detail.cout_latrine) as cout_latrine,
                        sum(detail.cout_mobilier) as cout_mobilier,
                        (sum(detail.cout_maitrise)+sum(detail.cout_sous)) as cout_divers
               from (

               (
                select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        sum(bat_const.cout_unitaire) as cout_batiment,
                        0 as cout_latrine,
                        0 as cout_mobilier,
                        0 as cout_maitrise,
                        0 as cout_sous

                        from batiment_construction as bat_const
                            inner join convention_cisco_feffi_entete as conv on conv.id = bat_const.id_convention_entete 
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."'
                            group by conv_ufp.id,conv.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        0 as cout_batiment,
                        sum(lat_const.cout_unitaire) as cout_latrine,
                        0 as cout_mobilier,
                        0 as cout_maitrise,
                        0 as cout_sous

                        from latrine_construction as lat_const
                            inner join convention_cisco_feffi_entete as conv on conv.id = lat_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id, conv.id
                )
                UNION
                (
                    select
                        conv_ufp.id as id_conv_ufp, 
                        conv.id as id_conv,
                        0 as cout_batiment,
                        0 as cout_latrine,
                        sum(mob_const.cout_unitaire) as cout_mobilier,
                        0 as cout_maitrise,
                        0 as cout_sous

                        from mobilier_construction as mob_const
                            inner join convention_cisco_feffi_entete as conv on conv.id = mob_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                      
                            where conv_ufp.id = '".$id_convention_ufp_daaf_entete."'

                            group by conv_ufp.id, conv.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        0 as cout_batiment,
                        0 as cout_latrine,
                        0 as cout_mobilier,
                        sum(cout_di_const.cout) as cout_maitrise,
                        0 as cout_sous

                        from cout_maitrise_construction as cout_di_const
                            inner join convention_cisco_feffi_entete as conv on conv.id = cout_di_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf 

                            where conv_ufp.id = '".$id_convention_ufp_daaf_entete."'
                            group by conv_ufp.id, conv.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        0 as cout_batiment,
                        0 as cout_latrine,
                        0 as cout_mobilier,
                        0 as cout_divers,
                        sum(cout_sou_const.cout) as cout_sous

                        from cout_sousprojet_construction as cout_sou_const
                            inner join convention_cisco_feffi_entete as conv on conv.id = cout_sou_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf 

                            where conv_ufp.id = '".$id_convention_ufp_daaf_entete."'
                            group by conv_ufp.id, conv.id
                ) 

                )detail

                group by detail.id_conv_ufp,detail.id_conv) niveau1

                group by niveau1.id_conv_ufp
            ";
            return $this->db->query($sql)->result();             
    }

    public function findindicateurByconvention($id_convention_ufp_daaf_entete)
    {               
        $sql="
               select 
                        detail.id_conv_ufp as id_conv_ufp,
                        sum(detail.nbr_beneficiaire_prevu) as nbr_beneficiaire_prevu,
                        sum(detail.nbr_beneficiaire) as nbr_beneficiaire,
                        sum(detail.nbr_ecole_construite) as nbr_ecole_construite,
                        sum(nbr_salle_prevu) as nbr_salle_prevu,
                        sum(nbr_box_latrine_prevu) as nbr_box_latrine_prevu,
                        sum(nbr_point_eau_prevu) as nbr_point_eau_prevu,
                        sum(nbr_table_banc_prevu) as nbr_table_banc_prevu,
                        sum(nbr_table_maitre_prevu) as nbr_table_maitre_prevu,
                        sum(nbr_chaise_maitre_prevu) as nbr_chaise_maitre_prevu,
                        sum(nbr_salle_construite) as nbr_salle_construite,
                        sum(nbr_box_latrine_construite) as nbr_box_latrine_construite,
                        sum(nbr_point_eau_construite) as nbr_point_eau_construite,
                        sum(nbr_table_banc_construite) as nbr_table_banc_construite,
                        sum(nbr_table_maitre_construite) as nbr_table_maitre_construite,
                        sum(nbr_chaise_maitre_construite) as nbr_chaise_maitre_construite
               from (

               (
                select 
                        conv_ufp.id as id_conv_ufp,
                        sum(conv_ufp.nbr_beneficiaire) as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp                    
                        where conv_ufp.id = '".$id_convention_ufp_daaf_entete."'
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        count(conv.id) as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id                     
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                ) 
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        count(conv.id) as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join avancement_batiment as avance_bat on avance_bat.id_batiment_construction = bat_const.id
                            inner join attachement_batiment as atta_bat on atta_bat.id = avance_bat.id_attachement_batiment
                            
                            inner join latrine_construction as lat_const on lat_const.id_batiment_construction = bat_const.id
                            inner join avancement_latrine as avance_lat on avance_lat.id_latrine_construction = lat_const.id
                            inner join attachement_latrine as atta_lat on atta_lat.id = avance_lat.id_attachement_latrine

                            inner join mobilier_construction as mob_const on mob_const.id_batiment_construction = bat_const.id
                            inner join avancement_mobilier as avance_mob on avance_mob.id_mobilier_construction = mob_const.id
                            inner join attachement_mobilier as atta_mob on atta_mob.id = avance_mob.id_attachement_mobilier                   
                             
                             where atta_bat.ponderation_batiment=100 
                                    and atta_lat.ponderation_latrine=100
                                    and atta_mob.ponderation_mobilier=100 
                                    and conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        sum(type_bat.nbr_salle) as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join type_batiment as type_bat on type_bat.id = bat_const.id_type_batiment                  
                             
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        sum(type_lat.nbr_box_latrine) as nbr_box_latrine_prevu,
                        sum(type_lat.nbr_point_eau) as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join latrine_construction as lat_const on lat_const.id_batiment_construction = bat_const.id 
                            inner join type_latrine as type_lat on type_lat.id = lat_const.id_type_latrine                  
                             
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        sum(type_mob.nbr_table_banc) as nbr_table_banc_prevu,
                        sum(type_mob.nbr_table_maitre) as nbr_table_maitre_prevu,
                        sum(type_mob.nbr_chaise_maitre) as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join mobilier_construction as mob_const on mob_const.id_batiment_construction = bat_const.id 
                            inner join type_mobilier as type_mob on type_mob.id = mob_const.id_type_mobilier                  
                             
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        sum(type_bat.nbr_salle) as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join type_batiment as type_bat on type_bat.id = bat_const.id_type_batiment
                            inner join avancement_batiment as avance_bat on avance_bat.id_batiment_construction = bat_const.id
                            inner join attachement_batiment as atta_bat on atta_bat.id = avance_bat.id_attachement_batiment                  
                             
                             where atta_bat.ponderation_batiment=100 
                                    and conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        sum(type_lat.nbr_box_latrine) as nbr_box_latrine_construite,
                        sum(type_lat.nbr_point_eau) as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join latrine_construction as lat_const on lat_const.id_batiment_construction = bat_const.id 
                            inner join type_latrine as type_lat on type_lat.id = lat_const.id_type_latrine
                            inner join avancement_latrine as avance_lat on avance_lat.id_latrine_construction = lat_const.id
                            inner join attachement_latrine as atta_lat on atta_lat.id = avance_lat.id_attachement_latrine                  
                             
                             where atta_lat.ponderation_latrine=100
                                    and conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,                        
                        sum(type_mob.nbr_table_banc) as nbr_table_banc_construite,
                        sum(type_mob.nbr_table_maitre) as nbr_table_maitre_construite,
                        sum(type_mob.nbr_chaise_maitre) as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join mobilier_construction as mob_const on mob_const.id_batiment_construction = bat_const.id 
                            inner join type_mobilier as type_mob on type_mob.id = mob_const.id_type_mobilier
                            inner join avancement_mobilier as avance_mob on avance_mob.id_mobilier_construction = mob_const.id
                            inner join attachement_mobilier as atta_mob on atta_mob.id = avance_mob.id_attachement_mobilier                  
                             
                             where atta_mob.ponderation_mobilier=100 
                                    and conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )

                )detail

                group by detail.id_conv_ufp
            ";
            return $this->db->query($sql)->result();             
    } 
    public function findByRef_convention($nom) {
        $requete="select * from site where lower(code_sous_projet)='".$nom."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }

}
