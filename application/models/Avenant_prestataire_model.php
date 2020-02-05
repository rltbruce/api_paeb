<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avenant_prestataire_model extends CI_Model {
    protected $table = 'avenant_prestataire';

    public function add($avenant_prestataire) {
        $this->db->set($this->_set($avenant_prestataire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avenant_prestataire) {
        $this->db->set($this->_set($avenant_prestataire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avenant_prestataire) {
        return array(

            'description' => $avenant_prestataire['description'],
            'cout_batiment'    => $avenant_prestataire['cout_batiment'],
            'cout_latrine'   => $avenant_prestataire['cout_latrine'],
            'cout_mobilier' => $avenant_prestataire['cout_mobilier'],
            'date_signature' => $avenant_prestataire['date_signature'],
            'id_contrat_prestataire' => $avenant_prestataire['id_contrat_prestataire']                      
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

    public function findAllByContrat_prestataire($id_contrat_prestataire) {               
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
