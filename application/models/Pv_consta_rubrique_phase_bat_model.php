<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pv_consta_rubrique_phase_bat_model extends CI_Model {
    protected $table = 'pv_consta_rubrique_phase_bat';

    public function add($pv_consta_rubrique_phase_bat) {
        $this->db->set($this->_set($pv_consta_rubrique_phase_bat))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $pv_consta_rubrique_phase_bat) {
        $this->db->set($this->_set($pv_consta_rubrique_phase_bat))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($pv_consta_rubrique_phase_bat) {
        return array(
            'libelle'       =>      $pv_consta_rubrique_phase_bat['libelle'],
            'description'   =>      $pv_consta_rubrique_phase_bat['description'],
            'numero'    => $pv_consta_rubrique_phase_bat['numero'],
            'pourcentage_prevu'    => $pv_consta_rubrique_phase_bat['pourcentage_prevu']                        
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

    
    public function getpv_consta_rubrique_phase_pourcentagebycontrat($id_contrat_prestataire,$id_pv_consta_entete_travaux) {
        $this->db->select("pv_consta_rubrique_phase_bat.numero as numero, pv_consta_rubrique_phase_bat.libelle as libelle, pv_consta_rubrique_phase_bat.pourcentage_prevu as pourcentage_prevu,pv_consta_rubrique_phase_bat.id as id_phase");
    
        $this->db ->select("(select pv_consta_detail_bat_travaux.id 
                                        
                                        from pv_consta_detail_bat_travaux,pv_consta_entete_travaux 
                                            
                                            where pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id 
                                                    and pv_consta_detail_bat_travaux.id_rubrique_phase=id_phase  
                                                    and pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux='".$id_pv_consta_entete_travaux."'
                                ) as id",FALSE);
            $this->db ->select("(select pv_consta_detail_bat_travaux.periode 
                                        
                                        from pv_consta_detail_bat_travaux,pv_consta_entete_travaux 
                                            
                                            where pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id 
                                                    and pv_consta_detail_bat_travaux.id_rubrique_phase=id_phase  
                                                    and pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux='".$id_pv_consta_entete_travaux."'
                                ) as periode",FALSE);
            
            $this->db ->select("(select pv_consta_detail_bat_travaux.observation 
                                        
                                from pv_consta_detail_bat_travaux,pv_consta_entete_travaux 
                                    
                                    where pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id 
                                            and pv_consta_detail_bat_travaux.id_rubrique_phase=id_phase  
                                            and pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux='".$id_pv_consta_entete_travaux."'
                        ) as observation",FALSE);

            $this->db ->select("(select sum(pv_consta_detail_bat_travaux.periode) 
                                        
                                from pv_consta_detail_bat_travaux,pv_consta_entete_travaux,facture_mpe 
                                    
                                    where pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id
                                            and pv_consta_entete_travaux.id=facture_mpe.id_pv_consta_entete_travaux 
                                            and pv_consta_entete_travaux.id_contrat_prestataire = '".$id_contrat_prestataire."' 
                                            and pv_consta_detail_bat_travaux.id_rubrique_phase=id_phase 
                                            and facture_mpe.validation=2 
                                            and pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux<'".$id_pv_consta_entete_travaux."'
                                             
                        ) as anterieur",FALSE);
                
    
        $result =  $this->db->from('pv_consta_rubrique_phase_bat')
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
