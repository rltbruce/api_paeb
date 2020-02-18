<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention_cisco_feffi_entete extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('cisco_model', 'CiscoManager');
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('convention_daff_ufp_model', 'Convention_daff_ufpManager');
        //$this->load->model('compte_feffi_model', 'Compte_feffiManager');
        $this->load->model('ecole_model', 'EcoleManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');       
        $menu = $this->get('menu');
        $id_convention_ufpdaaf = $this->get('id_convention_ufpdaaf');
        $id_feffi = $this->get('id_feffi');
        
        if ($menu=='getconventionvalideByfeffi')
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAllValideByfeffi($id_feffi);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $value->avancement;
                    $data[$key]['montant_total'] = $value->montant_total;

                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventionvalide')
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAllValide();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                    
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $value->montant_total;
                    $data[$key]['avancement'] = $value->avancement; 
                    $data[$key]['ecole'] = $ecole;

                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventioninvalide')
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAllInvalide();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $value->montant_total;
                    $data[$key]['avancement'] = $value->avancement; 
                     $data[$key]['ecole'] = $ecole;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id_convention_ufpdaaf)
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAllByufpdaaf($id_convention_ufpdaaf);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                    
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $value->montant_total;
                    $data[$key]['avancement'] = $value->avancement; 
                     $data[$key]['ecole'] = $ecole;
                    if($value->id_convention_ufpdaaf)
                    {
                      $convention_daff_ufp = $this->Convention_daff_ufpManager->findById($value->id_convention_ufpdaaf);
                      $data[$key]['convention_daff_ufp'] = $convention_daff_ufp;

                    }
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $menu = $this->Convention_cisco_feffi_enteteManager->findByIdObjet($id);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $value->montant_total;
                    $data[$key]['avancement'] = $value->avancement; 
                     $data[$key]['ecole'] = $ecole;
                }
            } 
                else
                    $data = array();
        } 
        else 
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $value->montant_total;
                    $data[$key]['avancement'] = $value->avancement; 
                     $data[$key]['ecole'] = $ecole;
                    
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
                    'id_cisco' => $this->post('id_cisco'),
                    'id_feffi' => $this->post('id_feffi'),
                    'ref_financement' => $this->post('ref_financement'),
                    'montant_total' => $this->post('montant_total'),
                    'avancement' => $this->post('avancement'),
                    'validation' => $this->post('validation'),
                    'id_convention_ufpdaaf' => $this->post('id_convention_ufpdaaf')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Convention_cisco_feffi_enteteManager->add($data);
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
                    'id_cisco' => $this->post('id_cisco'),
                    'id_feffi' => $this->post('id_feffi'),
                    'ref_financement' => $this->post('ref_financement'),
                    'validation' => $this->post('validation'),
                    'id_convention_ufpdaaf' => $this->post('id_convention_ufpdaaf'),
                    'montant_total' => $this->post('montant_total'),
                    'avancement' => $this->post('avancement'),
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Convention_cisco_feffi_enteteManager->update($id, $data);
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
            $delete = $this->Convention_cisco_feffi_enteteManager->delete($id);         
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
