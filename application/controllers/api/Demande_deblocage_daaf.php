<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_deblocage_daaf extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_deblocage_daaf_model', 'Demande_deblocage_daafManager');
        $this->load->model('programmation_model', 'ProgrammationManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_programmation = $this->get('id_programmation');
            
        if ($id)
        {
            $data = array();
            $demande_deblocage_daaf = $this->Demande_deblocage_daafManager->findById($id);
            $programmation = $this->ProgrammationManager->findById($demande_deblocage_daaf->id_programmation);
            $data['id'] = $demande_deblocage_daaf->id;
            $data['code'] = $demande_deblocage_daaf->code;
            $data['description'] = $demande_deblocage_daaf->description;
            $data['date'] = $demande_deblocage_daaf->date;
            $data['programmation'] = $programmation;
        } 
        else 
        {
            $menu = $this->Demande_deblocage_daafManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $programmation= array();
                    $programmation = $this->ProgrammationManager->findById($value->id_programmation);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['programmation'] = $programmation;
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
                    'date' => $this->post('date'),
                    'id_programmation' => $this->post('id_programmation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_deblocage_daafManager->add($data);
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
                    'date' => $this->post('date'),
                    'id_programmation' => $this->post('id_programmation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_deblocage_daafManager->update($id, $data);
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
            $delete = $this->Demande_deblocage_daafManager->delete($id);         
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
