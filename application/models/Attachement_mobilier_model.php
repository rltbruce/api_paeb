<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attachement_mobilier_model extends CI_Model {
    protected $table = 'attachement_mobilier';

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
            'ponderation_mobilier'   =>      $attachement['ponderation_mobilier'],
            'id_type_mobilier'    => $attachement['id_type_mobilier']                       
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
    public function findBytype_mobilier($id_type_mobilier)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_type_mobilier',$id_type_mobilier)
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
    public function findBycontrat($id_contrat_prestataire)
    {               
        $result =  $this->db->select('attachement_mobilier.*')
                        ->from($this->table)
                        ->join('type_mobilier','type_mobilier.id= attachement_mobilier.id_type_mobilier')
                        ->join('mobilier_construction','mobilier_construction.id_type_mobilier= type_mobilier.id')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id= mobilier_construction.id_convention_entete')
                        ->join('contrat_prestataire','contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id')
                        ->where('contrat_prestataire.id',$id_contrat_prestataire)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }



}
