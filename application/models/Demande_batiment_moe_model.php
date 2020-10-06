<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_batiment_moe_model extends CI_Model {
    protected $table = 'demande_batiment_moe';

    public function add($demande_batiment_moe) {
        $this->db->set($this->_set($demande_batiment_moe))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_batiment_moe) {
        $this->db->set($this->_set($demande_batiment_moe))
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
    public function _set($demande_batiment_moe) {
        return array(
            'objet'          =>      $demande_batiment_moe['objet'],
            'description'   =>      $demande_batiment_moe['description'],
            'ref_facture'   =>      $demande_batiment_moe['ref_facture'],
            'montant'   =>      $demande_batiment_moe['montant'],
            'id_tranche_demande_batiment_moe' => $demande_batiment_moe['id_tranche_demande_batiment_moe'],
            'anterieur' => $demande_batiment_moe['anterieur'],
            'cumul' => $demande_batiment_moe['cumul'],
            'reste' => $demande_batiment_moe['reste'],
            'date'          =>      $demande_batiment_moe['date'],
            'id_contrat_bureau_etude'    =>  $demande_batiment_moe['id_contrat_bureau_etude'],
            'validation'    =>  $demande_batiment_moe['validation']                       
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
                        ->order_by('objet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    
    
        public function finddemandeBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
     public function finddemandeinvalideBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
     public function finddemandevalidebcafBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
    public function finddemandevalideBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
    }
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
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }



    

    public function finddemandevalidedaafByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)                        
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
  
    public function finddemandeemidpfiByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)                        
                        ->where("validation IN(1,2,3)")
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
   public function findallByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
    public function findcreerByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)                        
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
    public function finddemandedisponibleBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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

    public function avancement_financiereBycontrat($id_contrat)
    {
        $sql=" select 
                       (sum(detail.montant_debu) + sum( detail.montant_bat) + sum(detail.montant_lat)
                        + sum( detail.montant_fin)) as montant_facture_total
               from (
               
                (
                    select 
                        contrat_moe.id as id,
                        sum(demande_debu.montant) as montant_debu,
                        0 as montant_bat,
                        0 as montant_lat,
                        0 as montant_fin

                        from demande_debut_travaux_moe as demande_debu
                        inner join contrat_bureau_etude as contrat_moe on contrat_moe.id=demande_debu.id_contrat_bureau_etude
                        where 
                            demande_debu.validation= 4 and contrat_moe.id= '".$id_contrat."'
                )
                UNION
                (
                    select 
                        contrat_moe.id as id,
                        0 as montant_debu,                        
                        sum(demande_bat.montant) as montant_bat,
                        0 as montant_lat,
                        0 as montant_fin

                        from demande_batiment_moe as demande_bat
                        inner join contrat_bureau_etude as contrat_moe on contrat_moe.id=demande_bat.id_contrat_bureau_etude
                        where 
                            demande_bat.validation= 4 and contrat_moe.id= '".$id_contrat."'
                )
                UNION
                (
                    select 
                        contrat_moe.id as id,
                        0 as montant_debu,                        
                        0 as montant_bat,                        
                        sum(demande_lat.montant) as montant_lat,
                        0 as montant_fin

                        from demande_latrine_moe as demande_lat
                        inner join contrat_bureau_etude as contrat_moe on contrat_moe.id=demande_lat.id_contrat_bureau_etude
                        where 
                            demande_lat.validation= 4 and contrat_moe.id= '".$id_contrat."'
                )
                UNION
                (
                    select 
                        contrat_moe.id as id,
                        0 as montant_debu,                        
                        0 as montant_bat,                        
                        0 as montant_lat,                        
                        sum(demande_fin.montant) as montant_fin

                        from demande_fin_travaux_moe as demande_fin
                        inner join contrat_bureau_etude as contrat_moe on contrat_moe.id=demande_fin.id_contrat_bureau_etude
                        where 
                            demande_fin.validation= 4 and contrat_moe.id= '".$id_contrat."'
                )

                )detail

            ";
            return $this->db->query($sql)->result();                  
    }
   /* public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findAllInvalideBybatiment($id_batiment_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 0)
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

    public function findAllInvalide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
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

        public function findAllValidebcaf() {               
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
    public function findAllValidedpfi() {               
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
    }
    public function findAllValide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 3)
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

    
        public function findAllByBatiment($id_batiment_construction) {               
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

    public function findAlldemandeinvalideBycisco($id_cisco)
    {               
        $result =  $this->db->select('demande_batiment_moe.*')
                        ->from($this->table)                        
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id= demande_batiment_moe.id_contrat_bureau_etude')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("demande_batiment_moe.validation", 0)
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
        public function findAlldemandevalideBycisco($id_cisco)
    {               
        $result =  $this->db->select('demande_batiment_moe.*')
                        ->from($this->table)                        
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id= demande_batiment_moe.id_contrat_bureau_etude')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("demande_batiment_moe.validation", 3)
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
        public function finddemandedisponibleBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
    } */  

}
