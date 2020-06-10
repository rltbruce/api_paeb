<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Divers_attachement_latrine_travaux extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('divers_attachement_latrine_travaux_model', 'Divers_attachement_latrine_travauxManager');
        //$this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('divers_attachement_latrine_prevu_model', 'Divers_attachement_latrine_prevuManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_demande_latrine_mpe = $this->get('id_demande_latrine_mpe');
        $id_divers_attachement_latrine_prevu = $this->get('id_divers_attachement_latrine_prevu');
        $menu = $this->get('menu');
 
        if ($menu == "getmaxattachement_travauxByattachement_prevu")
        {
            $tmp = $this->Divers_attachement_latrine_travauxManager->findmaxattachement_travauxByattachement_prevu($id_divers_attachement_latrine_prevu,$id_contrat_prestataire);
            if ($tmp) 
            {   
               foreach ($tmp as $key => $value)
                {   

                    $divers_attachement_latrine_prevu = $this->Divers_attachement_latrine_prevuManager->findByIdlibelle($value->id_divers_attachement_latrine_prevu);                 
                    $data[$key]['id'] = $value->id;                  
                    $data[$key]['id_demande_latrine'] = $value->id_demande_latrine;                  
                    $data[$key]['montant_prevu'] = $value->montant_prevu;                  
                    $data[$key]['montant_periode'] = $value->montant_periode;                  
                    $data[$key]['montant_anterieur'] = $value->montant_anterieur;                  
                    $data[$key]['montant_cumul'] = $value->montant_cumul;                 
                    $data[$key]['pourcentage'] = $value->pourcentage;                 
                    $data[$key]['divers_attachement_latrine_prevu'] = $value->divers_attachement_latrine_prevu;
                }
               // $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getdivers_attachementByDemande")
        {
            $tmp = $this->Divers_attachement_latrine_travauxManager->finddivers_attachementByDemande($id_demande_latrine_mpe);
            if ($tmp) 
            {   
               foreach ($tmp as $key => $value)
                {   

                    $divers_attachement_latrine_prevu = $this->Divers_attachement_latrine_prevuManager->findByIdlibelle($value->id_divers_attachement_latrine_prevu);                 
                    $data[$key]['id'] = $value->id;                  
                    $data[$key]['id_demande_latrine_mpe'] = $value->id_demande_latrine_mpe;                  
                    //$data[$key]['montant_prevu'] = $value->montant_prevu;                  
                    $data[$key]['montant_periode'] = $value->montant_periode;                  
                    $data[$key]['montant_anterieur'] = $value->montant_anterieur;                  
                    $data[$key]['montant_cumul'] = $value->montant_cumul;                 
                    $data[$key]['pourcentage'] = $value->pourcentage;                 
                    $data[$key]['divers_attachement_latrine_prevu'] = $divers_attachement_latrine_prevu;
                }
               // $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $divers_attachement_latrine_travaux = $this->Divers_attachement_latrine_travauxManager->findById($id);
            $data['id'] = $divers_attachement_latrine_travaux->id;
            $data['montant_prevu'] = $divers_attachement_latrine_travaux->montant_prevu;
            $data['id_contrat_prestataire'] = $divers_attachement_latrine_travaux->id_contrat_prestataire;
            $data['id_divers_attachement_latrine'] = $divers_attachement_latrine_travaux->id_divers_attachement_latrine;
        } 
        else 
        {
            $tmp = $this->Divers_attachement_latrine_travauxManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
    
        
        if (count($data)>0) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }
    public function index_post() 
    {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'montant_periode' => $this->post('montant_periode'),
                    'montant_anterieur' => $this->post('montant_anterieur'),
                    'montant_cumul' => $this->post('montant_cumul'),
                    'pourcentage' => $this->post('pourcentage'),
                    'id_demande_latrine_mpe' => $this->post('id_demande_latrine_mpe'),
                    'id_divers_attachement_latrine_prevu' => $this->post('id_divers_attachement_latrine_prevu')            
              
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Divers_attachement_latrine_travauxManager->add($data);
                if (!is_null($dataId)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => $dataId,
                        'message' => 'Data insert success'
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $data = array(
                    'montant_periode' => $this->post('montant_periode'),
                    'montant_anterieur' => $this->post('montant_anterieur'),
                    'montant_cumul' => $this->post('montant_cumul'),
                    'pourcentage' => $this->post('pourcentage'),
                    'id_demande_latrine_mpe' => $this->post('id_demande_latrine_mpe'),
                    'id_divers_attachement_latrine_prevu' => $this->post('id_divers_attachement_latrine_prevu')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Divers_attachement_latrine_travauxManager->update($id, $data);
                if(!is_null($update)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => 1,
                        'message' => 'Update data success'
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_OK);
                }
            }
        } else {
            if (!$id) {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->Divers_attachement_latrine_travauxManager->delete($id);         
            if (!is_null($delete)) {
                $this->response([
                    'status' => TRUE,
                    'response' => 1,
                    'message' => "Delete data success"
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_OK);
            }
        }        
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
