<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Divers_attachement_batiment extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('divers_attachement_batiment_model', 'Divers_attachement_batimentManager');
        $this->load->model('type_batiment_model', 'Type_batimentManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_type_batiment = $this->get('id_type_batiment');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');

        if ($menu == 'getdivers_attachement_batiment_prevu') 
        {   $data = array();
            $tmp = $this->Divers_attachement_batimentManager->findattachementBycontrat($id_contrat_prestataire,$id_type_batiment);
           
            if ($tmp) 
            {
                $data = $tmp;
            }
        }
        elseif ($menu=='getattachementBytype_batiment') 
        {   $data = array();
            $tmp = $this->Divers_attachement_batimentManager->findBytype_batiment($id_type_batiment);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $type_batiment = array();
                    $type_batiment = $this->Type_batimentManager->findById($value->id_type_batiment);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['type_batiment'] = $type_batiment;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $divers_attachement_batiment = $this->Divers_attachement_batimentManager->findById($id);
            $type_batiment = $this->Type_batimentManager->findById($divers_attachement_batiment->id_type_batiment);
            $data['id'] = $divers_attachement_batiment->id;
            $data['libelle'] = $divers_attachement_batiment->libelle;
            $data['description'] = $divers_attachement_batiment->description;
            $data['type_batiment'] = $type_batiment;
        } 
        else 
        {
            $menu = $this->Divers_attachement_batimentManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $type_batiment = $this->Type_batimentManager->findById($value->id_type_batiment);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['type_batiment'] = $type_batiment;
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
                    'id_type_batiment' => $this->post('id_type_batiment')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Divers_attachement_batimentManager->add($data);
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
                    'id_type_batiment' => $this->post('id_type_batiment')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Divers_attachement_batimentManager->update($id, $data);
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
            $delete = $this->Divers_attachement_batimentManager->delete($id);         
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
