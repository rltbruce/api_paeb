<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Phase_sous_projet_model extends CI_Model {
    protected $table = 'phase_sous_projet';

    public function add($phase_sous_projet) {
        $this->db->set($this->_set($phase_sous_projet))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $phase_sous_projet) {
        $this->db->set($this->_set($phase_sous_projet))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($phase_sous_projet) {
        return array(

            'id_infrastructure' => $phase_sous_projet['id_infrastructure'],
            'id_designation_infrastructure'   => $phase_sous_projet['id_designation_infrastructure'],
            'id_element_a_verifier'    => $phase_sous_projet['id_element_a_verifier'],
            'date_verification'   => $phase_sous_projet['date_verification'],
            'conformite' => $phase_sous_projet['conformite'],
            'observation' => $phase_sous_projet['observation'],
            'id_prestation_mpe' => $phase_sous_projet['id_prestation_mpe']                      
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
                        ->order_by('id_infrastructure')
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

    public function findAllByPrestation_mpe($id_prestation_mpe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_prestation_mpe", $id_prestation_mpe)
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
