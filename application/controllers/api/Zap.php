<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Zap extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('zap_model', 'ZapManager');        
        $this->load->model('commune_model', 'CommuneManager');
    }
    //recuperation zap
    public function index_get() {
		set_time_limit(0);
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');

        if ($cle_etrangere) {
            $data = array();
			// Récupération des zap par commune
            $tmp = $this->ZapManager->findAllByCommune($cle_etrangere);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
					// Récupérationdescription commune
                    $commune = array();
                    $commune = $this->CommuneManager->findByIdOLD($value->id_commune);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['commune'] = $commune;
                }
            }    
        } else {
            if ($id) {
                $data = array();
				// Récupération par id
                $zap = $this->ZapManager->findById($id);
                $commune = $this->CommmuneManager->findById($zap->id_commune);
                $data['id'] = $zap->id;
                $data['code'] = $zap->code;
                $data['nom'] = $zap->nom;
                $data['commune'] = $commune;
                
            } else {
				// Récupération de tous les zap
                $zap = $this->ZapManager->findAll();
                if ($zap) {
                    foreach ($zap as $key => $value) {
                        $commune = array();
                        $commune = $this->CommuneManager->findById($value->id_commune);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['nom'] = $value->nom;
                        $data[$key]['id_commune'] = $value->id_commune;
                        $data[$key]['commune'] = $commune;

                    };
                } else
                    $data = array();
            }
        }
        if (count($data)>0) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => TRUE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }
    //insertion,modification,suppression zap
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
		$data = array(
			'code' => $this->post('code'),
			'nom' => $this->post('nom'),
			'id_commune' => $this->post('id_commune')
		);               
        if ($supprimer == 0) {
            if ($id == 0) {
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				// Ajout d'un enregistrement
                $dataId = $this->ZapManager->add($data);              
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
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				// Mise à jour d'un enregistrement
                $update = $this->ZapManager->update($id, $data);              
                if(!is_null($update)){
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
			// Suppression d'un enregistrement
            $delete = $this->ZapManager->delete($id);          
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