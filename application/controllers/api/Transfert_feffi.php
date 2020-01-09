<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Transfert_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transfert_feffi_model', 'Transfert_feffiManager');
        $this->load->model('convention_model', 'ConventionManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention = $this->get('id_convention');
        $menu = $this->get('menu');
            
        if ($menu=='gettransfert_feffi_programme')
        {
            $tmp = $this->Transfert_feffiManager->findAllByprogramme($id_convention);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $convention= array();
                    $convention = $this->ConventionManager->findById($value->id_convention);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['num_facture'] = $value->num_facture;
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
            $transfert_feffi = $this->Transfert_feffiManager->findById($id);
            $convention = $this->ConventionManager->findById($transfert_feffi->id_convention);
            $data['id'] = $transfert_feffi->id;
            $data['code'] = $transfert_feffi->code;
            $data['description'] = $transfert_feffi->description;
            $data['montant'] = $transfert_feffi->montant;
            $data['num_facture'] = $transfert_feffi->num_facture;
            $data['date'] = $transfert_feffi->date;
            $data['convention'] = $convention;
        } 
        else 
        {
            $menu = $this->Transfert_feffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $convention= array();
                    $convention = $this->ConventionManager->findById($value->id_convention);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['num_facture'] = $value->num_facture;
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
                    'code' => $this->post('code'),
                    'description' => $this->post('description'),
                    'montant' => $this->post('montant'),
                    'num_facture' => $this->post('num_facture'),
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
                $dataId = $this->Transfert_feffiManager->add($data);
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
                    'id_convention' => $this->post('id_convention')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Transfert_feffiManager->update($id, $data);
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
            $delete = $this->Transfert_feffiManager->delete($id);         
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
