<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Batiment_ouvrage_model extends CI_Model {
    protected $table = 'batiment_ouvrage';

    public function add($batiment_ouvrage) {
        $this->db->set($this->_set($batiment_ouvrage))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $batiment_ouvrage) {
        $this->db->set($this->_set($batiment_ouvrage))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($batiment_ouvrage) {
        return array(
            'libelle'       =>      $batiment_ouvrage['libelle'],
            'description'   =>      $batiment_ouvrage['description'],
            'cout_batiment' =>      $batiment_ouvrage['cout_batiment'],
            'cout_maitrise_oeuvre' =>      $batiment_ouvrage['cout_maitrise_oeuvre'],
            'cout_sous_projet'     =>      $batiment_ouvrage['cout_sous_projet'],
            'id_acces_zone' => $batiment_ouvrage['id_acces_zone'],
            'id_zone_subvention' => $batiment_ouvrage['id_zone_subvention']                       
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
                        ->order_by('libelle')
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
   /* public function findByouvrage($id_ouvrage)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_ouvrage',$id_ouvrage)
                        ->order_by('libelle')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/
  /*  public function findByZoneOuvrage($id_ouvrage,$id_zone_subvention,$id_acces_zone)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_ouvrage',$id_ouvrage)
                        ->where('id_zone_subvention',$id_zone_subvention)
                        ->where('id_acces_zone',$id_acces_zone)
                        ->order_by('id_ouvrage')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/

   /* public function findByZoneOuvrageessai($id_ouvrage,$id_zone_subvention,$id_acces_zone)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_ouvrage',$id_ouvrage)
                        ->where('id_zone_subvention',$id_zone_subvention)
                        ->where('id_acces_zone',$id_acces_zone)
                        //->order_by('id_ouvrage')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/

}
