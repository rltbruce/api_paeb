<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_prestataire_model extends CI_Model {
    protected $table = 'contrat_prestataire';

    public function add($contrat_prestataire) {
        $this->db->set($this->_set($contrat_prestataire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $contrat_prestataire) {
        $this->db->set($this->_set($contrat_prestataire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_prestataire) {
        return array(

            'description' => $contrat_prestataire['description'],
            'num_contrat'   => $contrat_prestataire['num_contrat'],
            'cout_batiment'    => $contrat_prestataire['cout_batiment'],
            'cout_latrine'   => $contrat_prestataire['cout_latrine'],
            'cout_mobilier' => $contrat_prestataire['cout_mobilier'],
            'date_signature' => $contrat_prestataire['date_signature'],
            'date_prev_deb_trav' => $contrat_prestataire['date_prev_deb_trav'],
            'date_reel_deb_trav' => $contrat_prestataire['date_reel_deb_trav'],
            'delai_execution' => $contrat_prestataire['delai_execution'],
            'id_convention_entete' => $contrat_prestataire['id_convention_entete'],
            'id_prestataire' => $contrat_prestataire['id_prestataire'],
            'paiement_recu' => $contrat_prestataire['paiement_recu']                      
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

}
