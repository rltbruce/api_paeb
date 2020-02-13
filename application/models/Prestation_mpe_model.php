<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prestation_mpe_model extends CI_Model {
    protected $table = 'prestation_mpe';

    public function add($prestation_mpe) {
        $this->db->set($this->_set($prestation_mpe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $prestation_mpe) {
        $this->db->set($this->_set($prestation_mpe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($prestation_mpe) {
        return array(

            'date_pre_debu_trav' => $prestation_mpe['date_pre_debu_trav'],
            'date_reel_debu_trav'   => $prestation_mpe['date_reel_debu_trav'],
            'delai_execution'    => $prestation_mpe['delai_execution'],
            'date_expiration_assurance_mpe'   => $prestation_mpe['date_expiration_assurance_mpe'],
            'id_contrat_prestataire' => $prestation_mpe['id_contrat_prestataire']                    
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
                        ->order_by('date_lancement')
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

    public function findAllByContrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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
