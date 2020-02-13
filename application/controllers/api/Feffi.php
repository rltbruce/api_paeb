<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('ecole_model', 'EcoleManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_ecole = $this->get('id_ecole');
            
        if ($id_ecole) 
        {   $data = array();
            $tmp = $this->AssociationManager->findByecole($id_ecole);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = array();
                    $cisco = array();
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['identifiant'] = $value->identifiant;
                    $data[$key]['denomination'] = $value->denomination;
                    $data[$key]['nbr_feminin'] = $value->nbr_feminin;
                    $data[$key]['nbr_total'] = $value->nbr_total;
                    $data[$key]['adresse'] = $value->adresse;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $feffi = $this->FeffiManager->findById($id);
            $ecole = $this->EcoleManager->findById($feffi->id_ecole);
            $data['id'] = $feffi->id;
            $data['identifiant'] = $feffi->identifiant;
            $data['denomination'] = $feffi->denomination;
            $data['nbr_feminin'] = $feffi->nbr_feminin;
            $data['nbr_total'] = $feffi->nbr_total;
            $data['adresse'] = $feffi->adresse;
            $data['observation'] = $feffi->observation;
            $data['ecole'] = $ecole;
        } 
        else 
        {
            $menu = $this->FeffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $ecole = array();
                    $cisco = array();
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['identifiant'] = $value->identifiant;
                    $data[$key]['denomination'] = $value->denomination;
                    $data[$key]['nbr_feminin'] = $value->nbr_feminin;
                    $data[$key]['nbr_total'] = $value->nbr_total;
                    $data[$key]['adresse'] = $value->adresse;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
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
                    'identifiant' => $this->post('identifiant'),
                    'denomination' => $this->post('denomination'),
                    'nbr_feminin' => $this->post('nbr_feminin'),
                    'nbr_total' => $this->post('nbr_total'),
                    'adresse' => $this->post('adresse'),
                    'observation' => $this->post('observation'),
                    'id_ecole' => $this->post('id_ecole')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->FeffiManager->add($data);
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
                    'identifiant' => $this->post('identifiant'),
                    'denomination' => $this->post('denomination'),
                    'nbr_feminin' => $this->post('nbr_feminin'),
                    'nbr_total' => $this->post('nbr_total'),
                    'adresse' => $this->post('adresse'),
                    'observation' => $this->post('observation'),
                    'id_ecole' => $this->post('id_ecole')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->FeffiManager->update($id, $data);
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
            $delete = $this->FeffiManager->delete($id);         
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
