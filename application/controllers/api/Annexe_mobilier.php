<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Annexe_mobilier extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('annexe_mobilier_model', 'Annexe_mobilierManager');
        $this->load->model('batiment_ouvrage_model', 'Batiment_ouvrageManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_batiment_ouvrage = $this->get('id_batiment_ouvrage');
            
        if ($id_batiment_ouvrage) 
        {   $data = array();
            $tmp = $this->Annexe_mobilierManager->findBybatiment_ouvrage($id_batiment_ouvrage);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $batiment_ouvrage = array();
                    $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($value->id_batiment_ouvrage);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['nbr_banc'] = $value->nbr_banc;
                    $data[$key]['nbr_table_maitre'] = $value->nbr_table_maitre;
                    $data[$key]['nbr_table_maitre'] = $value->nbr_table_maitre;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['batiment_ouvrage'] = $batiment_ouvrage;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $annexe_mobilier = $this->Annexe_mobilierManager->findById($id);
            $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($annexe_mobilier->id_batiment_ouvrage);
            $data['id'] = $annexe_mobilier->id;
            $data['libelle'] = $annexe_mobilier->libelle;
            $data['description'] = $annexe_mobilier->description;
            $data['nbr_banc'] = $annexe_mobilier->nbr_banc;
            $data['nbr_table_maitre'] = $annexe_mobilier->nbr_table_maitre;
            $data['nbr_table_maitre'] = $annexe_mobilier->nbr_table_maitre;
            $data['cout_mobilier'] = $annexe_mobilier->cout_mobilier;
            $data['batiment_ouvrage'] = $batiment_ouvrage;
        } 
        else 
        {
            $menu = $this->Annexe_mobilierManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($value->id_batiment_ouvrage);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['nbr_banc'] = $value->nbr_banc;
                    $data[$key]['nbr_table_maitre'] = $value->nbr_table_maitre;
                    $data[$key]['nbr_table_maitre'] = $value->nbr_table_maitre;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['batiment_ouvrage'] = $batiment_ouvrage;
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'nbr_banc' => $this->post('nbr_banc'),
                    'nbr_table_maitre' => $this->post('nbr_table_maitre'),
                    'nbr_banc' => $this->post('nbr_banc'),
                    'nbr_chais_maitre' => $this->post('nbr_chais_maitre'),
                    'cout_mobilier' => $this->post('cout_mobilier'),
                    'id_batiment_ouvrage' => $this->post('id_batiment_ouvrage')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Annexe_mobilierManager->add($data);
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
                    'description' => $this->post('description'),
                    'nbr_banc' => $this->post('nbr_banc'),
                    'nbr_table_maitre' => $this->post('nbr_table_maitre'),
                    'nbr_banc' => $this->post('nbr_banc'),
                    'nbr_chais_maitre' => $this->post('nbr_chais_maitre'),
                    'cout_mobilier' => $this->post('cout_mobilier'),
                    'id_batiment_ouvrage' => $this->post('id_batiment_ouvrage')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Annexe_mobilierManager->update($id, $data);
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
            $delete = $this->Annexe_mobilierManager->delete($id);         
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
