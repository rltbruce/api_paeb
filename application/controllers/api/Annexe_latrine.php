<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Annexe_latrine extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('annexe_latrine_model', 'Annexe_latrineManager');
        $this->load->model('batiment_ouvrage_model', 'Batiment_ouvrageManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_batiment_ouvrage = $this->get('id_batiment_ouvrage');
            
        if ($id_batiment_ouvrage) 
        {   $data = array();
            $tmp = $this->Annexe_latrineManager->findBybatiment_ouvrage($id_batiment_ouvrage);
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
                    $data[$key]['nbr_box_latrine'] = $value->nbr_box_latrine;
                    $data[$key]['nbr_point_eau'] = $value->nbr_point_eau;
                    $data[$key]['cout_latrine'] = $value->cout_latrine;
                    $data[$key]['batiment_ouvrage'] = $batiment_ouvrage;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $annexe_latrine = $this->Annexe_latrineManager->findById($id);
            $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($annexe_latrine->id_ouvrage);
            $data['id'] = $annexe_latrine->id;
            $data['code'] = $annexe_latrine->code;
            $data['libelle'] = $annexe_latrine->libelle;
            $data['description'] = $annexe_latrine->description;
            $data['nbr_box_latrine'] = $annexe_latrine->nbr_box_latrine;
            $data['nbr_point_eau'] = $annexe_latrine->nbr_point_eau;
            $data['cout_latrine'] = $annexe_latrine->cout_latrine;
            $data['batiment_ouvrage'] = $batiment_ouvrage;
        } 
        else 
        {
            $menu = $this->Annexe_latrineManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($value->id_batiment_ouvrage);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['nbr_box_latrine'] = $value->nbr_box_latrine;
                    $data[$key]['nbr_point_eau'] = $value->nbr_point_eau;
                    $data[$key]['cout_latrine'] = $value->cout_latrine;
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
                    'nbr_box_latrine' => $this->post('nbr_box_latrine'),
                    'nbr_point_eau' => $this->post('nbr_point_eau'),
                    'cout_latrine' => $this->post('cout_latrine'),
                    'id_batiment_ouvrage' => $this->post('id_batiment_ouvrage')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Annexe_latrineManager->add($data);
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
                    'nbr_box_latrine' => $this->post('nbr_box_latrine'),
                    'nbr_point_eau' => $this->post('nbr_point_eau'),
                    'cout_latrine' => $this->post('cout_latrine'),
                    'id_batiment_ouvrage' => $this->post('id_batiment_ouvrage')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Annexe_latrineManager->update($id, $data);
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
            $delete = $this->Annexe_latrineManager->delete($id);         
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
