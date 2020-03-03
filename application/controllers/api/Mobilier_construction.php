<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Mobilier_construction extends REST_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('mobilier_construction_model', 'Mobilier_constructionManager');
        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('type_mobilier_model', 'Type_mobilierManager');
        //$this->load->model('attachement_mobilier_model', 'Attachement_mobilierManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_batiment_construction = $this->get('id_batiment_construction');

        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');

        $menu = $this->get('menu');

        if ($menu=='getmobilierByContrat_bureau_etude')
        {
            $mobilier_construction = $this->Mobilier_constructionManager->findAllByContrat_bureau_etude($id_contrat_bureau_etude );
            if ($mobilier_construction) 
            {
                foreach ($mobilier_construction as $key => $value) 
                {   
                    $type_mobilier = $this->Type_mobilierManager->findById($value->id_type_mobilier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_mobilier'] = $type_mobilier;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    $data[$key]['nbr_mobilier'] = $value->nbr_mobilier;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id_batiment_construction)
        {
            $mobilier_construction = $this->Mobilier_constructionManager->findAllByBatiment($id_batiment_construction );
            if ($mobilier_construction) 
            {
                foreach ($mobilier_construction as $key => $value) 
                {                     
                    $batiment_construction = $this->Batiment_constructionManager->findById($value->id_batiment_construction);
                    $type_mobilier = $this->Type_mobilierManager->findById($value->id_type_mobilier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_mobilier'] = $type_mobilier;
                    $data[$key]['batiment_construction'] = $batiment_construction;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    $data[$key]['nbr_mobilier'] = $value->nbr_mobilier;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $mobilier_construction = $this->Mobilier_constructionManager->findById($id);

            $batiment_construction = $this->Batiment_constructionManager->findById($mobilier_construction->id_batiment_construction);
            $type_mobilier = $this->Type_mobilierManager->findById($mobilier_construction->id_type_mobilier);

            $data['id'] = $batiment_construction->id;
            $data['mobilier_construction'] = $mobilier_construction;
            $data['batiment_construction'] = $batiment_construction;
            $data['cout_unitaire'] = $mobilier_construction->cout_unitaire;
            $data['nbr_mobilier'] = $mobilier_construction->nbr_mobilier;
        } 
        else 
        {
            $menu = $this->Mobilier_constructionManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data = array();
                    $batiment_construction = $this->Convention_cisco_feffi_detailManager->findById($value->id_batiment_construction);

                    $type_mobilier = $this->Type_mobilierManager->findById($value->id_type_mobilier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_mobilier'] = $type_mobilier;
                    $data[$key]['batiment_construction'] = $batiment_construction;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    $data[$key]['nbr_mobilier'] = $value->nbr_mobilier;
                    
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
        $menu = $this->post('menu') ;
        $id_mobilier_construction = $this->post('id_mobilier_construction');
        if ($menu=='supressionBydetail')
        {
            if (!$id_mobilier_construction) {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->Mobilier_constructionManager->supressionBydetail($id_mobilier_construction);         
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
        elseif ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'id_type_mobilier' => $this->post('id_type_mobilier'),
                    'id_batiment_construction' => $this->post('id_batiment_construction'),
                    'nbr_mobilier' => $this->post('nbr_mobilier'),
                    'cout_unitaire' => $this->post('cout_unitaire')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Mobilier_constructionManager->add($data);
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
                    'id_type_mobilier' => $this->post('id_type_mobilier'),
                    'id_batiment_construction' => $this->post('id_batiment_construction'),
                    'nbr_mobilier' => $this->post('nbr_mobilier'),
                    'cout_unitaire' => $this->post('cout_unitaire')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Mobilier_constructionManager->update($id, $data);
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
            $delete = $this->Mobilier_constructionManager->delete($id);         
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
