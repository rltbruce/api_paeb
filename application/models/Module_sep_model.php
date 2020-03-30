<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_sep_model extends CI_Model {
    protected $table = 'module_sep';

    public function add($module_sep) {
        $this->db->set($this->_set($module_sep))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $module_sep) {
        $this->db->set($this->_set($module_sep))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($module_sep) {
        return array( 
            'id' => $module_sep['id'],
            'date_debut_previ_form' => $module_sep['date_debut_previ_form'],
            'date_fin_previ_form'   => $module_sep['date_fin_previ_form'],
            'date_previ_resti'    => $module_sep['date_previ_resti'],
            'date_debut_reel_form' => $module_sep['date_debut_reel_form'],
            'date_fin_reel_form' => $module_sep['date_fin_reel_form'],
            'date_reel_resti' => $module_sep['date_reel_resti'],
            'nbr_previ_parti'   => $module_sep['nbr_previ_parti'],
            'nbr_previ_fem_parti'   => $module_sep['nbr_previ_fem_parti'],
            'lieu_formation' => $module_sep['lieu_formation'],
            'observation' => $module_sep['observation'],
            'id_contrat_partenaire_relai' => $module_sep['id_contrat_partenaire_relai'],
            'validation' => $module_sep['validation'],

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
        $sql=" select module_sep.* from module_sep where DATE_FORMAT(module_sep.date_debut_previ_form,'%Y') = DATE_FORMAT(now(),'%Y') and validation = 1 group by module_sep.id";
        return $this->db->query($sql)->result();                 
    }
    public function getmoduleBycontrat($id_contrat_partenaire_relai)
    {               
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

}
