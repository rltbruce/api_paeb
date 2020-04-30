<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Contrat_be extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_be_model', 'Contrat_beManager');
        $this->load->model('bureau_etude_model', 'Bureau_etudeManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $id_bureau_etude = $this->get('id_bureau_etude');
        $id_cisco = $this->get('id_cisco');
        $menus = $this->get('menus');
         
        /* if ($menus=='getcontratBycisco')
         {
            $menu = $this->Contrat_beManager->findAllBycisco($id_cisco);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat'] = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratBybe')
         {
            $menu = $this->Contrat_beManager->findAllBybe($id_bureau_etude);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat'] = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
                }
            } 
                else
                    $data = array();
        }   
        else*/
        if ($menus=='getcontratByconvention')
         {
            $menu = $this->Contrat_beManager->findAllByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontratvalideByconvention')
         {
            $menu = $this->Contrat_beManager->findcontratvalideByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontratinvalideByconvention')
        {
            $menu = $this->Contrat_beManager->findcontratinvalideByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
                        }
            } 
                else
                    $data = array();
        }     
        elseif ($id)
        {
            $data = array();
            $contrat_be = $this->Contrat_beManager->findById($id);

            $bureau_etude = $this->Bureau_etudeManager->findById($contrat_be->id_bureau_etude);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($contrat_be->id_convention_entete);

            $data['id'] = $contrat_be->id;
            $data['intitule'] = $contrat_be->intitule;
            $data['ref_contrat']   = $contrat_be->ref_contrat;
            $data['montant_contrat']    = $contrat_be->montant_contrat;
            $data['date_signature'] = $contrat_be->date_signature;
            $data['convention_entete'] = $convention_entete;
            $data['bureau_etude'] = $bureau_etude;
        } 
        else 
        {
            $menu = $this->Contrat_beManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
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
                    'intitule' => $this->post('intitule'),
                    'ref_contrat'   => $this->post('ref_contrat'),
                    'montant_contrat'    => $this->post('montant_contrat'),
                    'date_signature' => $this->post('date_signature'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_bureau_etude' => $this->post('id_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Contrat_beManager->add($data);
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
                    'intitule' => $this->post('intitule'),
                    'ref_contrat'   => $this->post('ref_contrat'),
                    'montant_contrat'    => $this->post('montant_contrat'),
                    'date_signature' => $this->post('date_signature'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_bureau_etude' => $this->post('id_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Contrat_beManager->update($id, $data);
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
            $delete = $this->Contrat_beManager->delete($id);         
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
