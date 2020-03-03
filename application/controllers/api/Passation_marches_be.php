<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Passation_marches_be extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('passation_marches_be_model', 'Passation_marches_beManager');
        $this->load->model('bureau_etude_model', 'Bureau_etudeManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $id_bureau_etude = $this->get('id_bureau_etude');
        $menu = $this->get('menu');

         if ($menu=='getpassationBybe')
         {
            $menu = $this->Passation_marches_beManager->findAllBybe($id_bureau_etude);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    //$bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;
                    $data[$key]['date_shortlist'] = $value->date_shortlist;
                    $data[$key]['statut'] = $value->statut;

                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bato'] = 'ato';
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $passation_marches_be = $this->Passation_marches_beManager->findById($id);

            //$bureau_etude = $this->Bureau_etudeManager->findById($passation_marches_be->id_bureau_etude);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($passation_marches_be->id_convention_entete);

            $data['id'] = $passation_marches_be->id;
            $data['date_lancement_dp'] = $passation_marches_be->date_lancement_dp;
            $data['date_remise']   = $passation_marches_be->date_remise;
            $data['nbr_offre_recu']    = $passation_marches_be->nbr_offre_recu;
            $data['date_rapport_evaluation'] = $passation_marches_be->date_rapport_evaluation;
            $data['date_demande_ano_dpfi'] = $passation_marches_be->date_demande_ano_dpfi;
            $data['date_ano_dpfi'] = $passation_marches_be->date_ano_dpfi;
            $data['notification_intention']   = $passation_marches_be->notification_intention;
            $data['date_notification_attribution']    = $passation_marches_be->date_notification_attribution;
            $data['date_signature_contrat']   = $passation_marches_be->date_signature_contrat;
            $data['date_os'] = $passation_marches_be->date_os;
            $data['observation'] = $passation_marches_be->observation;

            $data['date_manifestation']   = $passation_marches_be->date_manifestation;
            $data['date_shortlist'] = $passation_marches_be->date_shortlist;
            $data['statut'] = $passation_marches_be->statut;

            $data['convention_entete'] = $convention_entete;
            //$data['be'] = $bureau_etude;
        } 
        else 
        {
            $menu = $this->Passation_marches_beManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    //$bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;
                    $data[$key]['date_shortlist'] = $value->date_shortlist;
                    $data[$key]['statut'] = $value->statut;

                    $data[$key]['convention_entete'] = $convention_entete;
                    //$data[$key]['be'] = $bureau_etude;
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
                    'date_lancement_dp' => $this->post('date_lancement_dp'),
                    'date_remise'   => $this->post('date_remise'),
                    'nbr_offre_recu'    => $this->post('nbr_offre_recu'),
                    'date_rapport_evaluation' => $this->post('date_rapport_evaluation'),
                    'date_demande_ano_dpfi' => $this->post('date_demande_ano_dpfi'),
                    'date_ano_dpfi' => $this->post('date_ano_dpfi'),
                    'notification_intention'   => $this->post('notification_intention'),
                    'date_notification_attribution'    => $this->post('date_notification_attribution'),
                    'date_signature_contrat'   => $this->post('date_signature_contrat'),
                    'date_os' => $this->post('date_os'),
                    'observation' => $this->post('observation'),

                    'date_shortlist'   => $this->post('date_shortlist'),
                    'date_manifestation' => $this->post('date_manifestation'),
                    'statut' => $this->post('statut'),

                    'id_convention_entete' => $this->post('id_convention_entete'),
                    //'id_bureau_etude' => $this->post('id_bureau_etude'),
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Passation_marches_beManager->add($data);
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
                    'date_lancement_dp' => $this->post('date_lancement_dp'),
                    'date_remise'   => $this->post('date_remise'),
                    'nbr_offre_recu'    => $this->post('nbr_offre_recu'),
                    'date_rapport_evaluation' => $this->post('date_rapport_evaluation'),
                    'date_demande_ano_dpfi' => $this->post('date_demande_ano_dpfi'),
                    'date_ano_dpfi' => $this->post('date_ano_dpfi'),
                    'notification_intention'   => $this->post('notification_intention'),
                    'date_notification_attribution'    => $this->post('date_notification_attribution'),
                    'date_signature_contrat'   => $this->post('date_signature_contrat'),
                    'date_os' => $this->post('date_os'),
                    'observation' => $this->post('observation'),

                    'date_shortlist'   => $this->post('date_shortlist'),
                    'date_manifestation' => $this->post('date_manifestation'),
                    'statut' => $this->post('statut'),

                    'id_convention_entete' => $this->post('id_convention_entete'),
                    //'id_bureau_etude' => $this->post('id_bureau_etude'),
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Passation_marches_beManager->update($id, $data);
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
            $delete = $this->Passation_marches_beManager->delete($id);         
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
