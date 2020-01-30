<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Attachement_batiment extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('attachement_batiment_model', 'Attachement_batimentManager');
        $this->load->model('batiment_ouvrage_model', 'Batiment_ouvrageManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_batiment_ouvrage = $this->get('id_batiment_ouvrage');
            
        if ($id_batiment_ouvrage) 
        {   $data = array();
            $tmp = $this->Attachement_batimentManager->findBybatiment_ouvrage($id_batiment_ouvrage);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $batiment_ouvrage = array();
                    $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($value->id_batiment_ouvrage);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ponderation_batiment'] = $value->ponderation_batiment;
                    $data[$key]['batiment_ouvrage'] = $batiment_ouvrage;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $attachement_batiment = $this->Attachement_batimentManager->findById($id);
            $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($attachement_batiment->id_batiment_ouvrage);
            $data['id'] = $attachement_batiment->id;
            $data['libelle'] = $attachement_batiment->libelle;
            $data['description'] = $attachement_batiment->description;
            $data['ponderation_batiment'] = $attachement_batiment->ponderation_batiment;
            $data['batiment_ouvrage'] = $batiment_ouvrage;
        } 
        else 
        {
            $menu = $this->Attachement_batimentManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($value->id_batiment_ouvrage);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ponderation_batiment'] = $value->ponderation_batiment;
                    $data[$key]['batiment_ouvrage'] = $batiment_ouvrage;
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'ponderation_batiment' => $this->post('ponderation_batiment'),
                    'id_batiment_ouvrage' => $this->post('id_batiment_ouvrage')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Attachement_batimentManager->add($data);
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'ponderation_batiment' => $this->post('ponderation_batiment'),
                    'id_batiment_ouvrage' => $this->post('id_batiment_ouvrage')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Attachement_batimentManager->update($id, $data);
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
            $delete = $this->Attachement_batimentManager->delete($id);         
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
