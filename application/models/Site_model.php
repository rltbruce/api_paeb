<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_model extends CI_Model {
    protected $table = 'site';

    public function add($site) {
        $this->db->set($this->_set($site))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $site) {
        $this->db->set($this->_set($site))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($site) {
        return array( 

            'code_sous_projet' =>      $site['code_sous_projet'],
            'objet_sous_projet' =>      $site['objet_sous_projet'],
            'denomination_epp' =>      $site['denomination_epp'],
            'agence_acc' =>      $site['agence_acc'],
            'statu_convention' =>      $site['statu_convention'],
            'observation' =>      $site['observation'],
            'id_ecole' =>      $site['id_ecole'],                      
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

    public function findsitecreeByfeffi($id_feffi) {               
        $result =  $this->db->select('site.*')
                        ->from($this->table)
                        ->join('ecole','ecole.id=site.id_ecole')
                        ->join('feffi','feffi.id_ecole=ecole.id')
                        ->where('feffi.id',$id_feffi)
                        ->where('statu_convention',0)
                        ->order_by('site.id')
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
