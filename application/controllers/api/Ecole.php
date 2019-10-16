<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Ecole extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ecole_model', 'EcoleManager');
        $this->load->model('commune_model', 'CommuneManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_commune = $this->get('id_commune');
            
        if ($id_commune) 
        {   $data = array();
            $tmp = $this->EcoleManager->findBycommune($id_commune);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $commune = array();
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['ponderation'] = $value->ponderation;
                    $data[$key]['commune'] = $commune;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $ecole = $this->EcoleManager->findById($id);
            $commune = $this->CommuneManager->findById($ecole->id_commune);
            $data['id'] = $ecole->id;
            $data['code'] = $ecole->code;
            $data['lieu'] = $ecole->lieu;
            $data['description'] = $ecole->description;
            $data['latitude'] = $ecole->latitude;
            $data['longitude'] = $ecole->longitude;
            $data['altitude'] = $ecole->altitude;
            $data['ponderation'] = $ecole->ponderation;
            $data['commune'] = $commune;
        } 
        else 
        {
            $menu = $this->EcoleManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $commune = array();
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['ponderation'] = $value->ponderation;
                    $data[$key]['commune'] = $commune;
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
                    'lieu' => $this->post('lieu'),
                    'description' => $this->post('description'),
                    'latitude' => $this->post('latitude'),
                    'longitude' => $this->post('longitude'),
                    'altitude' => $this->post('altitude'),
                    'ponderation' => $this->post('ponderation'),
                    'id_commune' => $this->post('id_commune')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->EcoleManager->add($data);
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
                    'lieu' => $this->post('lieu'),
                    'description' => $this->post('description'),
                    'latitude' => $this->post('latitude'),
                    'longitude' => $this->post('longitude'),
                    'altitude' => $this->post('altitude'),
                    'ponderation' => $this->post('ponderation'),
                    'id_commune' => $this->post('id_commune')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->EcoleManager->update($id, $data);
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
            $delete = $this->EcoleManager->delete($id);         
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
