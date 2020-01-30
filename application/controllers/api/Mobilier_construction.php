<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Mobilier_construction extends REST_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('mobilier_construction_model', 'Mobilier_constructionManager');
        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('annexe_mobilier_model', 'Annexe_mobilierManager');
        $this->load->model('attachement_mobilier_model', 'Attachement_mobilierManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_batiment_construction = $this->get('id_batiment_construction');

        if ($id_batiment_construction)
        {
            $mobilier_construction = $this->Mobilier_constructionManager->findAllByBatiment($id_batiment_construction );
            if ($mobilier_construction) 
            {
                foreach ($mobilier_construction as $key => $value) 
                {                     
                    $batiment_construction = $this->Batiment_constructionManager->findById($value->id_batiment_construction);
                    $annexe_mobilier = $this->Annexe_mobilierManager->findById($value->id_annexe_mobilier);
                    $attachement_mobilier = $this->Attachement_mobilierManager->findById($value->id_attachement_mobilier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['annexe_mobilier'] = $annexe_mobilier;
                    $data[$key]['attachement_mobilier'] = $attachement_mobilier;
                    $data[$key]['batiment_construction'] = $batiment_construction;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $mobilier_construction = $this->Mobilier_constructionManager->findById($id);

            $batiment_construction = $this->Batiment_constructionManager->findById($mobilier_construction->id_batiment_construction);

            $attachement_mobilier = $this->Attachement_mobilierManager->findById($mobilier_construction->id_attachement_mobilier);

            $data['id'] = $batiment_construction->id;
            $data['attachement_mobilier'] = $attachement_mobilier;
            $data['mobilier_construction'] = $mobilier_construction;
            $data['batiment_construction'] = $batiment_construction;
        } 
        else 
        {
            $menu = $this->Mobilier_constructionManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data = array();
                    $batiment_construction = $this->Convention_cisco_feffi_detailManager->findById($value->id_batiment_construction);

                    $annexe_mobilier = $this->Annexe_mobilierManager->findById($value->id_annexe_mobilier);

                    $attachement_mobilier = $this->Attachement_mobilierManager->findById($value->id_attachement_mobilier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['annexe_mobilier'] = $annexe_mobilier;
                    $data[$key]['attachement_mobilier'] = $attachement_mobilier;
                    $data[$key]['batiment_construction'] = $batiment_construction;
                    
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
        $menu = $this->post('menu') ;
        $id_mobilier_construction = $this->post('id_mobilier_construction');
        if ($menu=='supressionBydetail')
        {
            if (!$id_mobilier_construction) {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->Mobilier_constructionManager->supressionBydetail($id_mobilier_construction);         
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
        elseif ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'id_annexe_mobilier' => $this->post('id_annexe_mobilier'),
                    'id_attachement_mobilier' => $this->post('id_attachement_mobilier'),
                    'id_batiment_construction' => $this->post('id_batiment_construction')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Mobilier_constructionManager->add($data);
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
                    'id_annexe_mobilier' => $this->post('id_annexe_mobilier'),
                    'id_attachement_mobilier' => $this->post('id_attachement_mobilier'),
                    'id_batiment_construction' => $this->post('id_batiment_construction')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Mobilier_constructionManager->update($id, $data);
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
            $delete = $this->Mobilier_constructionManager->delete($id);         
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
