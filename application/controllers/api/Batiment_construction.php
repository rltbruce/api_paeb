<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Batiment_construction extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('convention_cisco_feffi_detail_model', 'Convention_cisco_feffi_detailManager');
        $this->load->model('batiment_ouvrage_model', 'Batiment_ouvrageManager');
        $this->load->model('attachement_batiment_model', 'Attachement_batimentManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_detail = $this->get('id_convention_detail');

        if ($id_convention_detail)
        {
            $batiment_construction = $this->Batiment_constructionManager->findAllByDetail($id_convention_detail );
            if ($batiment_construction) 
            {
                foreach ($batiment_construction as $key => $value) 
                {                     
                    $convention_detail = $this->Convention_cisco_feffi_detailManager->findById($value->id_convention_detail);
                    $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($value->id_batiment_ouvrage);
                    $attachement_batiment = $this->Attachement_batimentManager->findById($value->id_attachement_batiment);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['batiment_ouvrage'] = $batiment_ouvrage;
                    $data[$key]['attachement_batiment'] = $attachement_batiment;
                    $data[$key]['convention_detail'] = $convention_detail;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $batiment_construction = $this->Batiment_constructionManager->findById($id);
            $convention_detail = $this->Convention_cisco_feffi_detailManager->findById($batiment_construction->id_convention_detail);
            $attachement_batiment = $this->Attachement_batimentManager->findById($batiment_construction->id_attachement_batiment);
            $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($batiment_construction->id_batiment_ouvrage);

            $data['id'] = $batiment_construction->id;
            $data['attachement_batiment'] = $attachement_batiment;
            $data['convention_detail'] = $convention_detail;
            $data['batiment_ouvrage'] = $batiment_ouvrage;
        } 
        else 
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data = array();
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->$id_convention_entete);

                    $attachement_batiment = $this->Attachement_batimentManager->findById($value->id_attachement_batiment);
                    $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($value->id_batiment_ouvrage);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['attachement_batiment'] = $attachement_batiment;
                    $data[$key]['convention_detail'] = $convention_detail;
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
        $menu = $this->post('menu') ;
        $id_convention_detail = $this->post('id_convention_detail');
        if ($menu=='supressionBydetail')
        {
            if (!$id_convention_detail) {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->Batiment_constructionManager->supressionBydetail($id_convention_detail);         
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
                    'id_batiment_ouvrage' => $this->post('id_batiment_ouvrage'),
                    'id_attachement_batiment' => $this->post('id_attachement_batiment'),
                    'id_convention_detail' => $this->post('id_convention_detail')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Batiment_constructionManager->add($data);
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
                    'id_batiment_ouvrage' => $this->post('id_batiment_ouvrage'),
                    'id_attachement_batiment' => $this->post('id_attachement_batiment'),
                    'id_convention_detail' => $this->post('id_convention_detail')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Batiment_constructionManager->update($id, $data);
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
            $delete = $this->Batiment_constructionManager->delete($id);         
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
