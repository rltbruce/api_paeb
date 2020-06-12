

<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Attachement_travaux extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('attachement_travaux_model', 'Attachement_travauxManager');
        $this->load->model('facture_mpe_model', 'Facture_mpeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_facture_mpe = $this->get('id_facture_mpe');
        $menu = $this->get('menu');

        if ($menu=="getattachement_travauxBycontrat")
        {
            $tmp = $this->Attachement_travauxManager->findattachement_travauxBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;            } 
                else
                    $data = array();
        }
        elseif ($menu=="getattachement_prevuBycontrat")
        {
            $tmp = $this->Attachement_travauxManager->findmontant_attachement_prevuBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;            } 
                else
                    $data = array();
        }
        elseif ($menu=="getattachement_travauxByfacture")
        {
            $tmp = $this->Attachement_travauxManager->findattachement_travauxByfacture($id_facture_mpe);
            if ($tmp) 
            {
                $data = $tmp;            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $attachement_travaux = $this->Attachement_travauxManager->findById($id);
            $data['id'] = $attachement_travaux->id;
            $data['numero'] = $attachement_travaux->numero;
            $data['date_fin'] = $attachement_travaux->date_fin;
            $data['date_debut'] = $attachement_travaux->date_debut;
            $data['total_prevu'] = $attachement_travaux->total_prevu;
            $data['total_cumul'] = $attachement_travaux->total_cumul;
            $data['total_anterieur'] = $attachement_travaux->total_anterieur;
            $data['total_periode'] = $attachement_travaux->total_periode;
            $data['id_facture_mpe'] = $attachement_travaux->id_facture_mpe;
        } 
        else 
        {
            $tmp = $this->Attachement_travauxManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
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
                    'numero' => $this->post('numero'),
                    'date_fin' => $this->post('date_fin'),
                    'date_debut' => $this->post('date_debut'),
                    'total_prevu' => $this->post('total_prevu'),
                    'total_anterieur' => $this->post('total_anterieur'),
                    'total_cumul' => $this->post('total_cumul'),
                    'total_periode' => $this->post('total_periode'),
                    'id_facture_mpe' => $this->post('id_facture_mpe'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Attachement_travauxManager->add($data);
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
                    'numero' => $this->post('numero'),
                    'date_fin' => $this->post('date_fin'),
                    'date_debut' => $this->post('date_debut'),
                    'total_prevu' => $this->post('total_prevu'),
                    'total_anterieur' => $this->post('total_anterieur'),
                    'total_cumul' => $this->post('total_cumul'),
                    'total_periode' => $this->post('total_periode'),
                    'id_facture_mpe' => $this->post('id_facture_mpe'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Attachement_travauxManager->update($id, $data);
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
            $delete = $this->Attachement_travauxManager->delete($id);         
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
