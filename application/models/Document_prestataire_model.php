<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_prestataire_model extends CI_Model {
    protected $table = 'document_prestataire';

    public function add($document_prestataire) {
        $this->db->set($this->_set($document_prestataire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $document_prestataire) {
        $this->db->set($this->_set($document_prestataire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($document_prestataire) {
        return array(
            'code'       =>      $document_prestataire['code'],
            'intitule'   =>      $document_prestataire['intitule']                       
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
                        ->order_by('intitule')
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

    public function findAllByContrat($id_contrat_prestataire) {               
       /* $result =  $this->db->select('document_prestataire.id as id, document_prestataire.code as code, document_prestataire.intitule as intitule, document_prestataire_scan.id as id_document_prestataire_scan, document_prestataire_scan.fichier as fichier, document_prestataire_scan.date_elaboration as date_elaboration, document_prestataire_scan.observation as observation, document_prestataire_scan.id_contrat_prestataire as id_contrat_prestataire')
                        ->from($this->table)
                        ->join('document_prestataire_scan','document_prestataire_scan.id_document_prestataire=document_prestataire.id','left')
                        //->order_by('document_prestataire.code')
                        ->where('document_prestataire_scan.id_contrat_prestataire',$id_contrat_prestataire)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        } */
       /* $sql=" select document_prestataire.id as id, document_prestataire.code as code, document_prestataire.intitule as intitule, document_prestataire_scan.id as id_document_prestataire_scan, document_prestataire_scan.fichier as fichier, document_prestataire_scan.date_elaboration as date_elaboration, document_prestataire_scan.observation as observation, document_prestataire_scan.id_contrat_prestataire as id_contrat_prestataire from document_prestataire left join document_prestataire_scan on document_prestataire_scan.id_document_prestataire = document_prestataire.id group by document_prestataire.id ";
        return $this->db->query($sql)->result();  */
        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_prestataire_scan as id_document_prestataire_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_prestataire as id_contrat_prestataire

                    from
                (select 
                        doc_prestataire.id as id, 
                        doc_prestataire.code as code, 
                        doc_prestataire.intitule as intitule,
                        doc_scan.id as id_document_prestataire_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_prestataire as id_contrat_prestataire 

                    from document_prestataire_scan as doc_scan
            
                        right join document_prestataire as doc_prestataire on doc_scan.id_document_prestataire = doc_prestataire.id 
            
                        where doc_scan.id_contrat_prestataire = ".$id_contrat_prestataire."
            
                        group by doc_prestataire.id 
                UNION 

                select 
                        doc_prestataire.id as id, 
                        doc_prestataire.code as code, 
                        doc_prestataire.intitule as intitule,
                        null as id_document_prestataire_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_prestataire 

                    from document_prestataire as doc_prestataire
            
                        group by doc_prestataire.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }
        public function findAllByConvention($id_convention_entete) {               

        $sql=" 

                select detail.id as id, 
                        detail.code as code, 
                        detail.intitule as intitule,
                        detail.id_document_prestataire_scan as id_document_prestataire_scan, 
                        detail.fichier as fichier, 
                        detail.date_elaboration as date_elaboration, 
                        detail.observation as observation, 
                        detail.id_contrat_prestataire as id_contrat_prestataire

                    from
                (select 
                        doc_prestataire.id as id, 
                        doc_prestataire.code as code, 
                        doc_prestataire.intitule as intitule,
                        doc_scan.id as id_document_prestataire_scan, 
                        doc_scan.fichier as fichier, 
                        doc_scan.date_elaboration as date_elaboration, 
                        doc_scan.observation as observation, 
                        doc_scan.id_contrat_prestataire as id_contrat_prestataire 

                    from document_prestataire_scan as doc_scan
                        inner join contrat_prestataire as contrat_prest on contrat_prest.id = doc_scan.id_contrat_prestataire
                        right join document_prestataire as doc_prestataire on doc_scan.id_document_prestataire = doc_prestataire.id 
            
                        where contrat_prest.id_convention_entete = ".$id_convention_entete."
            
                        group by doc_prestataire.id 
                UNION 

                select 
                        doc_prestataire.id as id, 
                        doc_prestataire.code as code, 
                        doc_prestataire.intitule as intitule,
                        null as id_document_prestataire_scan, 
                        null as fichier, 
                        null as date_elaboration, 
                        null as observation, 
                        null as id_contrat_prestataire 

                    from document_prestataire as doc_prestataire
            
                        group by doc_prestataire.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }

}
