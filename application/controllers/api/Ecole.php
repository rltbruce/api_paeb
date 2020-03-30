<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Ecole extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ecole_model', 'EcoleManager');
        $this->load->model('fokontany_model', 'FokontanyManager');
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
        $this->load->model('cisco_model', 'CiscoManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_fokontany = $this->get('id_fokontany');
        $menus = $this->get('menus');
        $id_cisco = $this->get('id_cisco');
        $id_commune = $this->get('id_commune');
            
        if ($menus=='getecoleBycommune') 
        {   $data = array();
            $tmp = $this->EcoleManager->findBycommune($id_commune);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                }
            }
        }
        elseif ($menus=='getecoleBycisco') 
        {   $data = array();
            $tmp = $this->EcoleManager->findBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $fokontany = array();
                    $fokontany = $this->FokontanyManager->findById($value->id_fokontany);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['fokontany'] = $fokontany;
                }
            }
        }
        elseif ($id_fokontany) 
        {   $data = array();
            $tmp = $this->EcoleManager->findByfokontany($id_fokontany);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $fokontany = array();
                    $fokontany = $this->FokontanyManager->findById($value->id_fokontany);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['fokontany'] = $fokontany;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $ecole = $this->EcoleManager->findById($id);
            $fokontany = $this->FokontanyManager->findById($ecole->id_fokontany);
            $zone_subvention = $this->Zone_subventionManager->findById($ecole->id_zone_subvention);
            $acces_zone = $this->Acces_zoneManager->findById($ecole->id_acces_zone);
            $data['id'] = $ecole->id;
            $data['code'] = $ecole->code;
            $data['lieu'] = $ecole->lieu;
            $data['description'] = $ecole->description;
            $data['latitude'] = $ecole->latitude;
            $data['longitude'] = $ecole->longitude;
            $data['altitude'] = $ecole->altitude;
            $data['zone_subvention'] = $zone_subvention;
            $data['acces_zone'] = $acces_zone;
            $data['fokontany'] = $fokontany;
        } 
        else 
        {
            $menu = $this->EcoleManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $fokontany = array();
                    $fokontany = $this->FokontanyManager->findById($value->id_fokontany);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['fokontany'] = $fokontany;
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
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'id_acces_zone' => $this->post('id_acces_zone'),
                    'id_fokontany' => $this->post('id_fokontany')
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
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'id_acces_zone' => $this->post('id_acces_zone'),
                    'id_fokontany' => $this->post('id_fokontany')
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
