<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Prestation_mpe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('prestation_mpe_model', 'Prestation_mpeManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestatireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');

         if ($cle_etrangere)
         {
            $menu = $this->Prestation_mpeManager->findAllByContrat($cle_etrangere);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_prestataire = $this->Contrat_prestatireManager->findById($value->id_contrat_prestataire);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_pre_debu_trav'] = $value->date_pre_debu_trav;
                    $data[$key]['date_reel_debu_trav']= $value->date_reel_debu_trav;
                    $data[$key]['delai_execution']    = $value->delai_execution;
                    $data[$key]['date_expiration_assurance_mpe']   = $value->date_expiration_assurance_mpe;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $passation_marches = $this->Prestation_mpeManager->findById($id);

            $contrat_prestataire = $this->Contrat_prestatireManager->findById($passation_marches->id_contrat_prestataire);

            $data['id'] = $passation_marches->id;
            $data['date_pre_debu_trav'] = $passation_marches->date_pre_debu_trav;
            $data['date_reel_debu_trav']   = $passation_marches->date_reel_debu_trav;
            $data['delai_execution']    = $passation_marches->delai_execution;
            $data['date_expiration_assurance_mpe']   = $passation_marches->date_expiration_assurance_mpe;
            $data['contrat_prestataire'] = $contrat_prestataire;
        } 
        else 
        {
            $menu = $this->Prestation_mpeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_prestataire = $this->Contrat_prestatireManager->findById($value->id_contrat_prestataire);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_pre_debu_trav'] = $value->date_pre_debu_trav;
                    $data[$key]['date_reel_debu_trav']   = $value->date_reel_debu_trav;
                    $data[$key]['delai_execution']    = $value->delai_execution;
                    $data[$key]['date_expiration_assurance_mpe']   = $value->date_expiration_assurance_mpe;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }
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
                     'id' => $this->post('id'),
                    'date_pre_debu_trav' => $this->post('date_pre_debu_trav'),
                    'date_reel_debu_trav'   => $this->post('date_reel_debu_trav'),
                    'delai_execution'    => $this->post('delai_execution'),
                    'date_expiration_assurance_mpe'   => $this->post('date_expiration_assurance_mpe'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Prestation_mpeManager->add($data);
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
                    'id' => $this->post('id'),
                    'date_pre_debu_trav' => $this->post('date_pre_debu_trav'),
                    'date_reel_debu_trav'   => $this->post('date_reel_debu_trav'),
                    'delai_execution'    => $this->post('delai_execution'),
                    'date_expiration_assurance_mpe'   => $this->post('date_expiration_assurance_mpe'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Prestation_mpeManager->update($id, $data);
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
            $delete = $this->Prestation_mpeManager->delete($id);         
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
