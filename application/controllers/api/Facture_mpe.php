<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Facture_mpe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('facture_mpe_model', 'Facture_mpeManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');

        if ($menu=="getfacture_mpevalidebcafBycontrat")
        {
            $tmp = $this->Facture_mpeManager->findfacture_mpevalidebcafBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;            } 
                else
                    $data = array();
        }
        elseif ($menu=="getfacture_mpeBycontrat")
        {
            $tmp = $this->Facture_mpeManager->findfacture_mpeBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $facture_mpe = $this->Facture_mpeManager->findById($id);

            $data['id'] = $facture_mpe->id;
            $data['numero'] = $facture_mpe->numero ;
            $data['montant_rabais'] = $facture_mpe->montant_rabais ;
            $data['pourcentage_rabais'] = $facture_mpe->pourcentage_rabais ;
            $data['montant_travaux'] = $facture_mpe->montant_travaux ;
            $data['montant_ht'] = $facture_mpe->montant_ht ;
            $data['montant_tva'] = $facture_mpe->montant_tva ;
            $data['montant_ttc'] = $facture_mpe->montant_ttc ;
            $data['remboursement_acompte'] = $facture_mpe->remboursement_acompte;
            $data['penalite_retard'] = $facture_mpe->penalite_retard ;
            $data['retenue_garantie'] = $facture_mpe->retenue_garantie ;
            $data['remboursement_plaque'] = $facture_mpe->remboursement_plaque;
            $data['net_payer'] = $facture_mpe->net_payer ;
            $data['date_signature'] = $facture_mpe->date_signature ;
            $data['id_contrat_prestataire'] = $facture_mpe->id_contrat_prestataire;
            $data['validation'] = $facture_mpe->validation ;
        } 
        else 
        {
            $tmp = $this->Facture_mpeManager->findAll();
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
                    'numero' => $this->post('numero'),
                    'montant_rabais' => $this->post('montant_rabais'),
                    'pourcentage_rabais' => $this->post('pourcentage_rabais'),
                    'montant_travaux' => $this->post('montant_travaux'),
                    'montant_ht' => $this->post('montant_ht'),
                    'montant_tva' => $this->post('montant_tva'),
                    'montant_ttc' => $this->post('montant_ttc'),
                    'remboursement_acompte' => $this->post('remboursement_acompte'),
                    'penalite_retard' => $this->post('penalite_retard'),
                    'retenue_garantie' => $this->post('retenue_garantie'),
                    'remboursement_plaque' => $this->post('remboursement_plaque'),
                    'net_payer' => $this->post('net_payer'),
                    'date_signature' => $this->post('date_signature'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Facture_mpeManager->add($data);
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
                    'numero' => $this->post('numero'),
                    'montant_rabais' => $this->post('montant_rabais'),
                    'pourcentage_rabais' => $this->post('pourcentage_rabais'),
                    'montant_travaux' => $this->post('montant_travaux'),
                    'montant_ht' => $this->post('montant_ht'),
                    'montant_tva' => $this->post('montant_tva'),
                    'montant_ttc' => $this->post('montant_ttc'),
                    'remboursement_acompte' => $this->post('remboursement_acompte'),
                    'penalite_retard' => $this->post('penalite_retard'),
                    'retenue_garantie' => $this->post('retenue_garantie'),
                    'remboursement_plaque' => $this->post('remboursement_plaque'),
                    'net_payer' => $this->post('net_payer'),
                    'date_signature' => $this->post('date_signature'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Facture_mpeManager->update($id, $data);
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
            $delete = $this->Facture_mpeManager->delete($id);         
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
