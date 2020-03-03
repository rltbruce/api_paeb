<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Count_demande_debut_travaux_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_debut_travaux_moe_model', 'Demande_debut_travaux_moeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $invalide = $this->get('invalide');
        if ($invalide==1)
        {
           $demande_debut_travaux_moe = $this->Demande_debut_travaux_moeManager->countAllByInvalide(0);          
            $data = $demande_debut_travaux_moe;
        }
        if ($invalide==2)
        {
           $demande_debut_travaux_moe = $this->Demande_debut_travaux_moeManager->countAllByInvalide(1);          
            $data = $demande_debut_travaux_moe;
        }

        if ($invalide==3)
        {
           $demande_debut_travaux_moe = $this->Demande_debut_travaux_moeManager->countAllByInvalide(2);          
            $data = $demande_debut_travaux_moe;
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
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
