<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention_ufp_daaf_entete extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_ufp_daaf_entete_model', 'Convention_ufp_daaf_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');       
        $menu = $this->get('menu');
        $validation = $this->get('validation');
        $id_convention_ufp_daaf_entete = $this->get('id_convention_ufp_daaf_entete');

        if ($menu=="getDetailcoutByConvention")
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findDetailcoutByConvention($id_convention_ufp_daaf_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['montant_trav_mob'] = $value->cout_batiment + $value->cout_latrine + $value->cout_mobilier;
                    $data[$key]['montant_divers'] = $value->cout_divers;
                    
                }
            } 
                else
                    $data = array();
        }
        if ($menu=="getconvention_ufp_daaf_validation")
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findConvention_ufp_daafByValidation($validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_convention'] = $value->montant_convention;                    
                    $data[$key]['montant_trans_comm'] = $value->montant_trans_comm;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $tmp = $this->Convention_ufp_daaf_enteteManager->findByIdObjet($id);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_convention'] = $value->montant_convention;                    
                    $data[$key]['montant_trans_comm'] = $value->montant_trans_comm;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    
                }
            } 
                else
                    $data = array();
        } 
        else 
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_convention'] = $value->montant_convention;                    
                    $data[$key]['montant_trans_comm'] = $value->montant_trans_comm;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    
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
                    'ref_convention' => $this->post('ref_convention'),
                    'objet' => $this->post('objet'),
                    'montant_convention' => $this->post('montant_convention'),
                    'ref_financement' => $this->post('ref_financement'),
                    'montant_trans_comm' => $this->post('montant_trans_comm'),
                    'frais_bancaire' => $this->post('frais_bancaire'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Convention_ufp_daaf_enteteManager->add($data);
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
                    'ref_convention' => $this->post('ref_convention'),
                    'objet' => $this->post('objet'),
                    'montant_convention' => $this->post('montant_convention'),
                    'ref_financement' => $this->post('ref_financement'),
                    'montant_trans_comm' => $this->post('montant_trans_comm'),
                    'frais_bancaire' => $this->post('frais_bancaire'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Convention_ufp_daaf_enteteManager->update($id, $data);
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
            $delete = $this->Convention_ufp_daaf_enteteManager->delete($id);         
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
