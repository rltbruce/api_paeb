<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Divers_attachement_latrine extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('divers_attachement_latrine_model', 'Divers_attachement_latrineManager');
        $this->load->model('type_latrine_model', 'Type_latrineManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_type_latrine = $this->get('id_type_latrine');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');

        if ($menu == 'getdivers_attachement_latrine_prevu') 
        {   $data = array();
            $tmp = $this->Divers_attachement_latrineManager->findattachementBycontrat($id_contrat_prestataire,$id_type_latrine);
           
            if ($tmp) 
            {
                $data = $tmp;
            }
        }
        elseif ($menu=='getattachementBytype_latrine') 
        {   $data = array();
            $tmp = $this->Divers_attachement_latrineManager->findBytype_latrine($id_type_latrine);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $type_latrine = array();
                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['type_latrine'] = $type_latrine;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $divers_attachement_latrine = $this->Divers_attachement_latrineManager->findById($id);
            $type_latrine = $this->Type_latrineManager->findById($divers_attachement_latrine->id_type_latrine);
            $data['id'] = $divers_attachement_latrine->id;
            $data['libelle'] = $divers_attachement_latrine->libelle;
            $data['description'] = $divers_attachement_latrine->description;
            $data['type_latrine'] = $type_latrine;
        } 
        else 
        {
            $menu = $this->Divers_attachement_latrineManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
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
                    'montant_prevu' => $this->post('montant_prevu'),
                    'id_type_latrine' => $this->post('id_type_latrine')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Divers_attachement_latrineManager->add($data);
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
                    'montant_prevu' => $this->post('montant_prevu'),
                    'id_type_latrine' => $this->post('id_type_latrine')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Divers_attachement_latrineManager->update($id, $data);
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
            $delete = $this->Divers_attachement_latrineManager->delete($id);         
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
