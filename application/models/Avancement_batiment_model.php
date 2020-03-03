<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avancement_batiment_model extends CI_Model {
    protected $table = 'avancement_batiment';

    public function add($avancement_batiment) {
        $this->db->set($this->_set($avancement_batiment))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avancement_batiment) {
        $this->db->set($this->_set($avancement_batiment))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avancement_batiment) {
        return array(

            'description' => $avancement_batiment['description'],
            'intitule'   => $avancement_batiment['intitule'],
            'observation'    => $avancement_batiment['observation'],
            'date'   => $avancement_batiment['date'],
            'id_attachement_batiment' => $avancement_batiment['id_attachement_batiment'],
            'id_batiment_construction' => $avancement_batiment['id_batiment_construction']                      
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

    public function findAllByBatiment_construction($id_batiment_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_batiment_construction", $id_batiment_construction)
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

        public function getavancementByconvention($id_convention_entete)
    {               
        $sql=" select 
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

                        where                             
                            conv.id= '".$id_convention_entete."'

                            group by conv.id, bat_const.id
                )
                UNION
                (
                    select 
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

                        where 
                            conv.id= '".$id_convention_entete."'

                            group by conv.id, bat_const.id
                )
                UNION
                (
                    select 
                        conv.id as id_conv,
                        bat_const.id as id_bat_const,
                        0 as nbr_batiment,
                        0 as avancement_bat,
                        sum(atta_lat.ponderation_latrine) as avancement_lat,
                        0 as nbr_latrine,
                        0 as avancement_mob,
                        0 as nbr_mobilier

                        from attachement_latrine as atta_lat

                            inner join avancement_latrine as avanc_lat on avanc_lat.id_attachement_latrine = atta_lat.id
                            inner join latrine_construction as lat_const on lat_const.id=avanc_lat.id_latrine_construction
                            inner join batiment_construction as bat_const on bat_const.id=lat_const.id_batiment_construction
                            inner join convention_cisco_feffi_entete as conv on conv.id = bat_const.id_convention_entete

                        where 
                            conv.id= '".$id_convention_entete."'

                            group by conv.id, bat_const.id,lat_const.id
                )
                UNION
                (
                    select 
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

                        where 
                            conv.id= '".$id_convention_entete."'

                            group by conv.id, bat_const.id
                )
                UNION
                (
                    select 
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

                        where 
                            conv.id= '".$id_convention_entete."'

                            group by conv.id, bat_const.id,mob_const.id
                )
                UNION
                (
                    select 
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

                        where 
                            conv.id= '".$id_convention_entete."'

                            group by conv.id, bat_const.id
                ) 

                )detail

                group by id_conv

            ";
            return $this->db->query($sql)->result();             
    }
   /*     public function getavancementByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('max(attachement_batiment.ponderation_batiment) as avancement')
                        ->from('attachement_batiment')
                        ->join('avancement_batiment','avancement_batiment.id_attachement_batiment=attachement_batiment.id')
                        ->join('batiment_construction','batiment_construction.id=avancement_batiment.id_batiment_construction')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                        ->where('convention_cisco_feffi_entete.id',$id_convention_entete)
                        ->group_by('batiment_construction.id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/

}
