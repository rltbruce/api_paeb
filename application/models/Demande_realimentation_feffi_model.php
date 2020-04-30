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
            'date_approbation' => $demande_realimentation_feffi['date_approbation'],
            'date' => $demande_realimentation_feffi['date'],
            'validation' => $demande_realimentation_feffi['validation'],
            'id_convention_cife_entete'=> $demande_realimentation_feffi['id_convention_cife_entete']                       
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

   /* public function findByIdconvention_cife_entete($id_convention_cife_entete)
    { 
        $result = $this->db->query(' 
            select  dem_real_fef.id as id,
                    dem_real_fef.id_convention_cife_entete as id_convention_cife_entete, 
                    dem_real_fef.date as date, 
                    dem_real_fef.date_approbation as date_approbation, 
                    dem_real_fef.validation as validation,
                    tranche.libelle as libelle,
                    tranche.pourcentage as pourcentage,
                    tranche.periode as periode,
                    tranche.description as description,
                    convention_detail.montant_total as montant

            
            from demande_realimentation_feffi as dem_real_fef

                    join tranche_deblocage_feffi as tranche on tranche.id=dem_real_fef.id_tranche_deblocage
                    join convention_cisco_feffi_entete as convention_entete on convention_entete.id=dem_real_fef.id_convention_cife_entete
                    join convention_cisco_feffi_detail as convention_detail on convention_detail.id_convention_entete=convention_entete.id
                group by dem_real_fef.id')
                    ->result();                              

        if($result)
        {
            return $result;
        }else{
            return null;
        }
                    
    }*/
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

  /*  public function finddemandedisponibleByconvention($id_convention_cife_entete) {               
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

    public function findByIdInvalide($validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",$validation )
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

    public function findByIdValide($validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where_not_in("validation", $validation)
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
    
    public function finddemande_invalideBycisco($id_cisco)
    {               
        $result =  $this->db->select('demande_realimentation_feffi.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=demande_realimentation_feffi.id_convention_cife_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id",$id_cisco )
                        ->where("demande_realimentation_feffi.validation",0 )
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/

   /* public function findByIdTechniquementInvalide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 1)
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

    public function findByIdTechniquementValide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 2)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/

    public function countAllByInvalide($invalide)
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
