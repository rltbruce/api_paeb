<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Ouvrage extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ouvrage_model', 'OuvrageManager');
        $this->load->model('categorie_ouvrage_model', 'Categorie_ouvrageManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_categorie_ouvrage = $this->get('id_categorie_ouvrage');    
        if ($id_categorie_ouvrage) 
        {   $data = array();
            $tmp = $this->OuvrageManager->findBycategorie_ouvrage($id_categorie_ouvrage);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $categorie_ouvrage = array();
                    $categorie_ouvrage = $this->Categorie_ouvrageManager->findById($value->id_categorie_ouvrage);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['categorie_ouvrage'] = $categorie_ouvrage;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $ouvrage = $this->OuvrageManager->findById($id);
            $categorie_ouvrage = $this->Categorie_ouvrageManager->findById($ouvrage->id_categorie_ouvrage);
            $data['id'] = $ouvrage->id;
            $data['libelle'] = $ouvrage->libelle;
            $data['description'] = $ouvrage->description;
            $data['categorie_ouvrage'] = $categorie_ouvrage;
        } 
        else 
        {
            $menu = $this->OuvrageManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {   $categorie_ouvrage = $this->Categorie_ouvrageManager->findById($value->id_categorie_ouvrage);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['categorie_ouvrage'] = $categorie_ouvrage;
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
                    'id_categorie_ouvrage' => $this->post('id_categorie_ouvrage')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->OuvrageManager->add($data);
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
                    'id_categorie_ouvrage' => $this->post('id_categorie_ouvrage')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->OuvrageManager->update($id, $data);
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
            $delete = $this->OuvrageManager->delete($id);         
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
