<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Transfert_ufp extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transfert_ufp_model', 'Transfert_ufpManager');
        $this->load->model('programmation_model', 'ProgrammationManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_programmation = $this->get('id_programmation');
        $menu = $this->get('menu');
            
        if ($menu=='gettransfert_ufp_programme')
        {
            $tmp = $this->Transfert_ufpManager->findAllByprogramme($id_programmation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $programmation= array();
                    $programmation = $this->ProgrammationManager->findById($value->id_programmation);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['num_facture'] = $value->num_facture;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['programmation'] = $programmation;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $transfert_ufp = $this->Transfert_ufpManager->findById($id);
            $programmation = $this->ProgrammationManager->findById($transfert_ufp->id_programmation);
            $data['id'] = $transfert_ufp->id;
            $data['code'] = $transfert_ufp->code;
            $data['description'] = $transfert_ufp->description;
            $data['montant'] = $transfert_ufp->montant;
            $data['num_facture'] = $transfert_ufp->num_facture;
            $data['date'] = $transfert_ufp->date;
            $data['programmation'] = $programmation;
        } 
        else 
        {
            $menu = $this->Transfert_ufpManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $programmation= array();
                    $programmation = $this->ProgrammationManager->findById($value->id_programmation);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['num_facture'] = $value->num_facture;
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
                    'montant' => $this->post('montant'),
                    'num_facture' => $this->post('num_facture'),
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
                $dataId = $this->Transfert_ufpManager->add($data);
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
                    'montant' => $this->post('montant'),
                    'num_facture' => $this->post('num_facture'),
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
                $update = $this->Transfert_ufpManager->update($id, $data);
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
            $delete = $this->Transfert_ufpManager->delete($id);         
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
