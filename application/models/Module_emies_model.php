<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_emies_model extends CI_Model {
    protected $table = 'module_emies';

    public function add($module_emies) {
        $this->db->set($this->_set($module_emies))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $module_emies) {
        $this->db->set($this->_set($module_emies))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($module_emies) {
        return array( 
            'id' => $module_emies['id'],
            'date_debut_previ_form' => $module_emies['date_debut_previ_form'],
            'date_fin_previ_form'   => $module_emies['date_fin_previ_form'],
            'date_previ_resti'    => $module_emies['date_previ_resti'],
            'date_debut_reel_form' => $module_emies['date_debut_reel_form'],
            'date_fin_reel_form' => $module_emies['date_fin_reel_form'],
            'date_reel_resti' => $module_emies['date_reel_resti'],
            'nbr_previ_parti'   => $module_emies['nbr_previ_parti'],
            'nbr_previ_fem_parti'   => $module_emies['nbr_previ_fem_parti'],
            'lieu_formation' => $module_emies['lieu_formation'],
            'observation' => $module_emies['observation'],
            'id_contrat_partenaire_relai' => $module_emies['id_contrat_partenaire_relai'],
            'validation' => $module_emies['validation'],

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
    public function findAllByinvalide()
    {               
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


    public function findAllByDate()
    {               
        $sql=" select module_emies.* from module_emies where DATE_FORMAT(module_emies.date_debut_previ_form,'%Y') = DATE_FORMAT(now(),'%Y') and validation = 1 group by module_emies.id";
        return $this->db->query($sql)->result();                 
    }

}