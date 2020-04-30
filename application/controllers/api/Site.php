<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Site extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('site_model', 'SiteManager');
        $this->load->model('ecole_model', 'EcoleManager');
        $this->load->model('classification_site_model', 'Classification_siteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_ecole = $this->get('id_ecole');
        $id_feffi = $this->get('id_feffi');
        $menu = $this->get('menu');
            
        if ($menu=='getsitecreeByfeffi') 
        {   $data = array();
            $tmp = $this->SiteManager->findsitecreeByfeffi($id_feffi);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                    $data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['agence_acc'] = $value->agence_acc;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                
                }
            }
        }
        elseif ($id_ecole) 
        {   $data = array();
            $tmp = $this->SiteManager->findByecole($id_ecole);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = array();
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                    $data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['agence_acc'] = $value->agence_acc;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $site = $this->SiteManager->findById($id);
            $ecole = $this->EcoleManager->findById($site->id_ecole);
            $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
            $data['id'] = $site->id;
            $data['code_sous_projet'] = $site->code_sous_projet;
            $data['objet_sous_projet'] = $site->objet_sous_projet;
            $data['denomination_epp'] = $site->denomination_epp;
            $data['agence_acc'] = $site->agence_acc;
            $data['statu_convention'] = $site->statu_convention;
            $data['observation'] = $site->observation;
            $data['ecole'] = $ecole;
            $data['classification_site'] = $classification_site;
        } 
        else 
        {
            $tmp = $this->SiteManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = array();
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                    $data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['agence_acc'] = $value->agence_acc;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
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
                    'code_sous_projet' => $this->post('code_sous_projet'),
                    'objet_sous_projet' => $this->post('objet_sous_projet'),
                    'denomination_epp' => $this->post('denomination_epp'),
                    'agence_acc' => $this->post('agence_acc'),
                    'statu_convention' => $this->post('statu_convention'),
                    'observation' => $this->post('observation'),
                    'id_ecole' => $this->post('id_ecole'),
                    'id_classification_site' => $this->post('id_classification_site')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->SiteManager->add($data);
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
                    'code_sous_projet' => $this->post('code_sous_projet'),
                    'objet_sous_projet' => $this->post('objet_sous_projet'),
                    'denomination_epp' => $this->post('denomination_epp'),
                    'agence_acc' => $this->post('agence_acc'),
                    'statu_convention' => $this->post('statu_convention'),
                    'observation' => $this->post('observation'),
                    'id_ecole' => $this->post('id_ecole'),
                    'id_classification_site' => $this->post('id_classification_site')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->SiteManager->update($id, $data);
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
            $delete = $this->SiteManager->delete($id);         
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
