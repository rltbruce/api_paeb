<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('ecole_model', 'EcoleManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_ecole = $this->get('id_ecole');
            
        if ($id_ecole) 
        {   $data = array();
            $tmp = $this->AssociationManager->findByecole($id_ecole);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = array();
                    $cisco = array();
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['denomination'] = $value->denomination;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ecole'] = $ecole;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $feffi = $this->FeffiManager->findById($id);
            $ecole = $this->EcoleManager->findById($feffi->id_ecole);
            $data['id'] = $feffi->id;
            $data['denomination'] = $feffi->denomination;
            $data['description'] = $feffi->description;
            $data['ecole'] = $ecole;
        } 
        else 
        {
            $menu = $this->FeffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $ecole = array();
                    $cisco = array();
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['denomination'] = $value->denomination;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ecole'] = $ecole;
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
                    'denomination' => $this->post('denomination'),
                    'description' => $this->post('description'),
                    'id_ecole' => $this->post('id_ecole')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->FeffiManager->add($data);
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
                    'denomination' => $this->post('denomination'),
                    'description' => $this->post('description'),
                    'id_ecole' => $this->post('id_ecole')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->FeffiManager->update($id, $data);
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
            $delete = $this->FeffiManager->delete($id);         
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
