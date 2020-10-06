<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Facture_moe_detail extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('facture_moe_detail_model', 'Facture_moe_detailManager');
        //$this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        //$this->load->model('divers_attachement_batiment_prevu_model', 'Divers_attachement_batiment_prevuManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $id_facture_moe_entete = $this->get('id_facture_moe_entete');
        $id_sousrubrique = $this->get('id_sousrubrique');
        $menu = $this->get('menu');
        
        if ($menu == "getfacture_moe_detailwithcalendrier_detailbyentete")
        {
            $tmp = $this->Facture_moe_detailManager->getfacture_moe_detailwithcalendrier_detailbyentete($id_contrat_bureau_etude,$id_facture_moe_entete,$id_sousrubrique);
            if ($tmp) 
            {   
                $data=$tmp;
              /* foreach ($tmp as $key => $value)
                {   

                    $divers_attachement_batiment_prevu = $this->Divers_attachement_batiment_prevuManager->findByIdlibelle($value->id_attachement_batiment_prevu);                 
                    $data[$key]['id'] = $value->id;                  
                    $data[$key]['id_demande_batiment_mpe'] = $value->id_demande_batiment_mpe;                  
                    //$data[$key]['montant_prevu'] = $value->montant_prevu;

                    $data[$key]['quantite_periode'] = $value->quantite_periode;                  
                    $data[$key]['quantite_anterieur'] = $value->quantite_anterieur;                  
                    $data[$key]['quantite_cumul'] = $value->quantite_cumul;                  
                    $data[$key]['montant_periode'] = $value->montant_periode;                  
                    $data[$key]['montant_anterieur'] = $value->montant_anterieur;                  
                    $data[$key]['montant_cumul'] = $value->montant_cumul;                 
                    $data[$key]['pourcentage'] = $value->pourcentage;                 
                    $data[$key]['attachement_batiment_prevu'] = $divers_attachement_batiment_prevu;
                }*/
               // $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $facture_moe_detail = $this->Facture_moe_detailManager->findById($id);
            $data['id'] = $facture_moe_detail->id;
            $data['montant_periode'] = $facture_moe_detail->montant_periode;
            $data['id_calendrier_paie_moe_prevu'] = $facture_moe_detail->id_calendrier_paie_moe_prevu;
            $data['id_facture_moe_entete'] = $facture_moe_detail->id_facture_moe_entete;
            $data['observation'] = $facture_moe_detail->observation;
        } 
        else 
        {
            $tmp = $this->Facture_moe_detailManager->findAll();
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
                    'montant_periode' => $this->post('montant_periode'),
                    'observation' => $this->post('observation'),
                    'id_calendrier_paie_moe_prevu' => $this->post('id_calendrier_paie_moe_prevu'),
                    'id_facture_moe_entete' => $this->post('id_facture_moe_entete')            
              
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Facture_moe_detailManager->add($data);
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
                    'montant_periode' => $this->post('montant_periode'),
                    'observation' => $this->post('observation'),
                    'id_calendrier_paie_moe_prevu' => $this->post('id_calendrier_paie_moe_prevu'),
                    'id_facture_moe_entete' => $this->post('id_facture_moe_entete')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Facture_moe_detailManager->update($id, $data);
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
            $delete = $this->Facture_moe_detailManager->delete($id);         
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
