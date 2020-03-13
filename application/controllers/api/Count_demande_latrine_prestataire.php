<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Count_demande_latrine_prestataire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_latrine_prestataire_model', 'Demande_latrine_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $invalide = $this->get('invalide');
        if ($invalide==1)
        {
           $demande_latrine_prestataire = $this->Demande_latrine_prestataireManager->countAllByInvalide(0);          
            $data = $demande_latrine_prestataire;
        }
        if ($invalide==2)
        {
           $demande_latrine_prestataire = $this->Demande_latrine_prestataireManager->countAllByInvalide(1);          
            $data = $demande_latrine_prestataire;
        }

        if ($invalide==3)
        {
           $demande_latrine_prestataire = $this->Demande_latrine_prestataireManager->countAllByInvalide(2);          
            $data = $demande_latrine_prestataire;
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