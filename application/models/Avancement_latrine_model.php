<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avancement_latrine_model extends CI_Model {
    protected $table = 'avancement_latrine';

    public function add($avancement_latrine) {
        $this->db->set($this->_set($avancement_latrine))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avancement_latrine) {
        $this->db->set($this->_set($avancement_latrine))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avancement_latrine) {
        return array(

            'description' => $avancement_latrine['description'],
            'intitule'   => $avancement_latrine['intitule'],
            'observation'    => $avancement_latrine['observation'],
            'date'   => $avancement_latrine['date'],
            'id_attachement_latrine' => $avancement_latrine['id_attachement_latrine'],
            'id_latrine_construction' => $avancement_latrine['id_latrine_construction']                      
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

    public function findAllBylatrine_construction($id_latrine_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_latrine_construction", $id_latrine_construction)
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
