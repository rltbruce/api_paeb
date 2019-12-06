<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_model', 'ConventionManager');
        $this->load->model('cisco_model', 'CiscoManager');
        $this->load->model('association_model', 'AssociationManager');
        $this->load->model('categorie_ouvrage_model', 'Categorie_ouvrageManager');
        $this->load->model('ouvrage_model', 'OuvrageManager');
        $this->load->model('programmation_model', 'ProgrammationManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_programmation = $this->get('id_programmation');
        $validation = $this->get('validation');
        $menu = $this->get('menu');
        if ($menu=='getconventioninvalide')
        {
            $menu = $this->ConventionManager->findAllInvalide();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $convention = array();
                    $cisco = array();
                    $association = array();
                    $categorie_ouvrage = array();
                    $ouvrage = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $association = $this->AssociationManager->findById($value->id_association);
                    $categorie_ouvrage = $this->Categorie_ouvrageManager->findById($value->id_categorie_ouvrage);
                    $ouvrage = $this->OuvrageManager->findById($value->id_ouvrage);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;

                    $data[$key]['numero_convention'] = $value->numero_convention;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['association'] = $association;
                    $data[$key]['categorie_ouvrage'] = $categorie_ouvrage;
                    $data[$key]['ouvrage'] = $ouvrage;
                    $data[$key]['montant_prevu'] = $value->montant_prevu;
                    $data[$key]['montant_reel'] = $value->montant_reel;
                    $data[$key]['date'] = $value->date;
                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventionvalide')
        {
            $menu = $this->ConventionManager->findByProgrammationValide($id_programmation);

            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $convention = array();
                    $cisco = array();
                    $association = array();
                    $categorie_ouvrage = array();
                    $ouvrage = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $association = $this->AssociationManager->findById($value->id_association);
                    $categorie_ouvrage = $this->Categorie_ouvrageManager->findById($value->id_categorie_ouvrage);
                    $ouvrage = $this->OuvrageManager->findById($value->id_ouvrage);
                    $programmation = $this->ProgrammationManager->findById($value->id_programmation);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;

                    $data[$key]['numero_convention'] = $value->numero_convention;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['association'] = $association;
                    $data[$key]['categorie_ouvrage'] = $categorie_ouvrage;
                    $data[$key]['ouvrage'] = $ouvrage;
                    $data[$key]['montant_prevu'] = $value->montant_prevu;
                    $data[$key]['montant_reel'] = $value->montant_reel;
                    $data[$key]['date'] = $value->date;                    
                    $data[$key]['programmation'] = $programmation;
                    
                }
            }else{
                $data = array();
            }
                    
        }
        elseif ($id)
        {
            $data = array();
            $convention = $this->ConventionManager->findById($id);
            $cisco = $this->CiscoManager->findById($convention->id_cisco);
            $association = $this->AssociationManager->findById($convention->id_association);
            $categorie_ouvrage = $this->Categorie_ouvrageManager->findById($convention->id_categorie_ouvrage);
            if ($convention->id_programmation!=0 && $convention->id_programmation!=null)
            {
              $programmation = $this->ProgrammationManager->findById($convention->id_programmation);
              $data['programmation'] = $convention->programmation;
            }
            $Ouvrage = $this->OuvrageManager->findById($convention->id_ouvrage);
            $data['id'] = $convention->id;
            $data['numero_convention'] = $convention->numero_convention;
            $data['description'] = $convention->description;
            $data['cisco'] = $cisco;
            $data['association'] = $association;
            $data['categorie_ouvrage'] = $categorie_ouvrage;
            $data['ouvrage'] = $ouvrage;
            $data['montant_prevu'] = $convention->montant_prevu;
            $data['montant_reel'] = $convention->montant_reel;
            $data['date'] = $convention->date;
        } 
        else 
        {
            $menu = $this->ConventionManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $convention = array();
                    $cisco = array();
                    $association = array();
                    $categorie_ouvrage = array();
                    $ouvrage = array();
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $association = $this->AssociationManager->findById($value->id_association);
                    $categorie_ouvrage = $this->Categorie_ouvrageManager->findById($value->id_categorie_ouvrage);
                    $ouvrage = $this->OuvrageManager->findById($value->id_ouvrage);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;

                    $data[$key]['numero_convention'] = $value->numero_convention;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['association'] = $association;
                    $data[$key]['categorie_ouvrage'] = $categorie_ouvrage;
                    $data[$key]['ouvrage'] = $ouvrage;
                    $data[$key]['montant_prevu'] = $value->montant_prevu;
                    $data[$key]['montant_reel'] = $value->montant_reel;
                    $data[$key]['date'] = $value->date;
                    if ($value->id_programmation!=0 && $value->id_programmation!=null)
                    {
                      $programmation = $this->ProgrammationManager->findById($value->id_programmation);
                      $data[$key]['programmation'] = $programmation;
                    }
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
                    'numero_convention' => $this->post('numero_convention'),
                    'description' => $this->post('description'),
                    'id_categorie_ouvrage' => $this->post('id_categorie_ouvrage'),
                    'id_ouvrage' => $this->post('id_ouvrage'),
                    'id_cisco' => $this->post('id_cisco'),
                    'id_association' => $this->post('id_association'),
                    'montant_prevu' => $this->post('montant_prevu'),
                    'montant_reel' => $this->post('montant_reel'),
                    'date' => $this->post('date'),
                    'validation' => $this->post('validation'),
                    'id_programmation' => $this->post('id_programmation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->ConventionManager->add($data);
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
                    'numero_convention' => $this->post('numero_convention'),
                    'description' => $this->post('description'),
                    'id_categorie_ouvrage' => $this->post('id_categorie_ouvrage'),
                    'id_ouvrage' => $this->post('id_ouvrage'),
                    'id_cisco' => $this->post('id_cisco'),
                    'id_association' => $this->post('id_association'),
                    'montant_prevu' => $this->post('montant_prevu'),
                    'montant_reel' => $this->post('montant_reel'),
                    'date' => $this->post('date'),
                    'validation' => $this->post('validation'),
                    'id_programmation' => $this->post('id_programmation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->ConventionManager->update($id, $data);
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
            $delete = $this->ConventionManager->delete($id);         
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
