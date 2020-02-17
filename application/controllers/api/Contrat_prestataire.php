<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Contrat_prestataire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('prestataire_model', 'PrestataireManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $menu = $this->get('menu');

         if ($menu=='getpassationByconvention')
         {
            $menu = $this->Contrat_prestataireManager->findAllByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['num_contrat']   = $value->num_contrat;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['date_prev_deb_trav'] = $value->date_prev_deb_trav;
                    $data[$key]['date_reel_deb_trav'] = $value->date_reel_deb_trav;
                    $data[$key]['delai_execution'] = $value->delai_execution;
                    $data[$key]['paiement_recu'] = $value->paiement_recu;

                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['prestataire'] = $prestataire;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $contrat_prestataire = $this->Contrat_prestataireManager->findById($id);

            $prestataire = $this->PrestataireManager->findById($contrat_prestataire->id_prestataire);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($contrat_prestataire->id_convention_entete);

            $data['id'] = $contrat_prestataire->id;
            $data['description'] = $contrat_prestataire->description;
            $data['num_contrat']   = $contrat_prestataire->num_contrat;
            $data['cout_batiment']    = $contrat_prestataire->cout_batiment;
            $data['cout_latrine']   = $contrat_prestataire->cout_latrine;
            $data['cout_mobilier'] = $contrat_prestataire->cout_mobilier;
            $data['date_signature'] = $contrat_prestataire->date_signature;
            $data['date_prev_deb_trav'] = $contrat_prestataire->date_prev_deb_trav;
            $data['date_reel_deb_trav'] = $contrat_prestataire->date_reel_deb_trav;
            $data['delai_execution'] = $contrat_prestataire->delai_execution;
            $data['paiement'] = $contrat_prestataire->paiement;

            $data['convention_entete'] = $convention_entete;
            $data['prestataire'] = $prestataire;
        } 
        else 
        {
            $menu = $this->Contrat_prestataireManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['num_contrat']   = $value->num_contrat;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['date_prev_deb_trav'] = $value->date_prev_deb_trav;
                    $data[$key]['date_reel_deb_trav'] = $value->date_reel_deb_trav;
                    $data[$key]['delai_execution'] = $value->delai_execution;
                    $data[$key]['paiement_recu'] = $value->paiement_recu;

                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['prestataire'] = $prestataire;
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
                    'id' => $this->post('id'),
                    'description' => $this->post('description'),
                    'num_contrat'   => $this->post('num_contrat'),
                    'cout_batiment'    => $this->post('cout_batiment'),
                    'cout_latrine'   => $this->post('cout_latrine'),
                    'cout_mobilier' => $this->post('cout_mobilier'),
                    'date_signature' => $this->post('date_signature'),
                    'date_prev_deb_trav' => $this->post('date_prev_deb_trav'),
                    'date_reel_deb_trav' => $this->post('date_reel_deb_trav'),
                    'delai_execution' => $this->post('delai_execution'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_prestataire' => $this->post('id_prestataire'),
                    'paiement_recu' => $this->post('paiement_recu')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Contrat_prestataireManager->add($data);
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
                    'id' => $this->post('id'),
                    'description' => $this->post('description'),
                    'num_contrat'   => $this->post('num_contrat'),
                    'cout_batiment'    => $this->post('cout_batiment'),
                    'cout_latrine'   => $this->post('cout_latrine'),
                    'cout_mobilier' => $this->post('cout_mobilier'),
                    'date_signature' => $this->post('date_signature'),
                    'date_prev_deb_trav' => $this->post('date_prev_deb_trav'),
                    'date_reel_deb_trav' => $this->post('date_reel_deb_trav'),
                    'delai_execution' => $this->post('delai_execution'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_prestataire' => $this->post('id_prestataire'),
                    'paiement_recu' => $this->post('paiement_recu')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Contrat_prestataireManager->update($id, $data);
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
            $delete = $this->Contrat_prestataireManager->delete($id);         
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
