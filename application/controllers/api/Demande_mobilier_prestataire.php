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
        $this->load->model('tranche_demande_mpe_model', 'Tranche_demande_mpeManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('type_mobilier_model', 'Type_mobilierManager');
        $this->load->model('facture_mpe_model', 'Facture_mpeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_mobilier_construction = $this->get('id_mobilier_construction');
        $id_cisco = $this->get('id_cisco');
        $id_attachement_travaux = $this->get('id_attachement_travaux');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');

        if ($menu=="getdemandeByattachement")
        {
            $tmp = $this->Demande_mobilier_prestataireManager->finddemandeByattachement($id_attachement_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['id_attachement_travaux'] = $value->id_attachement_travaux;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeBycontrat")
        {
            $tmp = $this->Demande_mobilier_prestataireManager->finddemandeBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $facture_mpe = $this->Facture_mpeManager->findByAttachement_travaux($value->id_attachement_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['id_attachement_travaux'] = $value->id_attachement_travaux;
                    $data[$key]['facture_mpe'] = $facture_mpe;

                }
            } 
                else
                    $data = array();
        }

      /*  if ($menu=="getdemandeBycontrat")
        {
            $tmp = $this->Demande_mobilier_prestataireManager->finddemandeBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
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
            $tmp = $this->Demande_mobilier_prestataireManager->finddemandevalidebcafBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
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
            $tmp = $this->Demande_mobilier_prestataireManager->finddemandevalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
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
            $tmp = $this->Demande_mobilier_prestataireManager->finddemandeinvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
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
        }*/
        elseif ($id)
        {
            $data = array();
            $demande_mobilier_prestataire = $this->Demande_mobilier_prestataireManager->findById($id);
            $mobilier_construction = $this->mobilier_constructionManager->findById($demande_mobilier_prestataire->id_mobilier_construction);
            $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($demande_mobilier_prestataire->id_tranche_demande_mpe);
            $data['id'] = $demande_mobilier_prestataire->id;
            $data['montant'] = $demande_mobilier_prestataire->montant;
            $data['tranche_demande_mpe'] = $tranche_demande_mpe;
            $data['cumul'] = $demande_mobilier_prestataire->cumul;
            $data['anterieur'] = $demande_mobilier_prestataire->anterieur;
            $data['reste'] = $demande_mobilier_prestataire->reste;
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
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;

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
                    'montant' => $this->post('montant'),
                    'id_tranche_demande_mpe' => $this->post('id_tranche_demande_mpe'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'id_attachement_travaux' => $this->post('id_attachement_travaux')
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
                    'montant' => $this->post('montant'),
                    'id_tranche_demande_mpe' => $this->post('id_tranche_demande_mpe'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'id_attachement_travaux' => $this->post('id_attachement_travaux')
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
