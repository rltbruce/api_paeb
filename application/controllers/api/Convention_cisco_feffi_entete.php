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
        $this->load->model('prestation_mpe_model', 'Prestation_mpeManager');
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
        
        if ($menu=='getconventiondetailfiltreByid')
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

                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    $paiement_daaf_feffi= $this->Transfert_daafManager->getpaiementByconvention($value->id);

                    $passation_pr= $this->Passation_marches_prManager->getpassationByconvention($value->id);
                    $passation_mpe= $this->Passation_marchesManager->getpassationByconvention($value->id);
                    $passation_moe= $this->Passation_marches_beManager->getpassationByconvention($value->id);

                    $contrat_moe= $this->Contrat_beManager->getcontratByconvention($value->id);
                    $contrat_mpe= $this->Contrat_partenaire_relaiManager->getcontratByconvention($value->id);
                    $contrat_pr= $this->Contrat_prestataireManager->getcontratByconvention($value->id);

                    $avenant_moe= $this->Avenant_beManager->getavenantBycontrat($contrat_moe[0]->id);
                    $avenant_mpe= $this->Avenant_partenaire_relaiManager->getavenantBycontrat($contrat_mpe[0]->id);
                    $avenant_pr= $this->Avenant_prestataireManager->getavenantBycontrat($contrat_pr[0]->id);
                    $paiement_batiment_pre= $this->Paiement_batiment_prestataireManager->getpaiementbat_mpeBycontrat($contrat_moe[0]->id); 
                    $paiement_latrine_pre= $this->Paiement_latrine_prestataireManager->getpaiementlat_mpeBycontrat($contrat_moe[0]->id);  
                    $paiement_mobilier_pre= $this->Paiement_mobilier_prestataireManager->getpaiementmob_mpeBycontrat($contrat_moe[0]->id);                  

                    $module_dpp= $this->Module_dppManager->getmoduleBycontrat($contrat_pr[0]->id);
                    $module_emies= $this->Module_emiesManager->getmoduleBycontrat($contrat_pr[0]->id);
                    $module_gfpc= $this->Module_gfpcManager->getmoduleBycontrat($contrat_pr[0]->id);
                    $module_odc= $this->Module_odcManager->getmoduleBycontrat($contrat_pr[0]->id);
                    $module_pmc= $this->Module_pmcManager->getmoduleBycontrat($contrat_pr[0]->id);
                    $module_sep= $this->Module_sepManager->getmoduleBycontrat($contrat_pr[0]->id);

                    $memoire_technique= $this->Memoire_techniqueManager->getmemoire_techniqueBycontrat($contrat_moe[0]->id,1);
                    $appel_offre= $this->Appel_offreManager->getappel_offreBycontrat($contrat_moe[0]->id,1);
                    $rapport_mensuel= $this->Rapport_mensuelManager->getrapport_mensuelBycontrat($contrat_moe[0]->id,1);
                    $manuel_gestion= $this->Manuel_gestionManager->getmanuel_gestionBycontrat($contrat_moe[0]->id,1);
                    $police_assurance= $this->Police_assuranceManager->getpolice_assuranceBycontrat($contrat_moe[0]->id,1);

                    $reception_mpe= $this->Reception_mpeManager->getreceptionBycontrat($contrat_mpe[0]->id);

                    $paiement_mpe_moe_pr= $this->Paiement_batiment_prestataireManager->getpaiementByconvention($value->id,1);

                    $prestation_mpe= $this->Prestation_mpeManager->getprestation_mpeBycontrat($contrat_mpe[0]->id);

                    $avancement_detail = $this->Avancement_batimentManager->getavancementByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
                    }

                    

                    //$decaiss_fonct_feffi= $this->Decaiss_fonct_feffiManager->getsumdecaissementByconvention($value->id);

                    if ($paiement_daaf_feffi)
                    {
                        $financierfeffi=$paiement_daaf_feffi;
                    }

                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_batiment+$avancement_detail[0]->avancement_latrine+$avancement_detail[0]->avancement_mobilier)/3),4) ; 
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
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_batiment'] = $montant_bat;
                    $data[$key]['montant_latrine'] = $montant_lat;
                    $data[$key]['montant_mobilier'] = $montant_mob;
                    $data[$key]['montant_maitrise'] = $montant_maitrise;
                    $data[$key]['montant_sousprojet'] = $montant_sousprojet;
                    $data[$key]['montant_depense'] = $montant_bat + $montant_lat + $montant_mob + $montant_maitrise;
                    $data[$key]['montant_total'] = $montant;

                    $data[$key]['financierfeffi'] = $financierfeffi;

                    $data[$key]['paiement_mpe_moe_pr'] = $paiement_mpe_moe_pr;

                    $data[$key]['passation_pr'] = $passation_pr;
                    $data[$key]['passation_mpe'] = $passation_mpe;
                    $data[$key]['passation_moe'] = $passation_moe;

                    $data[$key]['contrat_pr'] = $contrat_pr;
                    $data[$key]['contrat_mpe'] = $contrat_mpe;
                    $data[$key]['contrat_moe'] = $contrat_moe;

                    $data[$key]['avenant_pr'] = $avenant_pr;
                    $data[$key]['avenant_mpe'] = $avenant_mpe;
                    $data[$key]['avenant_moe'] = $avenant_moe;


                    $data[$key]['module_dpp'] = $module_dpp;
                    $data[$key]['module_emies'] = $module_emies;
                    $data[$key]['module_gfpc'] = $module_gfpc;
                    $data[$key]['module_odc'] = $module_odc;
                    $data[$key]['module_pmc'] = $module_pmc;
                    $data[$key]['module_sep'] = $module_sep;


                    $data[$key]['memoire_technique'] = $memoire_technique;
                    $data[$key]['appel_offre'] = $appel_offre;
                    $data[$key]['rapport_mensuel'] = $rapport_mensuel;
                    $data[$key]['manuel_gestion'] = $manuel_gestion;
                    $data[$key]['police_assurance'] = $police_assurance;

                    $data[$key]['reception_mpe'] = $reception_mpe;

                    $data[$key]['paiement_batiment_pre'] = $paiement_batiment_pre;
                    $data[$key]['paiement_latrine_pre'] = $paiement_latrine_pre;
                    $data[$key]['paiement_mobilier_pre'] = $paiement_mobilier_pre;

                    $data[$key]['prestation_mpe'] = $prestation_mpe;
                    $data[$key]['avancement'] = $avancement;


                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventionByecole')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionByid_ecole($id_ecole);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventionvalideufpBycisco')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValideufpByid_cisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

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
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
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
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;
                    $data[$key]['paiement_batiment_pre'] = $paiement_batiment_pre;


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
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

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
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
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
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;


                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventioninvalideBycisco')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllInvalideByid_cisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

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
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
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
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;


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
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

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
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
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
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

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
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
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
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

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
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    } 

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
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
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

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
                            $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                            $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                            $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                        } 
                    }
                                       
                                        
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
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
        elseif ($menu=='getconventioninvalidedaaf')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllInvalidedaaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

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
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }                    
                                        
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
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
        elseif ($id_convention_ufpdaaf)
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllByufpdaaf($id_convention_ufpdaaf);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

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
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
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
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

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
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
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
        else 
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

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
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
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
