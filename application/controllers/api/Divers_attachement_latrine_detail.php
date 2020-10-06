<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Divers_attachement_latrine_detail extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('divers_attachement_latrine_detail_model', 'Divers_attachement_latrine_detailManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_attachement_latrine = $this->get('id_attachement_latrine');
        $menu = $this->get('menu');

        if ($menu == 'getdetailbyattachement_latrine') 
        {   $data = array();
            $tmp = $this->Divers_attachement_latrine_detailManager->getdetailbyattachement_latrine($id_attachement_latrine);
           
            if ($tmp) 
            {
                $data = $tmp;
            }
        }
        elseif ($id)
        {
            $data = array();
            $divers_attachement_latrine_detail = $this->Divers_attachement_latrine_detailManager->findById($id);
            $data['id'] = $divers_attachement_latrine_detail->id;
            $data['libelle'] = $divers_attachement_latrine_detail->libelle;
            $data['description'] = $divers_attachement_latrine_detail->description;
            $data['numero'] = $divers_attachement_latrine_detail->numero;
        } 
        else 
        {
            $tmp = $this->Divers_attachement_latrine_detailManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
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
                    'numero' => $this->post('numero'),
                    'id_attachement_latrine' => $this->post('id_attachement_latrine')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Divers_attachement_latrine_detailManager->add($data);
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
                    'numero' => $this->post('numero'),
                    'id_attachement_latrine' => $this->post('id_attachement_latrine')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Divers_attachement_latrine_detailManager->update($id, $data);
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
            $delete = $this->Divers_attachement_latrine_detailManager->delete($id);         
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
