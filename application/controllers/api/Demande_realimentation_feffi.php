<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_realimentation_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_realimentation_feffi_model', 'Demande_realimentation_feffiManager');
        $this->load->model('convention_model', 'ConventionManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention = $this->get('id_convention');
        $menu = $this->get('menu');

        if ($menu=='getdemande_realimentation_convention')
        {
            $menu = $this->Demande_realimentation_feffiManager->findByIdconvention($id_convention);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $convention= array();
                    $convention = $this->ConventionManager->findById($value->id_convention);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['convention'] = $convention;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($id);
            $convention = $this->ConventionManager->findById($demande_realimentation_feffi->id_convention);
            $data['id'] = $demande_realimentation_feffi->id;
            $data['libelle'] = $demande_realimentation_feffi->libelle;
            $data['description'] = $demande_realimentation_feffi->description;
            $data['date'] = $demande_realimentation_feffi->date;
            $data['convention'] = $convention;
        } 
        else 
        {
            $menu = $this->Demande_realimentation_feffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $convention= array();
                    $convention = $this->ConventionManager->findById($value->id_convention);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['convention'] = $convention;
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
                    'date' => $this->post('date'),
                    'id_convention' => $this->post('id_convention')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_realimentation_feffiManager->add($data);
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
                    'date' => $this->post('date'),
                    'id_convention' => $this->post('id_convention')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_realimentation_feffiManager->update($id, $data);
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
            $delete = $this->Demande_realimentation_feffiManager->delete($id);         
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
