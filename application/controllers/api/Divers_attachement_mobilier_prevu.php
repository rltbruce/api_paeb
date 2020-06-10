<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Divers_attachement_mobilier_prevu extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('divers_attachement_mobilier_prevu_model', 'Divers_attachement_mobilier_prevuManager');
        //$this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('divers_attachement_mobilier_model', 'Divers_attachement_mobilierManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');
 
        if ($menu == "getdivers_attachement_prevuBycontrat")
        {
            $tmp = $this->Divers_attachement_mobilier_prevuManager->finddivers_attachement_prevuBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {
                    $divers_attachement_mobilier = $this->Divers_attachement_mobilierManager->findById($value->id_divers_attachement_mobilier);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_prevu'] = $value->montant_prevu;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;
                    $data[$key]['divers_attachement_mobilier'] = $divers_attachement_mobilier;
                }
                //$data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $divers_attachement_mobilier_prevu = $this->Divers_attachement_mobilier_prevuManager->findById($id);
            $data['id'] = $divers_attachement_mobilier_prevu->id;
            $data['montant_prevu'] = $divers_attachement_mobilier_prevu->montant_prevu;
            $data['id_contrat_prestataire'] = $divers_attachement_mobilier_prevu->id_contrat_prestataire;
            $data['id_divers_attachement_mobilier'] = $divers_attachement_mobilier_prevu->id_divers_attachement_mobilier;
        } 
        else 
        {
            $tmp = $this->Divers_attachement_mobilier_prevuManager->findAll();
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
                    'montant_prevu' => $this->post('montant_prevu'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'id_divers_attachement_mobilier' => $this->post('id_divers_attachement_mobilier')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Divers_attachement_mobilier_prevuManager->add($data);
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
                    'montant_prevu' => $this->post('montant_prevu'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'id_divers_attachement_mobilier' => $this->post('id_divers_attachement_mobilier')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Divers_attachement_mobilier_prevuManager->update($id, $data);
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
            $delete = $this->Divers_attachement_mobilier_prevuManager->delete($id);         
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
