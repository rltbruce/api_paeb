<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_deblocage_daaf extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_deblocage_daaf_model', 'Demande_deblocage_daafManager');
        $this->load->model('convention_daff_ufp_model', 'Convention_daff_ufpManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_ufpdaaf = $this->get('id_convention_ufpdaaf');
        if ($id_convention_ufpdaaf)
        {
            $tmp = $this->Demande_deblocage_daafManager->findAllByconvention_ufpdaaf($id_convention_ufpdaaf);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $convention_ufpdaaf= array();
                    $convention_daff_ufp = $this->Convention_daff_ufpManager->findById($value->id_convention_ufpdaaf);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->bjet;
                    $data[$key]['id_tranche'] = $value->id_tranche;
                    $data[$key]['id_compte_daaf'] = $value->id_compte_daaf;
                    $data[$key]['convention_daff_ufp'] = $convention_daff_ufp;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $demande_deblocage_daaf = $this->Demande_deblocage_daafManager->findById($id);
            $convention_daff_ufp = $this->Convention_daff_ufpManager->findById($demande_deblocage_daaf->id_convention_ufpdaaf);
            $data['id'] = $demande_deblocage_daaf->id;
            $data['objet'] = $demande_deblocage_daaf->objet;
            $data['id_tranche'] = $demande_deblocage_daaf->id_tranche;
            $data['id_compte_daaf'] = $demande_deblocage_daaf->id_compte_daaf;
            $data['convention_daff_ufp'] = $convention_daff_ufp;
        } 
        else 
        {
            $menu = $this->Demande_deblocage_daafManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $convention_daff_ufp= array();
                    $convention_daff_ufp = $this->Convention_daff_ufpManager->findById($value->id_convention_ufpdaaf);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->bjet;
                    $data[$key]['id_tranche'] = $value->id_tranche;
                    $data[$key]['id_compte_daaf'] = $value->id_compte_daaf;
                    $data[$key]['convention_daff_ufp'] = $convention_daff_ufp;

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
                    'objet' => $this->post('objet'),
                    'id_tranche' => $this->post('id_tranche'),
                    'id_compte_daaf' => $this->post('id_compte_daaf'),
                    'id_convention_ufpdaaf' => $this->post('id_convention_ufpdaaf')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_deblocage_daafManager->add($data);
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
                    'objet' => $this->post('objet'),
                    'id_tranche' => $this->post('id_tranche'),
                    'id_compte_daaf' => $this->post('id_compte_daaf'),
                    'id_convention_ufpdaaf' => $this->post('id_convention_ufpdaaf')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_deblocage_daafManager->update($id, $data);
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
            $delete = $this->Demande_deblocage_daafManager->delete($id);         
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
