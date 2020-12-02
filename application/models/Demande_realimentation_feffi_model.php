<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_realimentation_feffi_model extends CI_Model {
    protected $table = 'demande_realimentation_feffi';

    public function add($demande_realimentation_feffi) {
        $this->db->set($this->_set($demande_realimentation_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_realimentation_feffi) {
        $this->db->set($this->_set($demande_realimentation_feffi))
                            ->set('date_approbation', 'NOW()', false)
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($demande_realimentation_feffi) {
        return array(
            'id_tranche_deblocage_feffi' => $demande_realimentation_feffi['id_tranche_deblocage_feffi'],
            'prevu' => $demande_realimentation_feffi['prevu'],
            'anterieur' => $demande_realimentation_feffi['anterieur'],
            'cumul' => $demande_realimentation_feffi['cumul'],
            'reste' => $demande_realimentation_feffi['reste'],
            //'date_approbation' => $demande_realimentation_feffi['date_approbation'],
            'date' => $demande_realimentation_feffi['date'],
            'validation' => $demande_realimentation_feffi['validation'],
            'id_convention_cife_entete'=> $demande_realimentation_feffi['id_convention_cife_entete'],
            'id_compte_feffi'=> $demande_realimentation_feffi['id_compte_feffi']                       
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

    public function finddemandevalidedaafByIdconvention_cife_entete($id_convention_cife_entete) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_cife_entete", $id_convention_cife_entete)                        
                        ->where("validation",7)
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
    public function finddemandeemidaafByIdconvention_cife_entete($id_convention_cife_entete) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_cife_entete", $id_convention_cife_entete)                        
                        ->where("validation IN(4,5,7)")
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
    public function finddemandeemiufpByIdconvention_cife_entete($id_convention_cife_entete) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_cife_entete", $id_convention_cife_entete)                        
                        ->where("validation IN(1,3)")
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
    public function finddemandeemidpfiByIdconvention_cife_entete($id_convention_cife_entete) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_cife_entete", $id_convention_cife_entete)                        
                        ->where("validation IN(1,2,7)")
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
   public function findallByIdconvention_cife_entete($id_convention_cife_entete) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_cife_entete", $id_convention_cife_entete)
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
    public function findcreerByIdconvention_cife_entete($id_convention_cife_entete) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_cife_entete", $id_convention_cife_entete)                        
                        ->where("validation", 0)
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
    public function findcreer2ByIdconvention_cife_entete($id_convention_cife_entete) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_cife_entete", $id_convention_cife_entete)                        
                        ->where("validation", 4)
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
    public function getdemande_realimentationvalideById($id_demande_realimentation) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_demande_realimentation)                        
                        ->where("validation !=", 0)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getdemande_realimentationvalide2ById($id_demande_realimentation) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_demande_realimentation)                        
                        ->where("validation !=", 4)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function countdemandeByconvention($id_convention_cife_entete,$validation) {           //mande    
        $result =  $this->db->select('count(demande_realimentation_feffi.id) as nbr_demande_feffi')
                        ->from($this->table)
                        ->where("id_convention_cife_entete", $id_convention_cife_entete)                        
                        ->where("validation", $validation)
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

    public function finddemandedisponibleByconvention($id_convention_cife_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_cife_entete", $id_convention_cife_entete)
                        ->where("validation >", 0)
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

    
    public function countAllByvalidation($invalide)
    {
        $result = $this->db->select('COUNT(*) as nombre')
                        ->from($this->table)
                        ->where("validation", $invalide)
                        ->order_by('id', 'desc')
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
