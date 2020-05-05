<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attachement_latrine_model extends CI_Model {
    protected $table = 'attachement_latrine';

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
            'ponderation_latrine'   =>      $attachement['ponderation_latrine'],
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

    public function findBycontrat($id_contrat_prestataire)
    {               
        $result =  $this->db->select('attachement_latrine.*')
                        ->from($this->table)
                        ->join('type_latrine','type_latrine.id= attachement_latrine.id_type_latrine')
                        ->join('latrine_construction','latrine_construction.id_type_latrine= type_latrine.id')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id= latrine_construction.id_convention_entete')
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
