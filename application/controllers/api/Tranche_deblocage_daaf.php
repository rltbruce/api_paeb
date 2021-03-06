<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Tranche_deblocage_daaf extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tranche_deblocage_daaf_model', 'Tranche_deblocage_daafManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $pourcentage = $this->get('pourcentage');
            
        if ($pourcentage) 
        {   $data = array();
            $tmp = $this->Tranche_deblocage_daafManager->findBydistrict($pourcentage);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['periode'] = $value->periode;
                    $data[$key]['pourcentage'] = $value->pourcentage;
                    $data[$key]['description'] = $value->description;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($id);
            $data['id'] = $tranche_deblocage_daaf->id;
            $data['code'] = $tranche_deblocage_daaf->code;
            $data['libelle'] = $tranche_deblocage_daaf->libelle;
            $data['periode'] = $tranche_deblocage_daaf->periode;
            $data['pourcentage'] = $tranche_deblocage_daaf->pourcentage;
            $data['description'] = $tranche_deblocage_daaf->description;
        } 
        else 
        {
            $menu = $this->Tranche_deblocage_daafManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['periode'] = $value->periode;                    
                    $data[$key]['pourcentage'] = $value->pourcentage;
                    $data[$key]['description'] = $value->description;
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
                    'code' => $this->post('code'),
                    'periode' => $this->post('periode'),
                    'pourcentage' => $this->post('pourcentage'),
                    'description' => $this->post('description')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Tranche_deblocage_daafManager->add($data);
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
                    'libelle' => $this->post('libelle'),
                    'periode' => $this->post('periode'),
                    'pourcentage' => $this->post('pourcentage'),
                    'description' => $this->post('description')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Tranche_deblocage_daafManager->update($id, $data);
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
            $delete = $this->Tranche_deblocage_daafManager->delete($id);         
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
