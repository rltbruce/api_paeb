<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Avenant_partenaire_relai extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('avenant_partenaire_relai_model', 'Avenant_partenaire_relaiManager');
        $this->load->model('contrat_partenaire_relai_model', 'Contrat_partenaire_relaiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_partenaire_relai = $this->get('id_contrat_partenaire_relai');
        $menu = $this->get('menu');

         if ($menu=='getavenantBycontrat')
         {
            $menu = $this->Avenant_partenaire_relaiManager->findAllByContrat_partenaire_relai($id_contrat_partenaire_relai);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_avenant']    = $value->ref_avenant;
                    $data[$key]['montant_avenant']   = $value->montant_avenant;
                    $data[$key]['date_signature'] = $value->date_signature;

                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $avenant_partenaire_relai = $this->Avenant_partenaire_relaiManager->findById($id);
            $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($avenant_partenaire_relai->id_contrat_partenaire_relai);

            $data['id'] = $avenant_partenaire_relai->id;
            $data['intitule'] = $avenant_partenaire_relai->intitule;
            $data['ref_avenant']    = $avenant_partenaire_relai->ref_avenant;
            $data['montant_avenant']   = $avenant_partenaire_relai->montant_avenant;
            $data['date_signature'] = $avenant_partenaire_relai->date_signature;

            $data['contrat_partenaire_relai'] = $contrat_partenaire_relai;
        } 
        else 
        {
            $menu = $this->Avenant_partenaire_relaiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {                   
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_avenant']    = $value->ref_avenant;
                    $data[$key]['montant_avenant']   = $value->montant_avenant;
                    $data[$key]['date_signature'] = $value->date_signature;

                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
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
                    'ref_avenant'    => $this->post('ref_avenant'),
                    'montant_avenant'   => $this->post('montant_avenant'),
                    'date_signature' => $this->post('date_signature'),
                    'id_contrat_partenaire_relai' => $this->post('id_contrat_partenaire_relai')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Avenant_partenaire_relaiManager->add($data);
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
                    'ref_avenant'    => $this->post('ref_avenant'),
                    'montant_avenant'   => $this->post('montant_avenant'),
                    'date_signature' => $this->post('date_signature'),
                    'id_contrat_partenaire_relai' => $this->post('id_contrat_partenaire_relai')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Avenant_partenaire_relaiManager->update($id, $data);
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
            $delete = $this->Avenant_partenaire_relaiManager->delete($id);         
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
