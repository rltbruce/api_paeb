<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ecole_model extends CI_Model {
    protected $table = 'ecole';

    public function add($ecole) {
        $this->db->set($this->_set($ecole))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $ecole) {
        $this->db->set($this->_set($ecole))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($ecole) {
        return array(
            'code'          =>      $ecole['code'],
            'lieu'          =>      $ecole['lieu'],
            'description'   =>      $ecole['description'],
            'latitude'      =>      $ecole['latitude'],
            'longitude'     =>      $ecole['longitude'],
            'altitude'      =>      $ecole['altitude'],
            'ponderation'   =>      $ecole['ponderation'],
            'id_commune'    =>      $ecole['id_commune']                       
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
                        ->order_by('description')
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

    public function findBycommune($id_commune) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_commune',$id_commune)
                        ->order_by('description')
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