<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avancement_mobilier_model extends CI_Model {
    protected $table = 'avancement_mobilier';

    public function add($avancement_mobilier) {
        $this->db->set($this->_set($avancement_mobilier))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avancement_mobilier) {
        $this->db->set($this->_set($avancement_mobilier))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avancement_mobilier) {
        return array(

            'description' => $avancement_mobilier['description'],
            'intitule'   => $avancement_mobilier['intitule'],
            'observation'    => $avancement_mobilier['observation'],
            'date'   => $avancement_mobilier['date'],
            'id_attachement_mobilier' => $avancement_mobilier['id_attachement_mobilier'],
            'id_mobilier_construction' => $avancement_mobilier['id_mobilier_construction']                      
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

    public function findAllBymobilier_construction($id_mobilier_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_mobilier_construction", $id_mobilier_construction)
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
