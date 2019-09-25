<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Association extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('association_model', 'AssociationManager');
        $this->load->model('cisco_model', 'CiscoManager');
        $this->load->model('commune_model', 'CommuneManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_commune = $this->get('id_commune');
            
        if ($id_commune) 
        {   $data = array();
            $tmp = $this->CiscoManager->findBycommune($id_commune);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $commune = array();
                    $cisco = array();
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['cisco'] = $cisco;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $association = $this->AssociationManager->findById($id);
            $commune = $this->CommuneManager->findById($association->id_commune);
            $cisco = $this->CiscoManager->findById($association->id_cisco);
            $data['id'] = $association->id;
            $data['code'] = $association->code;
            $data['description'] = $association->description;
            $data['commune'] = $commune;
            $data['cisco'] = $cisco;
        } 
        else 
        {
            $menu = $this->AssociationManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $commune = array();
                    $cisco = array();
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['cisco'] = $cisco;
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
                    'code' => $this->post('code'),
                    'description' => $this->post('description'),
                    'id_commune' => $this->post('id_commune'),
                    'id_cisco' => $this->post('id_cisco')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->AssociationManager->add($data);
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
                    'code' => $this->post('code'),
                    'description' => $this->post('description'),
                    'id_commune' => $this->post('id_commune'),
                    'id_cisco' => $this->post('id_cisco')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->AssociationManager->update($id, $data);
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
            $delete = $this->AssociationManager->delete($id);         
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
