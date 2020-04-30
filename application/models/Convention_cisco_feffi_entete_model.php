<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convention_cisco_feffi_entete_model extends CI_Model {
    protected $table = 'convention_cisco_feffi_entete';

    public function add($convention) {
        $this->db->set($this->_set($convention))
                            ->set('date_creation', 'NOW()', false)
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $convention) {
        $this->db->set($this->_set($convention))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($convention) {
        return array(
            'ref_convention' => $convention['ref_convention'],
            'objet' =>    $convention['objet'],
            'id_cisco' => $convention['id_cisco'],
            'id_feffi' => $convention['id_feffi'],
            'id_site' => $convention['id_site'],
            'ref_financement'    => $convention['ref_financement'],
            'avancement'=> $convention['avancement'],            
            'montant_total' =>    $convention['montant_total'],
            'validation'   =>$convention['validation'],
            'id_convention_ufpdaaf'   =>$convention['id_convention_ufpdaaf'],
            'type_convention'   =>$convention['type_convention'],
            'id_user'   =>$convention['id_user']                  
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
                        ->order_by('ref_convention')
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
    public function findByIdObjet($id) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllInvalideByid_cisco($id_cisco) {             //mande  
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",0)
                        ->where("id_cisco",$id_cisco)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findAllByufpdaaf($id_convention_ufpdaaf) {       //mande        
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",2)
                        ->where("id_convention_ufpdaaf",$id_convention_ufpdaaf)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function findAllValidedaaf() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",1)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findAllValideufpByid_cisco($id_cisco) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",2)
                        ->where("id_cisco",$id_cisco)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findconventionvalideufpBydatenowwithcount($date_signature) {               
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->where("validation",2)
                        ->join('convention_cisco_feffi_detail','convention_cisco_feffi_detail.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->where("DATE_FORMAT(convention_cisco_feffi_detail.date_signature,'%Y')",$date_signature)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
   /* public function findAllValideByid_cisco($id_cisco) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation !=",0)
                        ->where("id_cisco",$id_cisco)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/

  /* public function findAllInvalide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",0)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }


    public function findAllValide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",2)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    

    public function findAllValideByfeffi($id_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",2)
                        ->where("id_feffi",$id_feffi)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

 


    
     

        public function findAllValideufpByid_cisco($id_cisco) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation",2)
                        ->where("id_cisco",$id_cisco)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findconventionByid_ecole($id_ecole)
    {               
        $result =  $this->db->select('convention_cisco_feffi_entete.*')
                        ->from($this->table)
                        ->join('feffi','feffi.id=convention_cisco_feffi_entete.id_feffi')
                        ->join('ecole','ecole.id=feffi.id_ecole')
                        ->where("validation",2)
                        ->where("ecole.id",$id_ecole)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/
/*public function findconventionmaxBydate($date_today) // id=(select max(id) from convention_cisco_feffi_entete) and
    {
        $sql = "select *
                        from convention_cisco_feffi_entete
                        where date_creation = ".$date_today."";
        return $this->db->query($sql)->result();                  
    }*/

  
   public function findconventionmaxBydate($date_today)  //mande
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id=(select max(id) from convention_cisco_feffi_entete)")
                        ->where("date_creation",$date_today)
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
