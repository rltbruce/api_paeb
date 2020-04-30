<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transfert_reliquat_model extends CI_Model {
    protected $table = 'transfert_reliquat';

    public function add($transfert_reliquat) {
        $this->db->set($this->_set($transfert_reliquat))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $transfert_reliquat) {
        $this->db->set($this->_set($transfert_reliquat))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($transfert_reliquat) {
        return array(            
            'montant' => $transfert_reliquat['montant'],
            'date_transfert' => $transfert_reliquat['date_transfert'],
            'rib' => $transfert_reliquat['rib'],
            'intitule_compte' => $transfert_reliquat['intitule_compte'],
            'id_convention_entete' => $transfert_reliquat['id_convention_entete'],
            'objet_utilisation' => $transfert_reliquat['objet_utilisation'] ,
            'validation' => $transfert_reliquat['validation']                     
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
    
    public function findByIdObjet($id)
    {               
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
    public function findtransfertinvalideByCisco($id_cisco)
    {               
        $result =  $this->db->select('transfert_reliquat.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=transfert_reliquat.id_convention_entete')
                        ->join('cisco','convention_cisco_feffi_entete.id_cisco=cisco.id')
                        ->where("cisco.id", $id_cisco)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findtransfertByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    } 
    public function findtransfertvalideByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
                        ->where("validation", 1)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    } 
    public function findtransfertinvalideByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
                        ->where("validation", 0)
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
