<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_dpp_model extends CI_Model {
    protected $table = 'module_dpp';

    public function add($module_dpp) {
        $this->db->set($this->_set($module_dpp))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $module_dpp) {
        $this->db->set($this->_set($module_dpp))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($module_dpp) {
        return array( 
            'id' => $module_dpp['id'],
            'date_debut_previ_form' => $module_dpp['date_debut_previ_form'],
            'date_fin_previ_form'   => $module_dpp['date_fin_previ_form'],
            'date_previ_resti'    => $module_dpp['date_previ_resti'],
            'date_debut_reel_form' => $module_dpp['date_debut_reel_form'],
            'date_fin_reel_form' => $module_dpp['date_fin_reel_form'],
            'date_reel_resti' => $module_dpp['date_reel_resti'],
            'nbr_previ_parti'   => $module_dpp['nbr_previ_parti'],
            'nbr_previ_fem_parti'   => $module_dpp['nbr_previ_fem_parti'],
            'lieu_formation' => $module_dpp['lieu_formation'],
            'observation' => $module_dpp['observation'],
            'validation' => $module_dpp['validation'],
            'id_contrat_partenaire_relai' => $module_dpp['id_contrat_partenaire_relai'],

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

        public function findAllBycontrat($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_partenaire_relai',$id_contrat_partenaire_relai)
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

    public function findAllByinvalide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('validation',0)
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

        public function findAllByDate() {               
        $sql=" select module_dpp.* from module_dpp where DATE_FORMAT(module_dpp.date_debut_previ_form,'%Y') = DATE_FORMAT(now(),'%Y') and validation = 1 group by module_dpp.id ";
        return $this->db->query($sql)->result();                 
    }

}