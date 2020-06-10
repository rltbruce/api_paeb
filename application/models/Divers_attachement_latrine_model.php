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
            'id_type_latrine'    => $attachement['id_type_latrine']                       
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
                        ->order_by('description')
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
    public function findBytype_latrine($id_type_latrine)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_type_latrine',$id_type_latrine)
                        ->order_by('description')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
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
