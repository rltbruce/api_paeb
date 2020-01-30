<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Attachement_mobilier extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('attachement_mobilier_model', 'Attachement_mobilierManager');
        $this->load->model('annexe_mobilier_model', 'Annexe_mobilierManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_annexe_mobilier = $this->get('id_annexe_mobilier');
            
        if ($id_annexe_mobilier) 
        {   $data = array();
            $tmp = $this->Attachement_mobilierManager->findByannexe_mobilier($id_annexe_mobilier);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $annexe_mobilier = array();
                    $annexe_mobilier = $this->Annexe_mobilierManager->findById($value->id_annexe_mobilier);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ponderation_mobilier'] = $value->ponderation_mobilier;
                    $data[$key]['annexe_mobilier'] = $annexe_mobilier;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $attachement_mobilier = $this->Attachement_mobilierManager->findById($id);
            $annexe_mobilier = $this->Annexe_mobilierManager->findById($attachement_mobilier->id_annexe_mobilier);
            $data['id'] = $attachement_mobilier->id;
            $data['libelle'] = $attachement_mobilier->libelle;
            $data['description'] = $attachement_mobilier->description;
            $data['ponderation_mobilier'] = $attachement_mobilier->ponderation_mobilier;
            $data['annexe_mobilier'] = $annexe_mobilier;
        } 
        else 
        {
            $menu = $this->Attachement_mobilierManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $annexe_mobilier = $this->Annexe_mobilierManager->findById($value->id_annexe_mobilier);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ponderation_mobilier'] = $value->ponderation_mobilier;
                    $data[$key]['annexe_mobilier'] = $annexe_mobilier;
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
                    'ponderation_mobilier' => $this->post('ponderation_mobilier'),
                    'id_annexe_mobilier' => $this->post('id_annexe_mobilier')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Attachement_mobilierManager->add($data);
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
                    'ponderation_mobilier' => $this->post('ponderation_mobilier'),
                    'id_annexe_mobilier' => $this->post('id_annexe_mobilier')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Attachement_mobilierManager->update($id, $data);
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
            $delete = $this->Attachement_mobilierManager->delete($id);         
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
