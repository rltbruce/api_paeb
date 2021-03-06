<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Cout_sousprojet_construction extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('cout_sousprojet_construction_model', 'Cout_sousprojet_constructionManager');
        $this->load->model('type_cout_sousprojet_model', 'Type_cout_sousprojetManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
            
        if ($id)
        {

            $tmp = $this->Cout_sousprojet_constructionManager->findById($id);

            if ($tmp) 
            {   
                $type_cout_sousprojet = $this->Type_cout_sousprojetManager->findById($tmp->id_type_cout_sousprojet);
                $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($tmp->id_convention_entete);
                
                $data['id'] = $tmp->id;
                $data['cout'] = $tmp->cout;
                $data['type_cout_sousprojet'] = $type_cout_sousprojet;
                $data['convention_entete'] = $convention_entete;
            }
            else
                $data = array();
        }
        elseif ($id_convention_entete) 
        {
            $tmp = $this->Cout_sousprojet_constructionManager->findAll_by_convention_detail($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    $type_cout_sousprojet = $this->Type_cout_sousprojetManager->findById($value->id_type_cout_sousprojet);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cout'] = $value->cout;
                    $data[$key]['type_cout_sousprojet'] = $type_cout_sousprojet;
                    $data[$key]['convention_entete'] = $convention_entete;
                }
              
            }
            else
                $data = array();
        }
        else 
        {
            $tmp = $this->Cout_sousprojet_constructionManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $type_cout_sousprojet = $this->Type_cout_sousprojetManager->findById($value->id_type_cout_sousprojet);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cout'] = $value->cout;
                    $data[$key]['type_cout_sousprojet'] = $type_cout_sousprojet;
                    $data[$key]['convention_entete'] = $convention_entete;

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
                    'cout' => $this->post('cout'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_type_cout_sousprojet' => $this->post('id_type_cout_sousprojet')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Cout_sousprojet_constructionManager->add($data);
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
                    'cout' => $this->post('cout'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_type_cout_sousprojet' => $this->post('id_type_cout_sousprojet')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_OK);
                }
                $update = $this->Cout_sousprojet_constructionManager->update($id, $data);
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
            $delete = $this->Cout_sousprojet_constructionManager->delete($id);         
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
