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
        $this->load->model('convention_ufp_daaf_entete_model', 'Convention_ufp_daaf_enteteManager');
       // $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        //$this->load->model('compte_feffi_model', 'Compte_feffiManager');
        $this->load->model('ecole_model', 'EcoleManager');
        $this->load->model('avancement_batiment_model', 'Avancement_batimentManager');
        $this->load->model('avancement_latrine_model', 'Avancement_latrineManager');
        $this->load->model('avancement_mobilier_model', 'Avancement_mobilierManager');

        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('latrine_construction_model', 'Latrine_constructionManager');
        $this->load->model('mobilier_construction_model', 'Mobilier_constructionManager');
        $this->load->model('cout_divers_construction_model', 'Cout_divers_constructionManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');       
        $menu = $this->get('menu');
        $id_convention_ufpdaaf = $this->get('id_convention_ufpdaaf');
        $id_feffi = $this->get('id_feffi');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        
        if ($menu=='getconvention_enteteBycontrat_prestataire')
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAllValideByid_contrat_prestataire($id_contrat_prestataire);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $avancement = 0;
                    $montant = 0;
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     if (count($montant_detail)>0)
                   {
                      $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_divers; 
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;


                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventionvalideByfeffi')
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAllValideByfeffi($id_feffi);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $avancement = 0;
                    $montant = 0;
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id); 
                    if (count($avancement_detail)>0)
                   {
       
                     $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     if (count($montant_detail)>0)
                   {
                      $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_divers; 
                    }

                    

                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;

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
                    $avancement = 0;
                    $montant = 0;
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     if (count($montant_detail)>0)
                   {
                      $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_divers; 
                    } 

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                    
                    $data[$key]['ref_financement'] = $value->ref_financement;
                   
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['avancement'] = $avancement ; 
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
                    $avancement = 0;
                    $montant = 0;
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if ($avancement_detail)
                    {
                        if (count($avancement_detail)>0)
                       {
                          $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                        }
                    }
                    
                    if ($montant_detail)
                    {
                        if (count($montant_detail)>0)
                       {
                          $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_divers; 
                        } 
                    }
                                       
                                        
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['avancement'] = $avancement ; 
                     $data[$key]['ecole'] = $ecole;
                   
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventioninvalidedaaf')
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAllInvalidedaaf();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $avancement = 0;
                    $montant = 0;
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     if (count($montant_detail)>0)
                   {
                      $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_divers; 
                    }                    
                                        
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['avancement'] = $avancement ; 
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
                    $avancement = 0;
                    $montant = 0;
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     if (count($montant_detail)>0)
                   {
                      $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_divers; 
                    }
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                    
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['avancement'] = $avancement ; 
                     $data[$key]['ecole'] = $ecole;
                    if($value->id_convention_ufpdaaf)
                    {
                      $convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($value->id_convention_ufpdaaf);
                      $data[$key]['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;

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
                    $avancement = 0;
                    $montant = 0;
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     if (count($montant_detail)>0)
                   {
                      $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_divers; 
                    }
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['avancement'] = $avancement ; 
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
                    $avancement = 0;
                    $montant = 0;
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     if (count($montant_detail)>0)
                   {
                      $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_divers; 
                    }
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['avancement'] = $round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ;
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
