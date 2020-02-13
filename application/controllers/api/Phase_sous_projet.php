<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Phase_sous_projet extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('phase_sous_projet_model', 'Phase_sous_projetManager');
        $this->load->model('prestation_mpe_model', 'Prestation_mpeManager');
        $this->load->model('infrastructure_model', 'InfrastructureManager');
        $this->load->model('designation_infrastructure_model', 'Designation_infrastructureManager');
        $this->load->model('element_a_verifier_model', 'Element_a_verifierManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');

         if ($cle_etrangere)
         {
            $menu = $this->Phase_sous_projetManager->findAllByPrestation_mpe($cle_etrangere);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $prestation_mpe = $this->Prestation_mpeManager->findById($value->id_prestation_mpe);
                    $infrastructure = $this->InfrastructureManager->findById($value->id_infrastructure);
                    $designation_infrastructure = $this->Designation_infrastructureManager->findById($value->id_designation_infrastructure);
                    $element_a_verifier = $this->Element_a_verifierManager->findById($value->id_element_a_verifier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_verification'] = $value->date_verification;
                    $data[$key]['conformite']   = $value->conformite;
                    $data[$key]['observation']    = $value->observation;
                   
                    $data[$key]['prestation_mpe'] = $prestation_mpe;
                    $data[$key]['infrastructure'] = $infrastructure;
                    $data[$key]['designation_infrastructure'] = $designation_infrastructure;
                    $data[$key]['element_a_verifier'] = $element_a_verifier;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $phase_sous_projet = $this->Phase_sous_projetManager->findById($id);

            $prestation_mpe = $this->Prestation_mpeManager->findById($phase_sous_projet->id_prestation_mpe);
            $infrastructure = $this->InfrastructureManager->findById($phase_sous_projet->id_infrastructure);
            $designation_infrastructure = $this->Designation_infrastructureManager->findById($phase_sous_projet->id_designation_infrastructure);
            $element_a_verifier = $this->Element_a_verifierManager->findById($phase_sous_projet->id_element_a_verifier);

            $data['id'] = $phase_sous_projet->id;
            $data['date_verification'] = $phase_sous_projet->date_verification;
            $data['conformite']   = $phase_sous_projet->conformite;
            $data['observation']    = $phase_sous_projet->observation;
                   
            $data['prestation_mpe'] = $prestation_mpe;
            $data['infrastructure'] = $infrastructure;
            $data['designation_infrastructure'] = $designation_infrastructure;
            $data['element_a_verifier'] = $element_a_verifier;
        } 
        else 
        {
            $menu = $this->Phase_sous_projetManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $prestation_mpe = $this->Prestation_mpeManager->findById($value->id_prestation_mpe);
                    $infrastructure = $this->InfrastructureManager->findById($value->id_infrastructure);
                    $designation_infrastructure = $this->Designation_infrastructureManager->findById($value->id_designation_infrastructure);
                    $element_a_verifier = $this->Element_a_verifierManager->findById($value->id_element_a_verifier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_verification'] = $value->date_verification;
                    $data[$key]['conformite']   = $value->conformite;
                    $data[$key]['observation']    = $value->observation;
                   
                    $data[$key]['prestation_mpe'] = $prestation_mpe;
                    $data[$key]['infrastructure'] = $infrastructure;
                    $data[$key]['designation_infrastructure'] = $designation_infrastructure;
                    $data[$key]['element_a_verifier'] = $element_a_verifier;
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
                    'date_verification' => $this->post('date_verification'),
                    'conformite'   => $this->post('conformite'),
                    'observation'    => $this->post('observation'),
                    'id_infrastructure'   => $this->post('id_infrastructure'),
                    'id_prestation_mpe' => $this->post('id_prestation_mpe'),
                    'id_designation_infrastructure' => $this->post('id_designation_infrastructure'),
                    'id_element_a_verifier' => $this->post('id_element_a_verifier')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Phase_sous_projetManager->add($data);
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
                    'date_verification' => $this->post('date_verification'),
                    'conformite'   => $this->post('conformite'),
                    'observation'    => $this->post('observation'),
                    'id_infrastructure'   => $this->post('id_infrastructure'),
                    'id_prestation_mpe' => $this->post('id_prestation_mpe'),
                    'id_designation_infrastructure' => $this->post('id_designation_infrastructure'),
                    'id_element_a_verifier' => $this->post('id_element_a_verifier')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Phase_sous_projetManager->update($id, $data);
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
            $delete = $this->Phase_sous_projetManager->delete($id);         
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
