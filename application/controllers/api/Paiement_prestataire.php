<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Paiement_prestataire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('paiement_prestataire_model', 'Paiement_prestataireManager');
        $this->load->model('demande_payement_prestataire_model', 'Demande_payement_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_prestataire = $this->get('id_demande_prestataire');
            
        if ($id_demande_prestataire) 
        {   $data = array();
            $tmp = $this->Paiement_prestataireManager->findBydemande_payement_prestataire($id_demande_payement_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_payement_prestataire = array();
                    $demande_payement_prestataire = $this->Demande_payement_prestataireManager->findById($value->id_demande_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['pourcentage_paiement'] = $value->pourcentage_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_payement_prestataire'] = $demande_payement_prestataire;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $paiement_prestataire = $this->Paiement_prestataireManager->findById($id);
            $demande_payement_prestataire = $this->Demande_payement_prestataireManager->findById($paiement_prestataire->id_demande_prestataire);
            $data['id'] = $paiement_prestataire->id;
            $data['montant_paiement'] = $paiement_prestataire->montant_paiement;
            $data['cumul'] = $paiement_prestataire->cumul;
            $data['pourcentage_paiement'] = $paiement_prestataire->pourcentage_paiement;
            $data['date_paiement'] = $paiement_prestataire->date_paiement;
            $data['observation'] = $paiement_prestataire->observation;
            $data['demande_payement_prestataire'] = $demande_payement_prestataire;
        } 
        else 
        {
            $menu = $this->Paiement_prestataireManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_payement_prestataire = $this->Demande_payement_prestataireManager->findById($value->id_demande_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['pourcentage_paiement'] = $value->pourcentage_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_payement_prestataire'] = $demande_payement_prestataire;
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
                    'montant_paiement' => $this->post('montant_paiement'),
                    'cumul' => $this->post('cumul'),
                    'pourcentage_paiement' => $this->post('pourcentage_paiement'),
                    'date_paiement' => $this->post('date_paiement'),
                    'observation' => $this->post('observation'),
                    'id_demande_prestataire' => $this->post('id_demande_prestataire')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Paiement_prestataireManager->add($data);
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
                    'montant_paiement' => $this->post('montant_paiement'),
                    'cumul' => $this->post('cumul'),
                    'pourcentage_paiement' => $this->post('pourcentage_paiement'),
                    'date_paiement' => $this->post('date_paiement'),
                    'observation' => $this->post('observation'),
                    'id_demande_prestataire' => $this->post('id_demande_prestataire')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Paiement_prestataireManager->update($id, $data);
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
            $delete = $this->Paiement_prestataireManager->delete($id);         
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
