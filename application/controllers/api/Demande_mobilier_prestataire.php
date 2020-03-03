<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_mobilier_prestataire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_mobilier_prestataire_model', 'Demande_mobilier_prestataireManager');
        $this->load->model('mobilier_construction_model', 'mobilier_constructionManager');
        $this->load->model('tranche_demande_mobilier_mpe_model', 'Tranche_demande_mobilier_mpeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_mobilier_construction = $this->get('id_mobilier_construction');
        $menu = $this->get('menu');
        if ($menu=="getdemandeValidetechnique")
        {
            $tmp = $this->Demande_mobilier_prestataireManager->findAllValidetechnique();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);
                    $tranche_demande_mobilier_mpe = $this->Tranche_demande_mobilier_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['mobilier_construction'] = $mobilier_construction;
                   
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeValide")
        {
            $tmp = $this->Demande_mobilier_prestataireManager->findAllValide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);
                    $tranche_demande_mobilier_mpe = $this->Tranche_demande_mobilier_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['mobilier_construction'] = $mobilier_construction;
                    $data[$key]['date_approbation'] = $value->date_approbation; 
                   
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeValidebcaf")
        {
            $tmp = $this->Demande_mobilier_prestataireManager->findAllValidebcaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);
                    $tranche_demande_mobilier_mpe = $this->Tranche_demande_mobilier_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['mobilier_construction'] = $mobilier_construction;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeInvalide")
        {
            $tmp = $this->Demande_mobilier_prestataireManager->findAllInvalide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);
                    $tranche_demande_mobilier_mpe = $this->Tranche_demande_mobilier_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['mobilier_construction'] = $mobilier_construction;

                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $demande_mobilier_prestataire = $this->Demande_mobilier_prestataireManager->findById($id);
            $mobilier_construction = $this->mobilier_constructionManager->findById($demande_mobilier_prestataire->id_mobilier_construction);
            $tranche_demande_mobilier_mpe = $this->Tranche_demande_mobilier_mpeManager->findById($demande_mobilier_prestataire->id_tranche_demande_mpe);
            $data['id'] = $demande_mobilier_prestataire->id;
            $data['objet'] = $demande_mobilier_prestataire->objet;
            $data['description'] = $demande_mobilier_prestataire->description;
            $data['ref_facture'] = $demande_mobilier_prestataire->ref_facture;
            $data['montant'] = $demande_mobilier_prestataire->montant;
            $data['tranche_demande_mobilier_mpe'] = $tranche_demande_mobilier_mpe;
            $data['cumul'] = $demande_mobilier_prestataire->cumul;
            $data['anterieur'] = $demande_mobilier_prestataire->anterieur;
            $data['reste'] = $demande_mobilier_prestataire->reste;
            $data['date'] = $demande_mobilier_prestataire->date;
            $data['mobilier_construction'] = $mobilier_construction;
        } 
        else 
        {
            $menu = $this->Demande_mobilier_prestataireManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);
                    $tranche_demande_mobilier_mpe = $this->Tranche_demande_mobilier_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['mobilier_construction'] = $mobilier_construction;

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
                    'description' => $this->post('description'),
                    'ref_facture' => $this->post('ref_facture'),
                    'date' => $this->post('date'),
                    'montant' => $this->post('montant'),
                    'id_tranche_demande_mpe' => $this->post('id_tranche_demande_mpe'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'id_mobilier_construction' => $this->post('id_mobilier_construction'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_mobilier_prestataireManager->add($data);
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
                    'description' => $this->post('description'),
                    'ref_facture' => $this->post('ref_facture'),
                    'montant' => $this->post('montant'),
                    'id_tranche_demande_mpe' => $this->post('id_tranche_demande_mpe'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'date' => $this->post('date'),
                    'id_mobilier_construction' => $this->post('id_mobilier_construction'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_mobilier_prestataireManager->update($id, $data);
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
            $delete = $this->Demande_mobilier_prestataireManager->delete($id);         
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
