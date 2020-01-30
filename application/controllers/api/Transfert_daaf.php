<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Transfert_daaf extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transfert_daaf_model', 'Transfert_daafManager');
       $this->load->model('demande_realimentation_feffi_model', 'Demande_realimentation_feffiManager');
       $this->load->model('compte_feffi_model', 'Compte_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_rea_feffi = $this->get('id_demande_rea_feffi');
        $menu = $this->get('menu');
            
        if ($id_demande_rea_feffi)
        {
            $tmp = $this->Transfert_daafManager->findAllByprogramme($id_demande_rea_feffi);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_realimentation_feffi= array();                    
                    $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($value->id_demande_rea_feffi);

                    $compte_feffi= array();
                    $compte_feffi = $this->Compte_feffiManager->findById($value->id_compte_feffi);

                    $data[$key]['compte_feffi'] = $compte_feffi;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['num_bordereau'] = $value->num_bordereau;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['demande_realimentation_feffi'] = $demande_realimentation_feffi;

                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $transfert_daaf = $this->Transfert_daafManager->findById($id);
            $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($transfert_daaf->id_demande_rea_feffi);

            $compte_feffi= array();
            $compte_feffi = $this->Compte_feffiManager->findById($transfert_daaf->id_compte_feffi);
                    
            $data['compte_feffi'] = $compte_feffi;
            $data['id'] = $transfert_daaf->id;
            $data['description'] = $transfert_daaf->description;
            $data['montant'] = $transfert_daaf->montant;
            $data['num_bordereau'] = $transfert_daaf->num_bordereau;
            $data['date'] = $transfert_daaf->date;
            $data['demande_realimentation_feffi'] = $demande_realimentation_feffi;
        } 
        else 
        {
            $menu = $this->Transfert_daafManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_realimentation_feffi= array();
                    $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($value->id_demande_rea_feffi);

                    $compte_feffi= array();
                    $compte_feffi = $this->Compte_feffiManager->findById($value->id_compte_feffi);
                    
                    $data[$key]['compte_feffi'] = $compte_feffi;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['num_bordereau'] = $value->num_bordereau;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['demande_realimentation_feffi'] = $demande_realimentation_feffi;
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
                    'montant' => $this->post('montant'),
                    'num_bordereau' => $this->post('num_bordereau'),
                    'date' => $this->post('date'),
                    'id_compte_feffi' => $this->post('id_compte_feffi'),
                    'id_demande_rea_feffi' => $this->post('id_demande_rea_feffi')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Transfert_daafManager->add($data);
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
                    'id_compte_feffi' => $this->post('id_compte_feffi'),
                    'montant' => $this->post('montant'),
                    'num_bordereau' => $this->post('num_bordereau'),
                    'date' => $this->post('date'),
                    'id_demande_rea_feffi' => $this->post('id_demande_rea_feffi')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Transfert_daafManager->update($id, $data);
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
            $delete = $this->Transfert_daafManager->delete($id);         
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
