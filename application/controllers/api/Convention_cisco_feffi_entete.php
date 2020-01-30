<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention_cisco_feffi_entete extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('cisco_model', 'CiscoManager');
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('convention_daff_ufp_model', 'Convention_daff_ufpManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');       
        $menu = $this->get('menu');
        $id_convention_ufpdaaf = $this->get('id_convention_ufpdaaf');

        if ($menu=='getconventionvalide')
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAllValide();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['numero_convention'] = $value->numero_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['date_signature'] = $value->date_signature;                    
                    $data[$key]['financement'] = $value->financement;
                    $data[$key]['delai'] = $value->delai;

                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventioninvalide')
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAllInvalide();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['numero_convention'] = $value->numero_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['date_signature'] = $value->date_signature;                    
                    $data[$key]['financement'] = $value->financement;
                    $data[$key]['delai'] = $value->delai;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id_convention_ufpdaaf)
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAllByufpdaaf($id_convention_ufpdaaf);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['numero_convention'] = $value->numero_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['date_signature'] = $value->date_signature;                    
                    $data[$key]['financement'] = $value->financement;
                    $data[$key]['delai'] = $value->delai;
                    if($value->id_convention_ufpdaaf)
                    {
                      $convention_daff_ufp = $this->Convention_daff_ufpManager->findById($value->id_convention_ufpdaaf);
                      $data[$key]['convention_daff_ufp'] = $convention_daff_ufp;

                    }
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $menu = $this->Convention_cisco_feffi_enteteManager->findByIdObjet($id);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['numero_convention'] = $value->numero_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['date_signature'] = $value->date_signature;                    
                    $data[$key]['financement'] = $value->financement;
                    $data[$key]['delai'] = $value->delai;
                }
            } 
                else
                    $data = array();
        } 
        else 
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['numero_convention'] = $value->numero_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['date_signature'] = $value->date_signature;                    
                    $data[$key]['financement'] = $value->financement;
                    $data[$key]['delai'] = $value->delai;
                    
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
                    'numero_convention' => $this->post('numero_convention'),
                    'objet' => $this->post('objet'),
                    'id_cisco' => $this->post('id_cisco'),
                    'id_feffi' => $this->post('id_feffi'),
                    'financement' => $this->post('financement'),
                    'date_signature' => $this->post('date_signature'),
                    'delai' => $this->post('delai'),
                    'validation' => $this->post('validation'),
                    'id_convention_ufpdaaf' => $this->post('id_convention_ufpdaaf')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Convention_cisco_feffi_enteteManager->add($data);
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
                    'numero_convention' => $this->post('numero_convention'),
                    'objet' => $this->post('objet'),
                    'id_cisco' => $this->post('id_cisco'),
                    'id_feffi' => $this->post('id_feffi'),
                    'financement' => $this->post('financement'),
                    'date_signature' => $this->post('date_signature'),
                    'delai' => $this->post('delai'),
                    'validation' => $this->post('validation'),
                    'id_convention_ufpdaaf' => $this->post('id_convention_ufpdaaf')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Convention_cisco_feffi_enteteManager->update($id, $data);
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
            $delete = $this->Convention_cisco_feffi_enteteManager->delete($id);         
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