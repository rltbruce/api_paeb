<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Module_sep extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('module_sep_model', 'Module_sepManager');
        $this->load->model('contrat_partenaire_relai_model', 'Contrat_partenaire_relaiManager');
        $this->load->model('participant_sep_model', 'Participant_sepManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_partenaire_relai = $this->get('id_contrat_partenaire_relai');
        $menu = $this->get('menu');

         if ($menu=='getmodule_sepByinvalide')
         {
            $menu = $this->Module_sepManager->findAllByinvalide();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_sepManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_sepManager->count_femininbyId($value->id);

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
        elseif ($menu=='getmodule_sepByDate')
         {
            $menu = $this->Module_sepManager->findAllBydate();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_sepManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_sepManager->count_femininbyId($value->id);

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
        elseif ($menu=='getmodule_sepBycontrat')
         {
            $menu = $this->Module_sepManager->findAllBycontrat($id_contrat_partenaire_relai);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_sepManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_sepManager->count_femininbyId($value->id);

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
        elseif ($id)
        {
            $data = array();
            $module_sep = $this->Module_sepManager->findById($id);

            $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($module_sep->id_contrat_partenaire_relai);
            $nbr_parti= $this->Participant_sepManager->count_participantbyId($module_sep->id);
            $nbr_feminin= $this->Participant_sepManager->count_femininbyId($module_sep->id);

            $data['id'] = $module_sep->id;
            $data['date_debut_previ_form'] = $module_sep->date_debut_previ_form;
            $data['date_fin_previ_form']   = $module_sep->date_fin_previ_form;
            $data['date_previ_resti']    = $module_sep->date_previ_resti;
            $data['date_debut_reel_form'] = $module_sep->date_debut_reel_form;
            $data['date_fin_reel_form'] = $module_sep->date_fin_reel_form;
            $data['date_reel_resti'] = $module_sep->date_reel_resti;
            $data['nbr_previ_parti']   = $module_sep->nbr_previ_parti;
            $data['nbr_parti']    = $nbr_parti->nbr_participant;
            $data['nbr_previ_fem_parti']   = $module_sep->nbr_previ_fem_parti;
            $data['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
            $data['lieu_formation'] = $module_sep->lieu_formation;
            $data['observation']   = $module_sep->observation;
            $data['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                    $data['validation']   = $module_sep->validation;
        } 
        else 
        {
            $menu = $this->Module_sepManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $nbr_parti= $this->Participant_sepManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_sepManager->count_femininbyId($value->id);

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
                $dataId = $this->Module_sepManager->add($data);
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
                    //'nbr_parti'    => $this->post('nbr_parti'),
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
                $update = $this->Module_sepManager->update($id, $data);
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
            $delete = $this->Module_sepManager->delete($id);         
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
