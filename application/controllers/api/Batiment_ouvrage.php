<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Batiment_ouvrage extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('batiment_ouvrage_model', 'Batiment_ouvrageManager');
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_acces_zone = $this->get('id_acces_zone');
        $id_zone_subvention = $this->get('id_zone_subvention');
            
        if ($menu=='getdetailByZoneOuvrage') 
        {   $data = array();
            //$tmp = array();
            $tmp = $this->Batiment_ouvrageManager->findByZoneOuvrage($id_ouvrage,$id_zone_subvention,$id_acces_zone);
            //$data=$tmp;
           if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $acces_zone = array();
                    $zone_subvention = array();

                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['cout_batiment'] = $value->cout_batiment;
                    $data[$key]['cout_maitrise_oeuvre'] = $value->cout_maitrise_oeuvre;
                    $data[$key]['cout_sous_projet'] = $value->cout_sous_projet;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                }
           }
        }
        elseif ($id)
        {
            $data = array();
            $batiment_ouvrage = $this->Batiment_ouvrageManager->findById($id);

            $acces_zone = array();
            $zone_subvention = array();

            $acces_zone = $this->Acces_zoneManager->findById($batiment_ouvrage->id_acces_zone);
            $zone_subvention = $this->Zone_subventionManager->findById($batiment_ouvrage->id_zone_subvention);
            $data['id'] = $batiment_ouvrage->id;
            $data['libelle'] = $batiment_ouvrage->libelle;
            $data['description'] = $batiment_ouvrage->description;
            $data['cout_batiment'] = $batiment_ouvrage->cout_batiment;
            $data['cout_maitrise_oeuvre'] = $batiment_ouvrage->cout_maitrise_oeuvre;
            $data['cout_sous_projet'] = $batiment_ouvrage->cout_sous_projet;
            $data['acces_zone'] = $acces_zone;
            $data['zone_subvention'] = $zone_subvention;
        } 
        else 
        {
            $menu = $this->Batiment_ouvrageManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $acces_zone = array();
                    $zone_subvention = array();

                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['cout_batiment'] = $value->cout_batiment;
                    $data[$key]['cout_maitrise_oeuvre'] = $value->cout_maitrise_oeuvre;
                    $data[$key]['cout_sous_projet'] = $value->cout_sous_projet;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['zone_subvention'] = $zone_subvention;
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'cout_batiment' => $this->post('cout_batiment'),
                    'cout_maitrise_oeuvre' => $this->post('cout_maitrise_oeuvre'),
                    'cout_sous_projet' => $this->post('cout_sous_projet'),
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'id_acces_zone' => $this->post('id_acces_zone')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Batiment_ouvrageManager->add($data);
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'cout_batiment' => $this->post('cout_batiment'),
                    'cout_maitrise_oeuvre' => $this->post('cout_maitrise_oeuvre'),
                    'cout_sous_projet' => $this->post('cout_sous_projet'),
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'id_acces_zone' => $this->post('id_acces_zone')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Batiment_ouvrageManager->update($id, $data);
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
            $delete = $this->Batiment_ouvrageManager->delete($id);         
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
