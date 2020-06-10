<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avance_demarrage_model extends CI_Model {
    protected $table = 'avance_demarrage';

    public function add($avance_demarrage) {
        $this->db->set($this->_set($avance_demarrage))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avance_demarrage) {
        $this->db->set($this->_set($avance_demarrage))
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
    public function _set($avance_demarrage) {
        return array(
            'description' => $avance_demarrage['description'],
            'montant_avance' => $avance_demarrage['montant_avance'],
            'date_signature' => $avance_demarrage['date_signature'],
            'pourcentage_rabais' => $avance_demarrage['pourcentage_rabais'],
            'montant_rabais' => $avance_demarrage['montant_rabais'],
            'net_payer' => $avance_demarrage['net_payer'],
            'id_contrat_prestataire' => $avance_demarrage['id_contrat_prestataire'], 
            'validation'    =>  $avance_demarrage['validation']                     
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
    public function findavance_demarrageBycontrat($id_contrat_prestataire) {               
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
         public function findavance_demarragevalidebcafBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("validation>", 0)
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
