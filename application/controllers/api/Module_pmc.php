<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Module_pmc extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('module_pmc_model', 'Module_pmcManager');
        $this->load->model('contrat_partenaire_relai_model', 'Contrat_partenaire_relaiManager');
        $this->load->model('participant_pmc_model', 'Participant_pmcManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_partenaire_relai = $this->get('id_contrat_partenaire_relai');
        $menu = $this->get('menu');

        if ($menu=='getmoduleBycontrat')
         {
            $tmp = $this->Module_pmcManager->findmoduleBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_pmcManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_pmcManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getmodulevalideBycontrat')
         {
            $tmp = $this->Module_pmcManager->findvalideBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_pmcManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_pmcManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getmoduleinvalideBycontrat')
         {
            $tmp = $this->Module_pmcManager->findinvalideBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_pmcManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_pmcManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }
        /* if ($menu=='getmodule_pmcByinvalide')
         {
            $menu = $this->Module_pmcManager->findAllByinvalide();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_pmcManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_pmcManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getmodule_pmcByDate')
         {
            $menu = $this->Module_pmcManager->findAllBydate();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_pmcManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_pmcManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getmodule_pmcBycontrat')
         {
            $menu = $this->Module_pmcManager->findAllBycontrat($id_contrat_partenaire_relai);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_pmcManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_pmcManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                    $data[$key]['validation']   = $value->validation;
                        }
            } 
                else
                    $data = array();
        } */  
        elseif ($id)
        {
            $data = array();
            $module_pmc = $this->Module_pmcManager->findById($id);

            $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($module_pmc->id_contrat_partenaire_relai);
            $nbr_parti= $this->Participant_pmcManager->count_participantbyId($module_pmc->id);
            $nbr_feminin= $this->Participant_pmcManager->count_femininbyId($module_pmc->id);

            $data['id'] = $module_pmc->id;
            $data['date_debut_previ_form'] = $module_pmc->date_debut_previ_form;
            $data['date_fin_previ_form']   = $module_pmc->date_fin_previ_form;
            $data['date_previ_resti']    = $module_pmc->date_previ_resti;
            $data['date_debut_reel_form'] = $module_pmc->date_debut_reel_form;
            $data['date_fin_reel_form'] = $module_pmc->date_fin_reel_form;
            $data['date_reel_resti'] = $module_pmc->date_reel_resti;
            $data['nbr_previ_parti']   = $module_pmc->nbr_previ_parti;
            $data['nbr_parti']    = $nbr_parti->nbr_participant;
            $data['nbr_previ_fem_parti']   = $module_pmc->nbr_previ_fem_parti;
            $data['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
            $data['lieu_formation'] = $module_pmc->lieu_formation;
            $data['observation']   = $module_pmc->observation;
            $data['contrat_partenaire_relai'] = $contrat_partenaire_relai;
            $data['validation']   = $module_pmc->validation;
        } 
        else 
        {
            $menu = $this->Module_pmcManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $nbr_parti= $this->Participant_pmcManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_pmcManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                    $data[$key]['validation']   = $value->validation;
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
                    'date_debut_previ_form' => $this->post('date_debut_previ_form'),
                    'date_fin_previ_form'   => $this->post('date_fin_previ_form'),
                    'date_previ_resti'    => $this->post('date_previ_resti'),
                    'date_debut_reel_form' => $this->post('date_debut_reel_form'),
                    'date_fin_reel_form' => $this->post('date_fin_reel_form'),
                    'date_reel_resti' => $this->post('date_reel_resti'),
                    'nbr_previ_parti'   => $this->post('nbr_previ_parti'),
                    //'nbr_parti'    => $this->post('nbr_parti'),
                    'nbr_previ_fem_parti'   => $this->post('nbr_previ_fem_parti'),
                    'validation' => $this->post('validation'),
                    'lieu_formation' => $this->post('lieu_formation'),
                    'observation' => $this->post('observation'),
                    'id_contrat_partenaire_relai' => $this->post('id_contrat_partenaire_relai'),
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Module_pmcManager->add($data);
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
                    'date_debut_previ_form' => $this->post('date_debut_previ_form'),
                    'date_fin_previ_form'   => $this->post('date_fin_previ_form'),
                    'date_previ_resti'    => $this->post('date_previ_resti'),
                    'date_debut_reel_form' => $this->post('date_debut_reel_form'),
                    'date_fin_reel_form' => $this->post('date_fin_reel_form'),
                    'date_reel_resti' => $this->post('date_reel_resti'),
                    'nbr_previ_parti'   => $this->post('nbr_previ_parti'),
                    'nbr_parti'    => $this->post('nbr_parti'),
                    'nbr_previ_fem_parti'   => $this->post('nbr_previ_fem_parti'),
                    'validation' => $this->post('validation'),
                    'lieu_formation' => $this->post('lieu_formation'),
                    'observation' => $this->post('observation'),
                    'id_contrat_partenaire_relai' => $this->post('id_contrat_partenaire_relai'),
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Module_pmcManager->update($id, $data);
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
            $delete = $this->Module_pmcManager->delete($id);         
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
