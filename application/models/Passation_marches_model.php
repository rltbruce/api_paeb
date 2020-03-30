<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Passation_marches_model extends CI_Model {
    protected $table = 'passation_marches';

    public function add($passation_marches) {
        $this->db->set($this->_set($passation_marches))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $passation_marches) {
        $this->db->set($this->_set($passation_marches))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($passation_marches) {
        return array(

            'date_lancement' => $passation_marches['date_lancement'],
            'date_remise'   => $passation_marches['date_remise'],
            'montant_moin_chere'   => $passation_marches['montant_moin_chere'],
            'date_rapport_evaluation' => $passation_marches['date_rapport_evaluation'],
            'date_demande_ano_dpfi' => $passation_marches['date_demande_ano_dpfi'],
            'date_ano_dpfi' => $passation_marches['date_ano_dpfi'],
            'notification_intention'   => $passation_marches['notification_intention'],
            'date_notification_attribution'    => $passation_marches['date_notification_attribution'],
            'date_os' => $passation_marches['date_os'],
            'observation' => $passation_marches['observation'],
            'id_convention_entete' => $passation_marches['id_convention_entete'],
            'validation' => $passation_marches['validation'],                       
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
    public function findAllByContrat_prestataire($id_contrat_prestataire) {               
        $result =  $this->db->select('
            passation_marches.id as id, passation_marches.id_convention_entete as id_convention_entete, passation_marches.date_lancement as date_lancement, passation_marches.date_remise as date_remise, passation_marches.montant_moin_chere as montant_moin_chere, passation_marches.date_rapport_evaluation as date_rapport_evaluation, passation_marches.date_demande_ano_dpfi as date_demande_ano_dpfi, passation_marches.date_ano_dpfi as date_ano_dpfi, passation_marches.notification_intention as notification_intention, passation_marches.date_notification_attribution as date_notification_attribution, passation_marches.date_os as date_os,passation_marches.observation as observation')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=passation_marches.id_convention_entete')
                        ->join('contrat_prestataire','contrat_prestataire.id_convention_entete=convention_cisco_feffi_entete.id')
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

        public function getpassationByconvention($id_convention_entete) {               
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
