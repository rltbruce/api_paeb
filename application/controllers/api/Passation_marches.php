<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Passation_marches extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('passation_marches_model', 'Passation_marchesManager');
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
            $menu = $this->Passation_marchesManager->findAllByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement'] = $value->date_lancement;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                    $data[$key]['montant_moin_chere']   = $value->montant_moin_chere;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

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
            $passation_marches = $this->Passation_marchesManager->findById($id);

            $prestataire = $this->PrestataireManager->findById($passation_marches->id_prestataire);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($passation_marches->id_convention_entete);

            $data['id'] = $passation_marches->id;
            $data['date_lancement'] = $passation_marches->date_lancement;
            $data['date_remise']   = $passation_marches->date_remise;
            $data['nbr_offre_recu']    = $passation_marches->nbr_offre_recu;
            $data['montant_moin_chere']   = $passation_marches->montant_moin_chere;
            $data['date_rapport_evaluation'] = $passation_marches->date_rapport_evaluation;
            $data['date_demande_ano_dpfi'] = $passation_marches->date_demande_ano_dpfi;
            $data['date_ano_dpfi'] = $passation_marches->date_ano_dpfi;
            $data['notification_intention']   = $passation_marches->notification_intention;
            $data['date_notification_attribution']    = $passation_marches->date_notification_attribution;
            $data['date_signature_contrat']   = $passation_marches->date_signature_contrat;
            $data['date_os'] = $passation_marches->date_os;
            $data['observation'] = $passation_marches->observation;

            $data['convention_entete'] = $convention_entete;
            $data['prestataire'] = $prestataire;
        } 
        else 
        {
            $menu = $this->Passation_marchesManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement'] = $value->date_lancement;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                    $data[$key]['montant_moin_chere']   = $value->montant_moin_chere;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

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
                    'date_lancement' => $this->post('date_lancement'),
                    'date_remise'   => $this->post('date_remise'),
                    'nbr_offre_recu'    => $this->post('nbr_offre_recu'),
                    'montant_moin_chere'   => $this->post('montant_moin_chere'),
                    'date_rapport_evaluation' => $this->post('date_rapport_evaluation'),
                    'date_demande_ano_dpfi' => $this->post('date_demande_ano_dpfi'),
                    'date_ano_dpfi' => $this->post('date_ano_dpfi'),
                    'notification_intention'   => $this->post('notification_intention'),
                    'date_notification_attribution'    => $this->post('date_notification_attribution'),
                    'date_signature_contrat'   => $this->post('date_signature_contrat'),
                    'date_os' => $this->post('date_os'),
                    'observation' => $this->post('observation'),

                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_prestataire' => $this->post('id_prestataire'),
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Passation_marchesManager->add($data);
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
                    'date_lancement' => $this->post('date_lancement'),
                    'date_remise'   => $this->post('date_remise'),
                    'nbr_offre_recu'    => $this->post('nbr_offre_recu'),
                    'montant_moin_chere'   => $this->post('montant_moin_chere'),
                    'date_rapport_evaluation' => $this->post('date_rapport_evaluation'),
                    'date_demande_ano_dpfi' => $this->post('date_demande_ano_dpfi'),
                    'date_ano_dpfi' => $this->post('date_ano_dpfi'),
                    'notification_intention'   => $this->post('notification_intention'),
                    'date_notification_attribution'    => $this->post('date_notification_attribution'),
                    'date_signature_contrat'   => $this->post('date_signature_contrat'),
                    'date_os' => $this->post('date_os'),
                    'observation' => $this->post('observation'),

                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_prestataire' => $this->post('id_prestataire')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Passation_marchesManager->update($id, $data);
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
            $delete = $this->Passation_marchesManager->delete($id);         
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
