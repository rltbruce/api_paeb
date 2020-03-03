<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Contrat_partenaire_relai extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_partenaire_relai_model', 'Contrat_partenaire_relaiManager');
        $this->load->model('partenaire_relai_model', 'Partenaire_relaiManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $id_partenaire_relai = $this->get('id_partenaire_relai');
        $menus = $this->get('menus');
         
         if ($menus=='getcontratBypartenaire_relai')
         {
            $menu = $this->Contrat_partenaire_relaiManager->findAllBypartenaire_relai($id_partenaire_relai);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratByconvention')
         {
            $menu = $this->Contrat_partenaire_relaiManager->findAllByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($id);

            $partenaire_relai = $this->Partenaire_relaiManager->findById($contrat_partenaire_relai->id_partenaire_relai);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($contrat_partenaire_relai->id_convention_entete);

            $data['id'] = $contrat_partenaire_relai->id;
            $data['intitule'] = $contrat_partenaire_relai->intitule;
            $data['ref_contrat']   = $contrat_partenaire_relai->ref_contrat;
            $data['montant_contrat']    = $contrat_partenaire_relai->montant_contrat;
            $data['date_signature'] = $contrat_partenaire_relai->date_signature;
            $data['convention_entete'] = $convention_entete;
            $data['partenaire_relai'] = $partenaire_relai;
        } 
        else 
        {
            $menu = $this->Contrat_partenaire_relaiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
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
                    'id_partenaire_relai' => $this->post('id_partenaire_relai')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Contrat_partenaire_relaiManager->add($data);
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
                    'id_partenaire_relai' => $this->post('id_partenaire_relai')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Contrat_partenaire_relaiManager->update($id, $data);
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
            $delete = $this->Contrat_partenaire_relaiManager->delete($id);         
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
