<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Attachement extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('attachement_model', 'AttachementManager');
        $this->load->model('ouvrage_model', 'OuvrageManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_ouvrage = $this->get('id_ouvrage');
            
        if ($id_ouvrage) 
        {   $data = array();
            $tmp = $this->AttachementManager->findByouvrage($id_ouvrage);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ouvrage = array();
                    $ouvrage = $this->OuvrageManager->findById($value->id_ouvrage);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ponderation'] = $value->ponderation;
                    $data[$key]['ouvrage'] = $ouvrage;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $attachement = $this->AttachementManager->findById($id);
            $ouvrage = $this->OuvrageManager->findById($attachement->id_ouvrage);
            $data['id'] = $attachement->id;
            $data['libelle'] = $attachement->libelle;
            $data['description'] = $attachement->description;
            $data['ponderation'] = $attachement->ponderation;
            $data['ouvrage'] = $ouvrage;
        } 
        else 
        {
            $menu = $this->AttachementManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $ouvrage = $this->OuvrageManager->findById($value->id_ouvrage);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ponderation'] = $value->ponderation;
                    $data[$key]['ouvrage'] = $ouvrage;
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
                    'ponderation' => $this->post('ponderation'),
                    'id_ouvrage' => $this->post('id_ouvrage')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->AttachementManager->add($data);
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
                    'ponderation' => $this->post('ponderation'),
                    'id_ouvrage' => $this->post('id_ouvrage')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->AttachementManager->update($id, $data);
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
            $delete = $this->AttachementManager->delete($id);         
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
