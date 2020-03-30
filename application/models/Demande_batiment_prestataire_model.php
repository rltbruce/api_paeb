<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_batiment_prestataire_model extends CI_Model {
    protected $table = 'demande_batiment_presta';

    public function add($demande_batiment_prestataire) {
        $this->db->set($this->_set($demande_batiment_prestataire))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_batiment_prestataire) {
        $this->db->set($this->_set($demande_batiment_prestataire))
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
    public function _set($demande_batiment_prestataire) {
        return array(
            'objet'          =>      $demande_batiment_prestataire['objet'],
            'description'   =>      $demande_batiment_prestataire['description'],
            'ref_facture'   =>      $demande_batiment_prestataire['ref_facture'],
            'montant'   =>      $demande_batiment_prestataire['montant'],
            'id_tranche_demande_mpe' => $demande_batiment_prestataire['id_tranche_demande_mpe'],
            'anterieur' => $demande_batiment_prestataire['anterieur'],
            'cumul' => $demande_batiment_prestataire['cumul'],
            'reste' => $demande_batiment_prestataire['reste'],
            'date'          =>      $demande_batiment_prestataire['date'],
            'id_contrat_prestataire'    =>  $demande_batiment_prestataire['id_contrat_prestataire'],
            'validation'    =>  $demande_batiment_prestataire['validation']                       
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
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findAllInvalideBycisco($id_cisco) {               
        $result =  $this->db->select('demande_batiment_presta.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_batiment_presta.id_contrat_prestataire')
                        ->join('convention_cisco_feffi_entete','contrat_prestataire.id_convention_entete = convention_cisco_feffi_entete.id')
                        
                        ->where("demande_batiment_presta.validation", 0)
                        ->where("convention_cisco_feffi_entete.id_cisco", $id_cisco)
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

        public function findAllValideBycisco($id_cisco) {               
        $result =  $this->db->select('demande_batiment_presta.*, contrat_prestataire.id as id_contrat')
                        ->from($this->table)
                        ->join('batiment_construction','batiment_construction.id = demande_batiment_presta.id_batiment_construction')
                        ->join('convention_cisco_feffi_entete','batiment_construction.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('contrat_prestataire','contrat_prestataire.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->where("demande_batiment_presta.validation", 3)
                        ->where("convention_cisco_feffi_entete.id_cisco", $id_cisco)
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

        public function findAllValide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 3)
                        ->order_by('date_approbation')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

            public function findAllValidetechnique() {               
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
    public function findAlldemandeBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('demande_batiment_presta.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_batiment_presta.id_contrat_prestataire')
                        ->where("contrat_prestataire.id", $id_contrat_prestataire)
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
     

}
