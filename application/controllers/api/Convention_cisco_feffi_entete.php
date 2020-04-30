<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention_cisco_feffi_entete extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('cisco_model', 'CiscoManager');
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('Site_model', 'SiteManager');
        $this->load->model('ecole_model', 'EcoleManager');

        $this->load->model('convention_cisco_feffi_detail_model', 'Convention_cisco_feffi_detailManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');        
        $this->load->model('convention_ufp_daaf_entete_model', 'Convention_ufp_daaf_enteteManager');

        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('latrine_construction_model', 'Latrine_constructionManager');
        $this->load->model('mobilier_construction_model', 'Mobilier_constructionManager');
        
        $this->load->model('avancement_batiment_model', 'Avancement_batimentManager');
        $this->load->model('avancement_latrine_model', 'Avancement_latrineManager');
        $this->load->model('avancement_mobilier_model', 'Avancement_mobilierManager');

        $this->load->model('demande_realimentation_feffi_model', 'Demande_realimentation_feffiManager');

        $this->load->model('decaiss_fonct_feffi_model', 'Decaiss_fonct_feffiManager');
       /* $this->load->model('transfert_reliquat_model', 'Transfert_reliquatManager');
        $this->load->model('phase_sous_projets_model', 'Phase_sous_projetsManager');
        $this->load->model('phase_sous_projet_construction_model', 'Phase_sous_projet_constructionManager');
        $this->load->model('mpe_soumissionaire_model', 'Mpe_soumissionaireManager');
        $this->load->model('participant_emies_model', 'Participant_emiesManager');
        $this->load->model('participant_sep_model', 'Participant_sepManager');
        $this->load->model('participant_gfpc_model', 'Participant_gfpcManager');
        $this->load->model('participant_pmc_model', 'Participant_pmcManager');
        $this->load->model('participant_odc_model', 'Participant_odcManager');
        $this->load->model('participant_dpp_model', 'Participant_dppManager');
        $this->load->model('avenant_convention_model', 'Avenant_conventionManager');*/
       // $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        //$this->load->model('compte_feffi_model', 'Compte_feffiManager');
        /*
        $this->load->model('transfert_daaf_model', 'Transfert_daafManager');
        $this->load->model('Paiement_batiment_prestataire_model', 'Paiement_batiment_prestataireManager');
        $this->load->model('passation_marches_model', 'Passation_marchesManager');
        $this->load->model('passation_marches_be_model', 'Passation_marches_beManager');
        $this->load->model('passation_marches_pr_model', 'Passation_marches_prManager');
        $this->load->model('contrat_be_model', 'Contrat_beManager');
        $this->load->model('contrat_partenaire_relai_model', 'Contrat_partenaire_relaiManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('avenant_be_model', 'Avenant_beManager');
        $this->load->model('avenant_partenaire_relai_model', 'Avenant_partenaire_relaiManager');
        $this->load->model('avenant_prestataire_model', 'Avenant_prestataireManager');
        $this->load->model('module_dpp_model', 'Module_dppManager');
        $this->load->model('module_emies_model', 'Module_emiesManager');
        $this->load->model('module_gfpc_model', 'Module_gfpcManager');
        $this->load->model('module_odc_model', 'Module_odcManager');
        $this->load->model('module_pmc_model', 'Module_pmcManager');
        $this->load->model('module_sep_model', 'Module_sepManager');

        $this->load->model('appel_offre_model', 'Appel_offreManager');
        $this->load->model('Memoire_technique_model', 'Memoire_techniqueManager');
        $this->load->model('Manuel_gestion_model', 'Manuel_gestionManager');
        $this->load->model('Rapport_mensuel_model', 'Rapport_mensuelManager');
        $this->load->model('police_assurance_model', 'Police_assuranceManager');

        $this->load->model('reception_mpe_model', 'Reception_mpeManager');
        $this->load->model('paiement_batiment_pr_model', 'Paiement_batiment_prManager');
        $this->load->model('paiement_latrine_prestataire_model', 'Paiement_latrine_prestataireManager');
        $this->load->model('paiement_mobilier_prestataire_model', 'Paiement_mobilier_prestataireManager');
        $this->load->model('prestation_mpe_model', 'Prestation_mpeManager');*/
        $this->load->model('utilisateurs_model', 'UserManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');       
        $menu = $this->get('menu');
        $id_convention_ufpdaaf = $this->get('id_convention_ufpdaaf');
        $id_feffi = $this->get('id_feffi');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_cisco = $this->get('id_cisco');
        $id_ecole = $this->get('id_ecole');
        $id_convention_entete = $this->get('id_convention_entete');
        $date_today = $this->get('date_today');
        $date_signature = $this->get('date_signature');

        if ($menu=='getconventionvalideufpBydatenowwithcount') //mande       
         {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionvalideufpBydatenowwithcount($date_signature);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                    $countdemande_feffi_creer = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,0);
                    $countdemande_feffi_emidpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,1);
                    $countdemande_feffi_encourdpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,2);

                    $countdemande_feffi_emidaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,4);
                    $countdemande_feffi_encourdaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,5);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    $data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidpfi'] = $countdemande_feffi_emidpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdpfi'] = $countdemande_feffi_encourdpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidaaf'] = $countdemande_feffi_emidaaf[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdaaf'] = $countdemande_feffi_encourdaaf[0]->nbr_demande_feffi;

                    $data[$key]['nbr_decaiss_feffi'] = $countdecai_fonct_feffi[0]->nbr_decaiss;


                }
            } 
                else
                    $data = array();
        }elseif ($menu=='getconventioninvalideBycisco') //mande       
         {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllInvalideByid_cisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
         elseif ($id_convention_ufpdaaf)     //mande
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllByufpdaaf($id_convention_ufpdaaf);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                    
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;
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
        elseif ($menu=='getconventionvalidedaaf')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValidedaaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;
                   
                }
            } 
                else
                    $data = array();
        }elseif ($menu=='getconventionvalideufpBycisco')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValideByid_cisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventionvalideufpByciscowithcount')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValideufpByid_cisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    $countdemande_feffi_creer = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,0);
                    $countdemande_feffi_emidpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,1);
                    $countdemande_feffi_encourdpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,2);

                    $countdemande_feffi_emidaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,4);
                    $countdemande_feffi_encourdaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,5);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    $data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidpfi'] = $countdemande_feffi_emidpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdpfi'] = $countdemande_feffi_encourdpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidaaf'] = $countdemande_feffi_emidaaf[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdaaf'] = $countdemande_feffi_encourdaaf[0]->nbr_demande_feffi;

                    $data[$key]['nbr_decaiss_feffi'] = $countdecai_fonct_feffi[0]->nbr_decaiss;


                }
            } 
                else
                    $data = array();
        } 
       /* if ($menu=='getconventiondetailfiltreByid')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findByIdObjet($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $financierfeffi = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_bat =  0;
                    $montant_lat =  0;
                    $montant_mob =  0;
                    $montant_maitrise =0;
                    $montant_sousprojet =0;
                    $avancement =0;
                    $decaissement = 0;

                    $nbr_parti_dpp= array();
                    $nbr_feminin_dpp= array();

                    $nbr_parti_odc= array();
                    $nbr_feminin_odc= array();
                    
                    $nbr_parti_emies= array();
                    $nbr_feminin_emies= array();

                    $nbr_parti_gfpc= array();
                    $nbr_feminin_gfpc= array();

                    $nbr_parti_pmc= array();
                    $nbr_feminin_pmc= array();

                    $nbr_parti_sep= array();
                    $nbr_feminin_sep= array();

                    $commune = $this->CommuneManager->findByIdcisco($value->id_cisco);
                    $region = $this->RegionManager->findByIdcisco($value->id_cisco);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $convention_detail = $this->Convention_cisco_feffi_detailManager->getconvention_detailBytete($value->id);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    $avenant = $this->Avenant_conventionManager->getavenantvalideByconvention($value->id);
                    $paiement_daaf_feffi= $this->Transfert_daafManager->getpaiementByconvention($value->id);

                    $passation_pr= $this->Passation_marches_prManager->getpassationByconventionarray($value->id);
                    $passation_mpe= $this->Passation_marchesManager->getpassationByconvention($value->id);
                    $passation_moe= $this->Passation_marches_beManager->getpassationByconvention($value->id);

                    $contrat_moe= $this->Contrat_beManager->getcontratByconvention($value->id);
                    $contrat_pr= $this->Contrat_partenaire_relaiManager->getcontratByconvention($value->id);
                    $contrat_mpe= $this->Contrat_prestataireManager->getcontratByconvention($value->id);

                    $avenant_moe= $this->Avenant_beManager->getavenantBycontrat($contrat_moe[0]->id);
                    $avenant_pr= $this->Avenant_partenaire_relaiManager->getavenantBycontrat($contrat_mpe[0]->id);
                    $avenant_mpe= $this->Avenant_prestataireManager->getavenantBycontrat($contrat_pr[0]->id);
                    $paiement_batiment_pre= $this->Paiement_batiment_prestataireManager->getpaiementbat_mpeBycontrat($contrat_mpe[0]->id); 
                    $paiement_latrine_pre= $this->Paiement_latrine_prestataireManager->getpaiementlat_mpeBycontrat($contrat_mpe[0]->id);  
                    $paiement_mobilier_pre= $this->Paiement_mobilier_prestataireManager->getpaiementmob_mpeBycontrat($contrat_mpe[0]->id);                  

                    $module_dpp= $this->Module_dppManager->getmoduleBycontrat($contrat_pr[0]->id);
                    if ($module_dpp) {
                       $nbr_parti_dpp= $this->Participant_dppManager->count_participantbyId($module_dpp[0]->id);
                    $nbr_feminin_dpp= $this->Participant_dppManager->count_femininbyId($module_dpp[0]->id); 
                    }
                    

                    
                    $module_odc= $this->Module_odcManager->getmoduleBycontrat($contrat_pr[0]->id);
                    if ($module_odc) {
                       $nbr_parti_odc= $this->Participant_odcManager->count_participantbyId($module_odc[0]->id);
                    $nbr_feminin_odc= $this->Participant_odcManager->count_femininbyId($module_odc[0]->id); 
                    }
                    

                    $module_emies= $this->Module_emiesManager->getmoduleBycontrat($contrat_pr[0]->id);
                    if ($module_emies) {
                       $nbr_parti_emies= $this->Participant_emiesManager->count_participantbyId($module_emies[0]->id);
                    $nbr_feminin_emies= $this->Participant_emiesManager->count_femininbyId($module_emies[0]->id); 
                    }
                    

                    $module_gfpc= $this->Module_gfpcManager->getmoduleBycontrat($contrat_pr[0]->id);
                    if ($module_gfpc) {
                      $nbr_parti_gfpc= $this->Participant_gfpcManager->count_participantbyId($module_gfpc[0]->id);
                    $nbr_feminin_gfpc= $this->Participant_gfpcManager->count_femininbyId($module_gfpc[0]->id);  
                    }
                    

                    $module_pmc= $this->Module_pmcManager->getmoduleBycontrat($contrat_pr[0]->id);
                    if ($module_pmc) {
                       $nbr_parti_pmc= $this->Participant_pmcManager->count_participantbyId($module_pmc[0]->id);
                    $nbr_feminin_pmc= $this->Participant_pmcManager->count_femininbyId($module_pmc[0]->id); 
                    }
                    

                    $module_sep= $this->Module_sepManager->getmoduleBycontrat($contrat_pr[0]->id);
                    if ($module_sep) {
                       $nbr_parti_sep= $this->Participant_sepManager->count_participantbyId($module_sep[0]->id);
                    $nbr_feminin_sep= $this->Participant_sepManager->count_femininbyId($module_sep[0]->id); 
                    }
                    

                    $memoire_technique= $this->Memoire_techniqueManager->getmemoire_techniqueBycontrat($contrat_moe[0]->id,1);
                    $appel_offre= $this->Appel_offreManager->getappel_offreBycontrat($contrat_moe[0]->id,1);
                    $rapport_mensuel= $this->Rapport_mensuelManager->getrapport_mensuelBycontrat($contrat_moe[0]->id,1);
                    $manuel_gestion= $this->Manuel_gestionManager->getmanuel_gestionBycontrat($contrat_moe[0]->id,1);
                    $police_assurance= $this->Police_assuranceManager->getpolice_assuranceBycontrat($contrat_moe[0]->id,1);

                    $reception_mpe= $this->Reception_mpeManager->getreceptionBycontrat($contrat_mpe[0]->id);

                    $paiement_mpe_moe_fonct_pr= $this->Paiement_batiment_prestataireManager->getpaiementByconvention($value->id,1);

                    $prestation_mpe= $this->Prestation_mpeManager->getprestation_mpeBycontrat($contrat_mpe[0]->id);
                 
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $transfert_reliquat = $this->Transfert_reliquatManager->findtransfertvalideByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }                    

                    //$decaiss_fonct_feffi= $this->Decaiss_fonct_feffiManager->getsumdecaissementByconvention($value->id);

                    if ($paiement_daaf_feffi)
                    {   $cumul_feffi = 0;
                        
                        $financierfeffi=$paiement_daaf_feffi;
                        foreach ($paiement_daaf_feffi as $keypaifeffi => $valuepaifeffi)
                        {
                            if($valuepaifeffi->code=="tranche 1")
                            {
                                $data[$key]['paiement1_feffi'] = $valuepaifeffi->montant_transfert;
                                $data[$key]['date1_feffi'] = $valuepaifeffi->date_approbation;
                            }
                            if($valuepaifeffi->code=="tranche 2")
                            {
                                $data[$key]['paiement2_feffi'] = $valuepaifeffi->montant_transfert;
                                $data[$key]['date2_feffi'] = $valuepaifeffi->date_approbation;
                            }
                            if($valuepaifeffi->code=="tranche 3")
                            {
                                $data[$key]['paiement3_feffi'] = $valuepaifeffi->montant_transfert;
                                $data[$key]['date3_feffi'] = $valuepaifeffi->date_approbation;
                            }
                            $cumul_feffi = $cumul_feffi + $valuepaifeffi->montant_transfert;
                            $decaissement = $decaissement + $valuepaifeffi->pourcentage;
                            $data[$key]['cumul_feffi'] = $cumul_feffi;
                            $data[$key]['decaissement'] = $decaissement;
                        }
                        
                    }
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_bat =  $montant_detail[0]->montant_bat;
                        $montant_lat =  $montant_detail[0]->montant_lat;
                        $montant_mob =  $montant_detail[0]->montant_mob;
                        $montant_maitrise =$montant_detail[0]->montant_maitrise;
                        $montant_sousprojet =$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;                   
                    $data[$key]['convention_detail'] = $convention_detail;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_batiment'] = $montant_bat;
                    $data[$key]['montant_latrine'] = $montant_lat;
                    $data[$key]['montant_mobilier'] = $montant_mob;
                    $data[$key]['montant_maitrise'] = $montant_maitrise;
                    $data[$key]['montant_sousprojet'] = $montant_sousprojet;
                    $data[$key]['montant_depense'] = $montant_bat + $montant_lat + $montant_mob + $montant_maitrise;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['avenant_convention'] = $avenant;
                    $data[$key]['montant_apres_avenant'] = $montant + $avenant->montant;

                    $data[$key]['financierfeffi'] = $financierfeffi;

                    $data[$key]['paiement_prestataire_total'] = $paiement_mpe_moe_fonct_pr[0]->montant_total;
                    $data[$key]['decaissement_prestataire'] = ($paiement_mpe_moe_fonct_pr[0]->montant_total *100)/($contrat_mpe[0]->cout_batiment + $contrat_mpe[0]->cout_latrine +$contrat_mpe[0]->cout_mobilier +$contrat_moe[0]->montant_contrat);

                    $data[$key]['montant_fonct_feffi'] = $paiement_mpe_moe_fonct_pr[0]->montant_fonct_feffi;
                    $data[$key]['decaissement_fonct_feffi'] = round(($paiement_mpe_moe_fonct_pr[0]->montant_fonct_feffi*100)/($montant_sousprojet),4);

                    $data[$key]['montant_decaisser_total'] = $paiement_mpe_moe_fonct_pr[0]->montant_total + $paiement_mpe_moe_fonct_pr[0]->montant_fonct_feffi;

                    $data[$key]['reliquan_fon'] =$montant-($paiement_mpe_moe_fonct_pr[0]->montant_total + $paiement_mpe_moe_fonct_pr[0]->montant_fonct_feffi);

                    $data[$key]['passation_pr'] = $passation_pr;
                    $data[$key]['paiement_pr_total'] = $paiement_mpe_moe_fonct_pr[0]->montant_pr;
                    $data[$key]['decaissement_pr'] = ($paiement_mpe_moe_fonct_pr[0]->montant_pr *100)/($contrat_pr[0]->montant_contrat);
                    $data[$key]['montant_avenant'] = $avenant_pr[0]->montant_avenant;
                    $data[$key]['montant_apres_avenant_pr'] = $avenant_pr[0]->montant_avenant + $contrat_pr[0]->montant_contrat;
                    $data[$key]['contrat_pr'] = $contrat_pr[0];

                    if ($passation_mpe) {

                        $countmpe_soumissionaire = $this->Mpe_soumissionaireManager->countAllBympe_soumissionnaire($passation_mpe[0]->id);
                        $mpe_soumissionaire = $this->Mpe_soumissionaireManager->getmpe_soumissionnairebypass($passation_mpe[0]->id);
                        if ($countmpe_soumissionaire) {
                           $passation_mpe[0]->nbr_soumissionnaire = $countmpe_soumissionaire[0]->nbr;
                        }
                        if ($mpe_soumissionaire) {
                           $passation_mpe[0]->mpe_soumissionaire = $mpe_soumissionaire;
                        }
                        $data[$key]['passation_mpe'] = $passation_mpe[0];
                    }
                    
                    
                    $data[$key]['contrat_mpe'] = $contrat_mpe[0];

                    if ($avenant_mpe) {
                        $data[$key]['avenant_mpe'] = $avenant_mpe;
                        $data[$key]['montant_avenant_mpe'] = $avenant_mpe[0]->cout_batiment+$avenant_mpe[0]->cout_latrine+$avenant_mpe[0]->cout_mobilier;
                        $data[$key]['montant_apre_avenant_mpe'] = $avenant_mpe[0]->cout_batiment+$avenant_mpe[0]->cout_latrine+$avenant_mpe[0]->cout_mobilier+$contrat_mpe[0]->cout_batiment+$contrat_mpe[0]->cout_latrine+$contrat_mpe[0]->cout_mobilier;
                    }
                    
                    //$data[$key]['avenant_moe'] = $avenant_moe;

                    if ($nbr_parti_dpp) {
                       $module_dpp[0]->nbr_parti = $nbr_parti_dpp->nbr_participant; 
                    }
                    if ($nbr_feminin_dpp) {
                        $module_dpp[0]->nbr_feminin = $nbr_feminin_dpp->nbr_feminin;
                    }                   
                    $data[$key]['module_dpp'] = $module_dpp[0];

                    if ($nbr_parti_odc) {
                       $module_odc[0]->nbr_parti = $nbr_parti_odc->nbr_participant; 
                    }
                    if ($nbr_feminin_odc) {
                        $module_odc[0]->nbr_feminin = $nbr_feminin_odc->nbr_feminin;
                    }
                    $data[$key]['module_odc'] = $module_odc[0];

                    if ($nbr_parti_emies) {
                       $module_emies[0]->nbr_parti = $nbr_parti_emies->nbr_participant; 
                    }
                    if ($nbr_feminin_emies) {
                        $module_emies[0]->nbr_feminin = $nbr_feminin_emies->nbr_feminin;
                    }
                    $data[$key]['module_emies'] = $module_emies[0];

                    if ($nbr_parti_gfpc) {
                       $module_gfpc[0]->nbr_parti = $nbr_parti_gfpc->nbr_participant; 
                    }
                    if ($nbr_feminin_gfpc) {
                        $module_gfpc[0]->nbr_feminin = $nbr_feminin_gfpc->nbr_feminin;
                    }
                    $data[$key]['module_gfpc'] = $module_gfpc[0];

                    if ($nbr_parti_pmc) {
                       $module_pmc[0]->nbr_parti = $nbr_parti_pmc->nbr_participant; 
                    }
                    if ($nbr_feminin_pmc) {
                        $module_pmc[0]->nbr_feminin = $nbr_feminin_pmc->nbr_feminin;
                    }
                    $data[$key]['module_pmc'] = $module_pmc[0];

                    if ($nbr_parti_sep) {
                       $module_sep[0]->nbr_parti = $nbr_parti_sep->nbr_participant; 
                    }
                    if ($nbr_feminin_sep) {
                        $module_sep[0]->nbr_feminin = $nbr_feminin_sep->nbr_feminin;
                    }
                    $data[$key]['module_sep'] = $module_sep[0];

                    $data[$key]['passation_moe'] = $passation_moe[0];
                    $data[$key]['contrat_moe'] = $contrat_moe[0];
                    $data[$key]['montant_avenant_moe'] = $avenant_moe[0]->montant_avenant;
                    $data[$key]['montant_apre_avenant_moe'] = $avenant_moe[0]->montant_avenant + $contrat_moe[0]->montant_contrat;
                    if ($memoire_technique) {
                      // $data[$key]['memoire_technique'] = $memoire_technique[0];
                       $data[$key]['date_liv_mt'] = $memoire_technique[0]->date_livraison;
                       $data[$key]['date_appro_mt'] = $memoire_technique[0]->date_approbation;
                    }
                    if ($appel_offre) {
                       $data[$key]['date_liv_dao'] = $appel_offre[0]->date_livraison;
                       $data[$key]['date_appro_dao'] = $appel_offre[0]->date_approbation;
                    }
                    if ($rapport_mensuel) {
                       $data[$key]['rapport_mensuel'] = $rapport_mensuel;
                    }
                    if ($manuel_gestion) {
                       $data[$key]['date_liv_mg'] = $manuel_gestion[0]->date_livraison;
                    }
                    if ($police_assurance) {
                       $data[$key]['date_expir_pa'] = $police_assurance[0]->date_expiration;
                    }*/
                    
                   /* $data[$key]['rapport_mensuel'] = $rapport_mensuel[0];
                    $data[$key]['manuel_gestion'] = $manuel_gestion[0];*/
                   // $data[$key]['police_assurance'] = $police_assurance[0];                    

                    
                  /*  if ($prestation_mpe) {
                        $data[$key]['prestation_mpe'] = $prestation_mpe[0];
                    }
                    if ($reception_mpe) {
                        $data[$key]['reception_mpe'] = $reception_mpe[0];
                    }

                    $data[$key]['paiement_batiment_pre'] = $paiement_batiment_pre;
                    if ($paiement_batiment_pre) {
                        $cumul_batiment= 0;
                        $decaissement_b = 0;
                        foreach ($paiement_batiment_pre as $keyb => $valueb){

                            if ($valueb->code=='tranche 1') {
                               $data[$key]['paiement1_batiment_pre'] = $valueb->montant_paiement;                           
                               $data[$key]['date_approbation1_batiment_pre'] = $valueb->date_approbation;
                            }
                            if ($valueb->code=='tranche 2') {
                               $data[$key]['paiement2_batiment_pre'] = $valueb->montant_paiement;                           
                               $data[$key]['date_approbation2_batiment_pre'] = $valueb->date_approbation;
                               
                            }
                            if ($valueb->code=='tranche 3') {
                               $data[$key]['paiement3_batiment_pre'] = $valueb->montant_paiement;                           
                               $data[$key]['date_approbation3_batiment_pre'] = $valueb->date_approbation;
                               
                            }
                            if ($valueb->code=='tranche 4') {
                               $data[$key]['paiement4_batiment_pre'] = $valueb->montant_paiement;                           
                               $data[$key]['date_approbation4_batiment_pre'] = $valueb->date_approbation;
                               
                            }
                            if ($valueb->code=='tranche 5') {
                               $data[$key]['paiement5_batiment_pre'] = $valueb->montant_paiement;                           
                               $data[$key]['date_approbation5_batiment_pre'] = $valueb->date_approbation;
                               
                            }
                            $cumul_batiment = $cumul_batiment + $valueb->montant_paiement;
                            $decaissement_b = $decaissement_b + $valueb->pourcentage;
                            $data[$key]['cumul_batiment'] = $cumul_batiment;
                            $data[$key]['decaissement_batiment'] = $decaissement_b;
                        }
                    }
                    
                    $data[$key]['paiement_latrine_pre'] = $paiement_latrine_pre;
                    if ($paiement_latrine_pre) {
                        $cumul_latrine= 0;
                        $decaissement_l = 0;
                        foreach ($paiement_latrine_pre as $keyl => $valuel){

                            if ($valuel->code=='tranche 1') {
                               $data[$key]['paiement1_latrine_pre'] = $valuel->montant_paiement;                           
                               $data[$key]['date_approbation1_latrine_pre'] = $valuel->date_approbation;
                            }
                            if ($valuel->code=='tranche 2') {
                               $data[$key]['paiement2_latrine_pre'] = $valuel->montant_paiement;                           
                               $data[$key]['date_approbation2_latrine_pre'] = $valuel->date_approbation;
                               
                            }
                            if ($valuel->code=='tranche 3') {
                               $data[$key]['paiement3_latrine_pre'] = $valuel->montant_paiement;                           
                               $data[$key]['date_approbation3_latrine_pre'] = $valuel->date_approbation;
                               
                            }
                            $cumul_latrine = $cumul_latrine + $valuel->montant_paiement;
                            $decaissement_l = $decaissement_l + $valuel->pourcentage;
                            $data[$key]['cumul_latrine'] = $cumul_latrine;
                            $data[$key]['decaissement_latrine'] = $decaissement_l;
                        }
                    }
                    
                    $data[$key]['paiement_mobilier_pre'] = $paiement_mobilier_pre;
                    if ($paiement_mobilier_pre) {
                        $cumul_mobilier= 0;
                        $decaissement_mo = 0;
                        foreach ($paiement_latrine_pre as $keyl => $valuem){

                            if ($valuem->code=='tranche 1') {
                               $data[$key]['paiement1_mobilier_pre'] = $valuem->montant_paiement;                           
                               $data[$key]['date_approbation1_mobilier_pre'] = $valuem->date_approbation;
                            }
                            if ($valuem->code=='tranche 2') {
                               $data[$key]['paiement2_mobilier_pre'] = $valuem->montant_paiement;                           
                               $data[$key]['date_approbation2_mobilier_pre'] = $valuem->date_approbation;
                               
                            }
                            $cumul_mobilier = $cumul_mobilier + $valuem->montant_paiement;
                            $decaissement_mo = $decaissement_mo + $valuem->pourcentage;
                            $data[$key]['cumul_mobilier'] = $cumul_mobilier;
                            $data[$key]['decaissement_mobilier'] = $decaissement_mo;
                        }
                    }
                    

                    //$data[$key]['avancementm'] = $avancement;
                    if ($transfert_reliquat) {
                        $data[$key]['transfert_reliquat'] = $transfert_reliquat[0];
                    }
                    

                }
            } 
                else
                    $data = array();
        } 
        else*/
        elseif ($menu=='conventionmaxBydate')  //mande
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionmaxBydate($date_today);
            if ($tmp) 
            {
                $data = $tmp;

            } 
                else
                    $data = array();
        } 
     /*   elseif ($menu=='getconventionByecole')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionByid_ecole($id_ecole);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        } */
       /* elseif ($menu=='getconventionvalideufpBycisco')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValideufpByid_cisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventionvalideByciscowithcount')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValideByid_cisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;
                    $countAvenant = $this->Avenant_conventionManager->countAvenantByIdconvention($value->id);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;
                    $data[$key]['countAvenant'] = $countAvenant;


                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventionvalideBycisco')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValideByid_cisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventioninvalideByciscowithcount') //mande
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllInvalideByid_cisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        
        elseif ($menu=='getconvention_enteteBymodule_prestataire')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValideByid_contrat_prestataire($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;


                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventionvalideByfeffi')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValideByfeffi($id_feffi);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id); 
                    if (count($avancement_detail)>0)
                   {
       
                     $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    

                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;

                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventionvalide')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    } 

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                    
                    $data[$key]['ref_financement'] = $value->ref_financement;
                   
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;
                    $data[$key]['avancement'] = $avancement ; 
                    $data[$key]['ecole'] = $ecole;

                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventioninvalide')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllInvalide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
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
                            $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                            $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                            $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                        } 
                    }
                                       
                                        
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;
                    $data[$key]['avancement'] = $avancement ; 
                     $data[$key]['ecole'] = $ecole;
                   
                }
            } 
                else
                    $data = array();
        }
        
       
        elseif ($id)
        {
            $data = array();
            $tmp = $this->Convention_cisco_feffi_enteteManager->findByIdObjet($id);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;
                    $data[$key]['avancement'] = $avancement ; 
                     $data[$key]['ecole'] = $ecole;
                }
            } 
                else
                    $data = array();
        } */
        else 
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;
                    $data[$key]['avancement'] = $avancement;
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
                    'id_site' => $this->post('id_site'),
                    'ref_financement' => $this->post('ref_financement'),
                    'montant_total' => $this->post('montant_total'),
                    'avancement' => $this->post('avancement'),
                    'validation' => $this->post('validation'),
                    'id_convention_ufpdaaf' => $this->post('id_convention_ufpdaaf'),
                    'type_convention' => $this->post('type_convention'),
                    'id_user' => $this->post('id_user')
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
                    'id_site' => $this->post('id_site'),
                    'ref_financement' => $this->post('ref_financement'),
                    'validation' => $this->post('validation'),
                    'id_convention_ufpdaaf' => $this->post('id_convention_ufpdaaf'),
                    'montant_total' => $this->post('montant_total'),
                    'avancement' => $this->post('avancement'),
                    'type_convention' => $this->post('type_convention'),
                    'id_user' => $this->post('id_user')
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
