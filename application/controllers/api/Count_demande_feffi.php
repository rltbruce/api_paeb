<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Count_demande_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_realimentation_feffi_model', 'Demande_realimentation_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $invalide = $this->get('invalide');
        if ($invalide==1)
        {
           $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->countAllByInvalide(0);          
            $data = $demande_realimentation_feffi;
        }
        if ($invalide==2)
        {
           $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->countAllByInvalide(1);          
            $data = $demande_realimentation_feffi;
        }
        if ($invalide==3)
        {
           $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->countAllByInvalide(4);          
            $data = $demande_realimentation_feffi;
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
