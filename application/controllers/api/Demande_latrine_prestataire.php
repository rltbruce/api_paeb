<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_latrine_prestataire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_latrine_prestataire_model', 'Demande_latrine_prestataireManager');
        $this->load->model('latrine_construction_model', 'Latrine_constructionManager');
        $this->load->model('tranche_demande_latrine_mpe_model', 'Tranche_demande_latrine_mpeManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('type_latrine_model', 'Type_latrineManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_latrine_construction = $this->get('id_latrine_construction');
        $id_cisco = $this->get('id_cisco');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');
        if ($menu=="getdemandeBycontrat")
        {
            $tmp = $this->Demande_latrine_prestataireManager->finddemandeBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandevalideBycontrat")
        {
            $tmp = $this->Demande_latrine_prestataireManager->finddemandevalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeinvalideBycontrat")
        {
            $tmp = $this->Demande_latrine_prestataireManager->finddemandeinvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandevalidebcafBycontrat")
        {
            $tmp = $this->Demande_latrine_prestataireManager->finddemandevalidebcafBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;

                }
            } 
                else
                    $data = array();
        }
        /*if ($menu=="getdemandedisponibleBycontrat")
        {
            $tmp = $this->Demande_latrine_prestataireManager->finddemandedisponibleBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($value->id_tranche_demande_mpe);

                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getalldemandeBycontrat")
        {
            $tmp = $this->Demande_latrine_prestataireManager->finddemandeBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$latrine_construction= array();
                    //$latrine_construction = $this->latrine_constructionManager->findById($value->id_latrine_construction);
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    $data[$key]['validation'] = $value->validation;
                   
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeValidetechnique")
        {
            $tmp = $this->Demande_latrine_prestataireManager->findAllValidetechnique();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$latrine_construction= array();
                    //$latrine_construction = $this->latrine_constructionManager->findById($value->id_latrine_construction);
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    $data[$key]['validation'] = $value->validation;
                   
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeValideBycisco")
        {
            $tmp = $this->Demande_latrine_prestataireManager->findAllValideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {                    
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    $data[$key]['validation'] = $value->validation; 
                   
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeValidebcaf")
        {
            $tmp = $this->Demande_latrine_prestataireManager->findAllValidebcaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {                    
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    $data[$key]['validation'] = $value->validation;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeInvalideBycisco")
        {
            $tmp = $this->Demande_latrine_prestataireManager->findAllInvalideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {                    
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($value->id_tranche_demande_mpe);
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    $data[$key]['validation'] = $value->validation;

                }
            } 
                else
                    $data = array();
        }*/
        elseif ($id)
        {
            $data = array();
            $demande_latrine_prestataire = $this->Demande_latrine_prestataireManager->findById($id);
            $contrat_prestataire = $this->Contrat_prestataireManager->findById($demande_latrine_prestataire->id_contrat_prestataire);
            $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($demande_latrine_prestataire->id_tranche_demande_mpe);
            $data['id'] = $demande_latrine_prestataire->id;
            $data['objet'] = $demande_latrine_prestataire->objet;
            $data['description'] = $demande_latrine_prestataire->description;
            $data['ref_facture'] = $demande_latrine_prestataire->ref_facture;
            $data['montant'] = $demande_latrine_prestataire->montant;
            $data['tranche_demande_latrine_mpe'] = $tranche_demande_latrine_mpe;
            $data['cumul'] = $demande_latrine_prestataire->cumul;
            $data['anterieur'] = $demande_latrine_prestataire->anterieur;
            $data['reste'] = $demande_latrine_prestataire->reste;
            $data['date'] = $demande_latrine_prestataire->date;
            $data['contrat_prestataire'] = $contrat_prestataire;
            $data['validation'] = $demande_latrine_prestataire->validation;
        } 
        else 
        {
            $menu = $this->Demande_latrine_prestataireManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {                    
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $tranche_demande_latrine_mpe = $this->Tranche_demande_latrine_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    $data[$key]['validation'] = $value->validation;

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
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_latrine_prestataireManager->add($data);
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
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_latrine_prestataireManager->update($id, $data);
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
            $delete = $this->Demande_latrine_prestataireManager->delete($id);         
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
