<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Passation_marches_be_model extends CI_Model {
    protected $table = 'passation_marches_be';

    public function add($passation_marches_be) {
        $this->db->set($this->_set($passation_marches_be))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $passation_marches_be) {
        $this->db->set($this->_set($passation_marches_be))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($passation_marches_be) {
        return array(

            'date_lancement_dp' => $passation_marches_be['date_lancement_dp'],
            'date_remise'   => $passation_marches_be['date_remise'],
            'nbr_offre_recu'    => $passation_marches_be['nbr_offre_recu'],
            'date_rapport_evaluation' => $passation_marches_be['date_rapport_evaluation'],
            'date_demande_ano_dpfi' => $passation_marches_be['date_demande_ano_dpfi'],
            'date_ano_dpfi' => $passation_marches_be['date_ano_dpfi'],
            'notification_intention'   => $passation_marches_be['notification_intention'],
            'date_notification_attribution'    => $passation_marches_be['date_notification_attribution'],
            'date_signature_contrat'   => $passation_marches_be['date_signature_contrat'],
            'date_os' => $passation_marches_be['date_os'],
            'observation' => $passation_marches_be['observation'],

            'date_shortlist'   => $passation_marches_be['date_shortlist'],
            'date_manifestation' => $passation_marches_be['date_manifestation'],
            'statut' => $passation_marches_be['statut'],

            'id_convention_entete' => $passation_marches_be['id_convention_entete'],
            'id_be' => $passation_marches_be['id_be']                       
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
                        ->order_by('date_manifestation')
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
