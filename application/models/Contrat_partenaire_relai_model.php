<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_partenaire_relai_model extends CI_Model {
    protected $table = 'contrat_partenaire_relai';

    public function add($contrat_partenaire_relai) {
        $this->db->set($this->_set($contrat_partenaire_relai))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $contrat_partenaire_relai) {
        $this->db->set($this->_set($contrat_partenaire_relai))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_partenaire_relai) {
        return array(

            'intitule' => $contrat_partenaire_relai['intitule'],
            'ref_contrat'   => $contrat_partenaire_relai['ref_contrat'],
            'montant_contrat'    => $contrat_partenaire_relai['montant_contrat'],
            'date_signature' => $contrat_partenaire_relai['date_signature'],
            'id_convention_entete' => $contrat_partenaire_relai['id_convention_entete'],
            'id_partenaire_relai' => $contrat_partenaire_relai['id_partenaire_relai']                      
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

    public function findAllByConvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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

    public function findAllBypartenaire_relai($id_partenaire_relai) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_partenaire_relai", $id_partenaire_relai)
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

    public function findByBatiment($id_batiment_construction)  {
        $this->db->select('contrat_partenaire_relai.ref_contrat as ref_contrat, contrat_partenaire_relai.intitule as intitule, contrat_partenaire_relai.montant_contrat as montant_contrat, contrat_partenaire_relai.date_signature as date_signature,contrat_partenaire_relai.id_partenaire_relai as id_partenaire_relai, contrat_partenaire_relai.id_convention_entete as id_convention_entete')
                ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_partenaire_relai.id_convention_entete')
                ->join('batiment_construction','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                ->where("batiment_construction.id", $id_batiment_construction);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findByLatrine($id_latrine_construction)  {
        $this->db->select('contrat_partenaire_relai.ref_contrat as ref_contrat, contrat_partenaire_relai.intitule as intitule, contrat_partenaire_relai.montant_contrat as montant_contrat, contrat_partenaire_relai.date_signature as date_signature,contrat_partenaire_relai.id_partenaire_relai as id_partenaire_relai, contrat_partenaire_relai.id_convention_entete as id_convention_entete')
                ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_partenaire_relai.id_convention_entete')
                ->join('batiment_construction','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                ->join('latrine_construction','batiment_construction.id=latrine_construction.id_batiment_construction')
                ->where("latrine_construction.id", $id_latrine_construction);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findByMobilier($id_mobilier_construction)  {
        $this->db->select('contrat_partenaire_relai.ref_contrat as ref_contrat, contrat_partenaire_relai.intitule as intitule, contrat_partenaire_relai.montant_contrat as montant_contrat, contrat_partenaire_relai.date_signature as date_signature,contrat_partenaire_relai.id_partenaire_relai as id_partenaire_relai, contrat_partenaire_relai.id_convention_entete as id_convention_entete')
                ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_partenaire_relai.id_convention_entete')
                ->join('batiment_construction','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                ->join('mobilier_construction','batiment_construction.id=mobilier_construction.id_batiment_construction')
                ->where("mobilier_construction.id", $id_mobilier_construction);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

}
