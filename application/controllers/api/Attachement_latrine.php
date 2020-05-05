<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Attachement_latrine extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('attachement_latrine_model', 'Attachement_latrineManager');
        $this->load->model('type_latrine_model', 'Type_latrineManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_type_latrine = $this->get('id_type_latrine');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
            
        if ($id_contrat_prestataire) 
        {   $data = array();
            $tmp = $this->Attachement_latrineManager->findBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $type_latrine = array();
                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ponderation_latrine'] = $value->ponderation_latrine;
                    $data[$key]['type_latrine'] = $type_latrine;
                }
            }
        }
        elseif ($id_type_latrine) 
        {   $data = array();
            $tmp = $this->Attachement_latrineManager->findBytype_latrine($id_type_latrine);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $type_latrine = array();
                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ponderation_latrine'] = $value->ponderation_latrine;
                    $data[$key]['type_latrine'] = $type_latrine;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $attachement_latrine = $this->Attachement_latrineManager->findById($id);
            $type_latrine = $this->Type_latrineManager->findById($attachement_latrine->id_type_latrine);
            $data['id'] = $attachement_latrine->id;
            $data['libelle'] = $attachement_latrine->libelle;
            $data['description'] = $attachement_latrine->description;
            $data['ponderation_latrine'] = $attachement_latrine->ponderation_latrine;
            $data['type_latrine'] = $type_latrine;
        } 
        else 
        {
            $menu = $this->Attachement_latrineManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ponderation_latrine'] = $value->ponderation_latrine;
                    $data[$key]['type_latrine'] = $type_latrine;
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
                    'ponderation_latrine' => $this->post('ponderation_latrine'),
                    'id_type_latrine' => $this->post('id_type_latrine')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Attachement_latrineManager->add($data);
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
                    'ponderation_latrine' => $this->post('ponderation_latrine'),
                    'id_type_latrine' => $this->post('id_type_latrine')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Attachement_latrineManager->update($id, $data);
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
            $delete = $this->Attachement_latrineManager->delete($id);         
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
