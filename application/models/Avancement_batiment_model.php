<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avancement_batiment_model extends CI_Model {
    protected $table = 'avancement_batiment';

    public function add($avancement_batiment) {
        $this->db->set($this->_set($avancement_batiment))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avancement_batiment) {
        $this->db->set($this->_set($avancement_batiment))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avancement_batiment) {
        return array(

            'description' => $avancement_batiment['description'],
            'intitule'   => $avancement_batiment['intitule'],
            'observation'    => $avancement_batiment['observation'],
            'date'   => $avancement_batiment['date'],
            'id_attachement_batiment' => $avancement_batiment['id_attachement_batiment'],
            'id_batiment_construction' => $avancement_batiment['id_batiment_construction']                      
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

    public function findAllByBatiment_construction($id_batiment_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_batiment_construction", $id_batiment_construction)
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
