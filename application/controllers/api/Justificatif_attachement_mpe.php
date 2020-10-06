<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Justificatif_attachement_mpe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('justificatif_attachement_mpe_model', 'Justificatif_attachement_mpeManager');
       $this->load->model('attachement_travaux_model', 'Attachement_travauxManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_attachement_travaux = $this->get('id_attachement_travaux');
            
        if ($id_attachement_travaux)
        {
            $tmp = $this->Justificatif_attachement_mpeManager->findAllBydemande($id_attachement_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $attachement_travaux= array();
                    $attachement_travaux = $this->Attachement_travauxManager->findById($value->id_attachement_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['attachement_travaux'] = $attachement_travaux;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $justificatif_attachement_mpe = $this->Justificatif_attachement_mpeManager->findById($id);
            $attachement_travaux = $this->Attachement_travauxManager->findById($justificatif_attachement_mpe->id_attachement_travaux);
            $data['id'] = $justificatif_attachement_mpe->id;
            $data['description'] = $justificatif_attachement_mpe->description;
            $data['fichier'] = $justificatif_attachement_mpe->fichier;
            //$data['date'] = $justificatif_attachement_mpe->date;
            $data['attachement_travaux'] = $attachement_travaux;
        } 
        else 
        {
            $menu = $this->Justificatif_attachement_mpeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $attachement_travaux= array();
                    $attachement_travaux = $this->Attachement_travauxManager->findById($value->id_attachement_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['attachement_travaux'] = $attachement_travaux;
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
                    'description' => $this->post('description'),
                    'fichier' => $this->post('fichier'),
                    'id_attachement_travaux' => $this->post('id_attachement_travaux')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Justificatif_attachement_mpeManager->add($data);
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
                    'description' => $this->post('description'),
                    'fichier' => $this->post('fichier'),
                    'id_attachement_travaux' => $this->post('id_attachement_travaux')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Justificatif_attachement_mpeManager->update($id, $data);
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
            $delete = $this->Justificatif_attachement_mpeManager->delete($id);         
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
