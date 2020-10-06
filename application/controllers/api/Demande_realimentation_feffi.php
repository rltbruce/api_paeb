<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_realimentation_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_realimentation_feffi_model', 'Demande_realimentation_feffiManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('tranche_deblocage_feffi_model', 'Tranche_deblocage_feffiManager');
        $this->load->model('compte_feffi_model', 'Compte_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_cife_entete = $this->get('id_convention_cife_entete');
        //$id_convention_entete = $this->get('id_convention_entete');
        $menu = $this->get('menu');
        $invalide = $this->get('invalide');
        $validation= $this->get('validation');
        $id_cisco = $this->get('id_cisco');

        if ($menu=='getdemandevalidedaafByconvention') //mande
        {
            $menu = $this->Demande_realimentation_feffiManager->finddemandevalidedaafByIdconvention_cife_entete($id_convention_cife_entete);
            if ($menu) 
            { 
                foreach ($menu as $key => $value) 
                {
                    $convention_cife_entete= array();
                    $convention_cife_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_cife_entete);
                    $tranche_deblocage_feffi = $this->Tranche_deblocage_feffiManager->findById($value->id_tranche_deblocage_feffi);
                    $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_cife_entete->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['compte_feffi'] = $compte_feffi;
                    $data[$key]['tranche'] = $tranche_deblocage_feffi;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['convention_cife_entete'] = $convention_cife_entete;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getdemandedisponibleByconvention') //mande
        {
            $menu = $this->Demande_realimentation_feffiManager->finddemandedisponibleByconvention($id_convention_cife_entete);
            if ($menu) 
            { 
                foreach ($menu as $key => $value) 
                {
                    $convention_cife_entete= array();
                    $convention_cife_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_cife_entete);
                    $tranche_deblocage_feffi = $this->Tranche_deblocage_feffiManager->findById($value->id_tranche_deblocage_feffi);
                    $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_cife_entete->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['compte_feffi'] = $compte_feffi;
                    $data[$key]['tranche'] = $tranche_deblocage_feffi;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['convention_cife_entete'] = $convention_cife_entete;
                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getdemandeemidaafByconvention') //mande
        {
            $menu = $this->Demande_realimentation_feffiManager->finddemandeemidaafByIdconvention_cife_entete($id_convention_cife_entete);
            if ($menu) 
            { 
                foreach ($menu as $key => $value) 
                {
                    $convention_cife_entete= array();
                    $convention_cife_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_cife_entete);
                    $tranche_deblocage_feffi = $this->Tranche_deblocage_feffiManager->findById($value->id_tranche_deblocage_feffi);
                    $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_cife_entete->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['compte_feffi'] = $compte_feffi;
                    $data[$key]['tranche'] = $tranche_deblocage_feffi;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['convention_cife_entete'] = $convention_cife_entete;
                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getdemandeemiufpByconvention') //mande
        {
            $menu = $this->Demande_realimentation_feffiManager->finddemandeemiufpByIdconvention_cife_entete($id_convention_cife_entete);
            if ($menu) 
            { 
                foreach ($menu as $key => $value) 
                {
                    $convention_cife_entete= array();
                    $convention_cife_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_cife_entete);
                    $tranche_deblocage_feffi = $this->Tranche_deblocage_feffiManager->findById($value->id_tranche_deblocage_feffi);
                    $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_cife_entete->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['compte_feffi'] = $compte_feffi;
                    $data[$key]['tranche'] = $tranche_deblocage_feffi;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['convention_cife_entete'] = $convention_cife_entete;
                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getdemandeemidpfiByconvention') //mande
        {
            $menu = $this->Demande_realimentation_feffiManager->finddemandeemidpfiByIdconvention_cife_entete($id_convention_cife_entete);
            if ($menu) 
            { 
                foreach ($menu as $key => $value) 
                {
                    $convention_cife_entete= array();
                    $convention_cife_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_cife_entete);
                    $tranche_deblocage_feffi = $this->Tranche_deblocage_feffiManager->findById($value->id_tranche_deblocage_feffi);
                    $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_cife_entete->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['compte_feffi'] = $compte_feffi;
                    $data[$key]['tranche'] = $tranche_deblocage_feffi;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['convention_cife_entete'] = $convention_cife_entete;
                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getdemandeByconvention') //mande
        {
            $menu = $this->Demande_realimentation_feffiManager->findallByIdconvention_cife_entete($id_convention_cife_entete);
            if ($menu) 
            { 
                foreach ($menu as $key => $value) 
                {
                    $convention_cife_entete= array();
                    $convention_cife_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_cife_entete);
                    $tranche_deblocage_feffi = $this->Tranche_deblocage_feffiManager->findById($value->id_tranche_deblocage_feffi);
                    $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_cife_entete->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['compte_feffi'] = $compte_feffi;
                    $data[$key]['tranche'] = $tranche_deblocage_feffi;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['convention_cife_entete'] = $convention_cife_entete;
                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getdemandecreerByconvention') //mande
        {
            $menu = $this->Demande_realimentation_feffiManager->findcreerByIdconvention_cife_entete($id_convention_cife_entete);
            if ($menu) 
            { 
                foreach ($menu as $key => $value) 
                {
                    $convention_cife_entete= array();
                    $convention_cife_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_cife_entete);
                    $tranche_deblocage_feffi = $this->Tranche_deblocage_feffiManager->findById($value->id_tranche_deblocage_feffi);
                    $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_cife_entete->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['compte_feffi'] = $compte_feffi;
                    $data[$key]['tranche'] = $tranche_deblocage_feffi;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['convention_cife_entete'] = $convention_cife_entete;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($id);
            $convention_cife_entete = $this->Convention_cisco_feffi_enteteManager->findById($demande_realimentation_feffi->id_convention_cife_entete);
            $tranche_deblocage_feffi = $this->Tranche_deblocage_feffiManager->findById($demande_realimentation_feffi->id_convention_cife_entete);
            $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_cife_entete->id_feffi);

            $data['id'] = $demande_realimentation_feffi->id;
            $data['tranche_deblocage_feffi'] = $tranche_deblocage_feffi;
            $data['compte_feffi'] = $compte_feffi;
            $data['prevu'] = $demande_realimentation_feffi->prevu;
            $data['cumul'] = $demande_realimentation_feffi->cumul;
            $data['anterieur'] = $demande_realimentation_feffi->anterieur;
            $data['reste'] = $demande_realimentation_feffi->reste;
            $data['date_approbation'] = $demande_realimentation_feffi->date_approbation;
            $data['date'] = $demande_realimentation_feffi->date;
            $data['validation'] = $demande_realimentation_feffi->validation;
            $data['convention_cife_entete'] = $convention_cife_entete;
        } 
        else 
        {
            $menu = $this->Demande_realimentation_feffiManager->findAll();
            if ($men) 
            {
                foreach ($menu as $key => $value) 
                {
                    $convention_cife_entete= array();
                    $convention_cife_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_cife_entete);
                    $tranche_deblocage_feffi = $this->Tranche_deblocage_feffiManager->findById($value->id_convention_cife_entete);
                    $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_cife_entete->id_feffi);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['compte_feffi'] = $compte_feffi;
                    $data[$key]['tranche'] = $tranche_deblocage_feffi;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_cife_entete'] = $convention_cife_entete;
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
                    'id_tranche_deblocage_feffi' => $this->post('id_tranche_deblocage_feffi'),
                    'prevu' => $this->post('prevu'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'date_approbation' => $this->post('date_approbation'),
                    'date' => $this->post('date'),
                    'validation' => $this->post('validation'),
                    'id_convention_cife_entete' => $this->post('id_convention_cife_entete')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_realimentation_feffiManager->add($data);
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
                    'id_tranche_deblocage_feffi' => $this->post('id_tranche_deblocage_feffi'),
                    'prevu' => $this->post('prevu'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'date_approbation' => $this->post('date_approbation'),
                    'date' => $this->post('date'),
                    'validation' => $this->post('validation'),
                    'id_convention_cife_entete' => $this->post('id_convention_cife_entete')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_realimentation_feffiManager->update($id, $data);
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
            $delete = $this->Demande_realimentation_feffiManager->delete($id);         
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
