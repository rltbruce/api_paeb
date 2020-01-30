<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention_cisco_feffi_detail extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_cisco_feffi_detail_model', 'Convention_cisco_feffi_detailManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
        $this->load->model('composant_model', 'ComposantManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');

        if ($id_convention_entete)
        {
            $detail = $this->Convention_cisco_feffi_detailManager->findAllByEntete($id_convention_entete );
            if ($detail) 
            {
                foreach ($detail as $key => $value) 
                {                     
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $composant = $this->ComposantManager->findByAcceszone_zonesubvention($value->id_acces_zone, $value->id_zone_subvention);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['montant_total'] = $value->montant_total;                    
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['composant'] = $composant;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $convention_detail = $this->Convention_cisco_feffi_detailManager->findById($id);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($convention_detail->$id_convention_entete);
            $zone_subvention = $this->Zone_subventionManager->findById($convention_detail->id_zone_subvention);
            $acces_zone = $this->Acces_zoneManager->findById($convention_detail->id_acces_zone);
            $composant = $this->ComposantManager->findByAcceszone_zonesubvention($convention_detail->id_acces_zone, $convention_detail->id_zone_subvention);

            $data['id'] = $convention_detail->id;
            $data['intitule'] = $convention_detail->intitule;
            $data['montant_total'] = $convention_detail->montant_total;                    
            $data['zone_subvention'] = $zone_subvention;
            $data['acces_zone'] = $acces_zone;
            $data['convention_entete'] = $convention_detail->convention_entete;
            $data['composant'] = $composant;
        } 
        else 
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data = array();
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->$id_convention_entete);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $composant = $this->ComposantManager->findByAcceszone_zonesubvention($value->id_acces_zone, $value->id_zone_subvention);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['montant_total'] = $value->montant_total;                    
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['convention_entete'] = $value->convention_entete;
                    $data[$key]['composant'] = $composant;
                    
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
                    'intitule' => $this->post('intitule'),
                    'montant_total' => $this->post('montant_total'),
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'id_acces_zone' => $this->post('id_acces_zone'),
                    'id_convention_entete' => $this->post('id_convention_entete')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Convention_cisco_feffi_detailManager->add($data);
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
                    'intitule' => $this->post('intitule'),
                    'montant_total' => $this->post('montant_total'),
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'id_acces_zone' => $this->post('id_acces_zone'),
                    'id_convention_entete' => $this->post('id_convention_entete')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Convention_cisco_feffi_detailManager->update($id, $data);
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
            $delete = $this->Convention_cisco_feffi_detailManager->delete($id);         
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
