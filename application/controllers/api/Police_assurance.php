<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Police_assurance extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('police_assurance_model', 'Police_assuranceManager');
       $this->load->model('contrat_be_model', 'Contrat_beManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $validation = $this->get('validation');
        $id_cisco = $this->get('id_cisco');
        $menu = $this->get('menu');
            
       if ($menu == "getpoliceBycontrat")
        {
            $tmp = $this->Police_assuranceManager->findpoliceBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date_expiration'] = $value->date_expiration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getpolicevalideBycontrat")
        {
            $tmp = $this->Police_assuranceManager->findpolicevalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date_expiration'] = $value->date_expiration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getpoliceinvalideBycontrat")
        {
            $tmp = $this->Police_assuranceManager->findpoliceinvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date_expiration'] = $value->date_expiration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }
       /* if ($menu == "getpoliceBycontrat")
        {
            $tmp = $this->Police_assuranceManager->findAllBycontrat($id_contrat_bureau_etude,$validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_expiration'] = $value->date_expiration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }*/
        /*if ($menu == "getpolicevalidationBycisco")
        {
            $tmp = $this->Police_assuranceManager->findAllvalidationBycisco($validation,$id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    //$data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_expiration'] = $value->date_expiration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getpoliceByvalidation")
        {
            $tmp = $this->Police_assuranceManager->findAllByvalidation($validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    //$data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_expiration'] = $value->date_expiration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }*/
        elseif ($id)
        {
            $data = array();
            $police_assurance = $this->Police_assuranceManager->findById($id);
            $contrat_be = $this->Contrat_beManager->findById($police_assurance->id_contrat_bureau_etude);
            $data['id'] = $police_assurance->id;
            $data['description'] = $police_assurance->description;
            //$data['fichier'] = $police_assurance->fichier;
            $data['date_expiration'] = $police_assurance->date_expiration;
            $data['observation'] = $police_assurance->observation;
            $data['contrat_be'] = $contrat_be;
        } 
        else 
        {
            $menu = $this->Police_assuranceManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_be= array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    //$data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_expiration'] = $value->date_expiration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
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
                    'description' => $this->post('description'),
                    //'fichier' => $this->post('fichier'),
                    'date_expiration' => $this->post('date_expiration'),
                    'observation' => $this->post('observation'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Police_assuranceManager->add($data);
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
                    'description' => $this->post('description'),
                    //'fichier' => $this->post('fichier'),
                    'date_expiration' => $this->post('date_expiration'),
                    'observation' => $this->post('observation'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Police_assuranceManager->update($id, $data);
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
            $delete = $this->Police_assuranceManager->delete($id);         
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
