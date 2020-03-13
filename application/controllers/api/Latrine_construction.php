<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Latrine_construction extends REST_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('latrine_construction_model', 'Latrine_constructionManager');
        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('type_latrine_model', 'Type_latrineManager');
        //$this->load->model('attachement_latrine_model', 'Attachement_latrineManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_batiment_construction = $this->get('id_batiment_construction');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $id_contrat_partenaire_relai = $this->get('id_contrat_partenaire_relai');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');

        $menu = $this->get('menu');

        if ($menu=='getlatrineByContrat_prestataire')
        {
            $latrine_construction = $this->Latrine_constructionManager->findAllByContrat_prestataire($id_contrat_prestataire );
            if ($latrine_construction) 
            {
                foreach ($latrine_construction as $key => $value) 
                {   
                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_latrine'] = $type_latrine;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    $data[$key]['nbr_latrine'] = $value->nbr_latrine;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getlatrineByContrat_partenaire_relai')
        {
            $latrine_construction = $this->Latrine_constructionManager->findAllByContrat_partenaire_relai($id_contrat_partenaire_relai );
            if ($latrine_construction) 
            {
                foreach ($latrine_construction as $key => $value) 
                {   
                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_latrine'] = $type_latrine;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    $data[$key]['nbr_latrine'] = $value->nbr_latrine;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getlatrineByContrat_bureau_etude')
        {
            $latrine_construction = $this->Latrine_constructionManager->findAllByContrat_bureau_etude($id_contrat_bureau_etude );
            if ($latrine_construction) 
            {
                foreach ($latrine_construction as $key => $value) 
                {   
                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_latrine'] = $type_latrine;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    $data[$key]['nbr_latrine'] = $value->nbr_latrine;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id_batiment_construction)
        {
            $latrine_construction = $this->Latrine_constructionManager->findAllByBatiment($id_batiment_construction );
            if ($latrine_construction) 
            {
                foreach ($latrine_construction as $key => $value) 
                {                     
                    $batiment_construction = $this->Batiment_constructionManager->findById($value->id_batiment_construction);
                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_latrine'] = $type_latrine;
                    $data[$key]['batiment_construction'] = $batiment_construction;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    $data[$key]['nbr_latrine'] = $value->nbr_latrine;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $latrine_construction = $this->Latrine_constructionManager->findById($id);

            $batiment_construction = $this->Batiment_constructionManager->findById($latrine_construction->id_batiment_construction);
            $type_latrine = $this->Type_latrineManager->findById($latrine_construction->id_type_latrine);

            $data['id'] = $batiment_construction->id;
            $data['batiment_construction'] = $batiment_construction;
            $data['type_latrine'] = $type_latrine;
            $data['cout_unitaire'] = $latrine_construction->cout_unitaire;
            $data['nbr_latrine'] = $latrine_construction->nbr_latrine;
        } 
        else 
        {
            $menu = $this->Latrine_constructionManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data = array();
                    $batiment_construction = $this->Convention_cisco_feffi_detailManager->findById($value->id_batiment_construction);

                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_latrine'] = $type_latrine;
                    $data[$key]['batiment_construction'] = $batiment_construction;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    $data[$key]['nbr_latrine'] = $value->nbr_latrine;
                    
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
       /* $id_latrine_construction = $this->post('id_latrine_construction');
        if ($menu=='supressionBydetail')
        {
            if (!$id_latrine_construction) {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->Latrine_constructionManager->supressionBydetail($id_latrine_construction);         
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
        else*/
            if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'id_type_latrine' => $this->post('id_type_latrine'),
                    'id_batiment_construction' => $this->post('id_batiment_construction'),
                    'nbr_latrine' => $this->post('nbr_latrine'),
                    'cout_unitaire' => $this->post('cout_unitaire')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Latrine_constructionManager->add($data);
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
                    'id_type_latrine' => $this->post('id_type_latrine'),
                    'id_batiment_construction' => $this->post('id_batiment_construction'),
                    'nbr_latrine' => $this->post('nbr_latrine'),
                    'cout_unitaire' => $this->post('cout_unitaire')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Latrine_constructionManager->update($id, $data);
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
            $delete = $this->Latrine_constructionManager->delete($id);         
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
