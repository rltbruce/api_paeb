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
            'id_zone_subvention' => $ecole['id_zone_subvention'],
            'id_acces_zone' => $ecole['id_acces_zone'],
            'id_fokontany'    =>    $ecole['id_fokontany']                       
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
    public function findByIdZone($id)  {
        $this->db->select('ecole.id as id,ecole.code as code,zone_subvention.libelle as libelle_zone,acces_zone.libelle as libelle_acces,zone_subvention.id as id_zone,acces_zone.id as id_acces')
        ->where("ecole.id", $id)
        ->join('zone_subvention','zone_subvention.id=ecole.id_zone_subvention')
        ->join('acces_zone','acces_zone.id=ecole.id_acces_zone');
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    } 

}
