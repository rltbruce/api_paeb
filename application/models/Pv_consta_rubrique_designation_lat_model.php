<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pv_consta_rubrique_designation_lat_model extends CI_Model {
    protected $table = 'pv_consta_rubrique_designation_lat';

    public function add($pv_consta_rubrique_designation_lat) {
        $this->db->set($this->_set($pv_consta_rubrique_designation_lat))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $pv_consta_rubrique_designation_lat) {
        $this->db->set($this->_set($pv_consta_rubrique_designation_lat))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($pv_consta_rubrique_designation_lat) {
        return array(
            'libelle'       =>      $pv_consta_rubrique_designation_lat['libelle'],
            'description'   =>      $pv_consta_rubrique_designation_lat['description'],
            'numero'    => $pv_consta_rubrique_designation_lat['numero'] ,
            'id_rubrique_phase'    => $pv_consta_rubrique_designation_lat['id_rubrique_phase']                      
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
                        ->order_by('numero')
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
    public function getrubrique_designation_lat($id_rubrique_phase) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_rubrique_phase',$id_rubrique_phase)
                        ->order_by('numero')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function getpv_consta_statutravauxbyphasecontrat($id_rubrique_phase,$id_pv_consta_entete_travaux,$id_contrat_prestataire) {
        $this->db->select("pv_consta_rubrique_designation_lat.numero as numero, pv_consta_rubrique_designation_lat.libelle as libelle,pv_consta_rubrique_designation_lat.id as id_designation");
    
        $this->db ->select("(select pv_consta_statu_lat_travaux.id 
                                        
                                        from pv_consta_statu_lat_travaux,pv_consta_entete_travaux 
                                            
                                            where pv_consta_statu_lat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id 
                                                    and pv_consta_statu_lat_travaux.id_rubrique_designation=id_designation  
                                                    and pv_consta_statu_lat_travaux.id_pv_consta_entete_travaux='".$id_pv_consta_entete_travaux."'
                                ) as id",FALSE);
            $this->db ->select("(select pv_consta_statu_lat_travaux.status 
                                        
                                        from pv_consta_statu_lat_travaux,pv_consta_entete_travaux 
                                            
                                            where pv_consta_statu_lat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id 
                                                    and pv_consta_statu_lat_travaux.id_rubrique_designation=id_designation  
                                                    and pv_consta_statu_lat_travaux.id_pv_consta_entete_travaux='".$id_pv_consta_entete_travaux."'
                                ) as periode",FALSE);

            $this->db ->select("(select pv_consta_statu_lat_travaux.status 
                                        
                                from pv_consta_statu_lat_travaux,pv_consta_entete_travaux,facture_mpe 
                                    
                                    where pv_consta_statu_lat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id
                                            and pv_consta_entete_travaux.id=facture_mpe.id_pv_consta_entete_travaux 
                                            and pv_consta_entete_travaux.id_contrat_prestataire = '".$id_contrat_prestataire."' 
                                            and pv_consta_statu_lat_travaux.id_rubrique_designation=id_designation 
                                            and facture_mpe.validation=2 
                                            and pv_consta_statu_lat_travaux.id_pv_consta_entete_travaux<'".$id_pv_consta_entete_travaux."'
                                             
                        ) as anterieur",FALSE);
                
    
        $result =  $this->db->from('pv_consta_rubrique_designation_lat')
                            //->join('pv_consta_rubrique_phase_lat','pv_consta_rubrique_designation_lat.id_rubrique_phase=pv_consta_rubrique_phase_lat.id')
                            ->where('pv_consta_rubrique_designation_lat.id_rubrique_phase',$id_rubrique_phase)
                            ->order_by('numero')
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