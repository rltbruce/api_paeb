<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Excel_bdd_construction extends REST_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('transfert_reliquat_model', 'Transfert_reliquatManager');
        $this->load->model('phase_sous_projets_model', 'Phase_sous_projetsManager');
        $this->load->model('phase_sous_projet_construction_model', 'Phase_sous_projet_constructionManager');
        $this->load->model('mpe_soumissionaire_model', 'Mpe_soumissionaireManager');
        $this->load->model('participant_emies_model', 'Participant_emiesManager');
        $this->load->model('participant_sep_model', 'Participant_sepManager');
        $this->load->model('participant_gfpc_model', 'Participant_gfpcManager');
        $this->load->model('participant_pmc_model', 'Participant_pmcManager');
        $this->load->model('participant_odc_model', 'Participant_odcManager');
        $this->load->model('participant_dpp_model', 'Participant_dppManager');
        $this->load->model('avenant_convention_model', 'Avenant_conventionManager');
        $this->load->model('convention_cisco_feffi_detail_model', 'Convention_cisco_feffi_detailManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('cisco_model', 'CiscoManager');
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('Site_model', 'SiteManager');
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
        $menu = $this->get('menu');
        $id = $this->get('id');
        $id_convention_ufpdaaf = $this->get('id_convention_ufpdaaf');
        $id_feffi = $this->get('id_feffi');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_cisco = $this->get('id_cisco');
        $id_ecole = $this->get('id_ecole');
        $id_convention_entete = $this->get('id_convention_entete');
        $repertoire = $this->get('repertoire');
        $data = array() ;


        //*********************************** Nombre echantillon *************************
        
        if ($menu=='exportconventionByid')
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
                        $data[$key]['paiement1_feffi']='';
                        $data[$key]['date1_feffi']='';
                        $data[$key]['paiement2_feffi']='';
                        $data[$key]['date2_feffi']='';
                        $data[$key]['paiement3_feffi']='';
                        $data[$key]['date3_feffi']='';
                        
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
                    $data[$key]['site']=$site;
                    $data[$key]['commune']=$commune;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['region'] = $region;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;                   
                    $data[$key]['convention_detail'] = $convention_detail;
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

                    $data[$key]['cumul_paiement_moe'] = $paiement_mpe_moe_fonct_pr[0]->montant_d_moe+$paiement_mpe_moe_fonct_pr[0]->montant_bat_moe+$paiement_mpe_moe_fonct_pr[0]->montant_lat_moe+$paiement_mpe_moe_fonct_pr[0]->montant_f_moe;

                    $data[$key]['decaissement_paiement_moe'] = (($paiement_mpe_moe_fonct_pr[0]->montant_d_moe+$paiement_mpe_moe_fonct_pr[0]->montant_bat_moe+$paiement_mpe_moe_fonct_pr[0]->montant_lat_moe+$paiement_mpe_moe_fonct_pr[0]->montant_f_moe)*100)/$contrat_moe[0]->montant_contrat;
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
                    }
                    
                   /* $data[$key]['rapport_mensuel'] = $rapport_mensuel[0];
                    $data[$key]['manuel_gestion'] = $manuel_gestion[0];*/
                   // $data[$key]['police_assurance'] = $police_assurance[0];                    

                    
                    if ($prestation_mpe) {
                        $data[$key]['prestation_mpe'] = $prestation_mpe[0];
                    }
                    if ($reception_mpe) {
                        $data[$key]['reception_mpe'] = $reception_mpe[0];
                    }

                    $data[$key]['paiement_batiment_pre'] = $paiement_batiment_pre;
                    if ($paiement_batiment_pre) {
                        $cumul_batiment= 0;
                        $decaissement_b = 0;

                        $paiement1_batiment_pre = 0;                           
                        $date_approbation1_batiment_pre = '';                         
                        $paiement2_batiment_pre = 0;                           
                        $date_approbation2_batiment_pre = '';                        
                        $paiement3_batiment_pre = 0;                           
                        $date_approbation3_batiment_pre = '';                        
                        $paiement4_batiment_pre = 0;                           
                        $date_approbation4_batiment_pre = '';                        
                        $paiement5_batiment_pre = 0;                           
                        $date_approbation5_batiment_pre = '';


                        foreach ($paiement_batiment_pre as $keyb => $valueb){

                            if ($valueb->code=='tranche 1') {
                                $paiement1_batiment_pre = $valueb->montant_paiement;                           
                                $date_approbation1_batiment_pre = $valueb->date_approbation;
                            }
                            if ($valueb->code=='tranche 2') {
                                $paiement2_batiment_pre = $valueb->montant_paiement;                           
                                $date_approbation2_batiment_pre = $valueb->date_approbation;
                               
                            }
                            if ($valueb->code=='tranche 3') {
                                $paiement3_batiment_pre = $valueb->montant_paiement;                           
                                $date_approbation3_batiment_pre = $valueb->date_approbation;
                               
                            }
                            if ($valueb->code=='tranche 4') {
                                $paiement4_batiment_pre = $valueb->montant_paiement;                           
                                $date_approbation4_batiment_pre = $valueb->date_approbation;
                               
                            }
                            if ($valueb->code=='tranche 5') {
                                $paiement5_batiment_pre = $valueb->montant_paiement;                           
                                $date_approbation5_batiment_pre = $valueb->date_approbation;
                               
                            }
                            $cumul_batiment = $cumul_batiment + $valueb->montant_paiement;
                            $decaissement_b = $decaissement_b + $valueb->pourcentage;
                            $data[$key]['cumul_batiment'] = $cumul_batiment;
                            $data[$key]['decaissement_batiment'] = $decaissement_b;
                        }

                      // $data[$key]['paiement1_batiment_pre'] = $paiement1_batiment_pre;   //                        
                       $data[$key]['paiement1_batiment_pre'] = 0;                           
                        $data[$key]['date_approbation1_batiment_pre'] = $date_approbation1_batiment_pre;

                        $data[$key]['paiement2_batiment_pre'] = $paiement2_batiment_pre;                           
                        $data[$key]['date_approbation2_batiment_pre'] = $date_approbation2_batiment_pre;

                        $data[$key]['paiement3_batiment_pre'] = $paiement3_batiment_pre;                           
                        $data[$key]['date_approbation3_batiment_pre'] = $date_approbation3_batiment_pre;
                        
                        $data[$key]['paiement4_batiment_pre'] = $paiement4_batiment_pre;                           
                        $data[$key]['date_approbation4_batiment_pre'] = $date_approbation4_batiment_pre;

                        $data[$key]['paiement5_batiment_pre'] = $paiement5_batiment_pre;                           
                        $data[$key]['date_approbation5_batiment_pre'] = $date_approbation5_batiment_pre;
                    }
                    
                    $data[$key]['paiement_latrine_pre'] = $paiement_latrine_pre;
                    if ($paiement_latrine_pre) {
                        $cumul_latrine= 0;
                        $decaissement_l = 0;
                        $paiement1_latrine_pre = 0;                           
                        $date_approbation1_latrine_pre = '';                         
                        $paiement2_latrine_pre = 0;                           
                        $date_approbation2_latrine_pre = '';                        
                        $paiement3_latrine_pre = 0;                           
                        $date_approbation3_latrine_pre = '';                        
                        $paiement4_latrine_pre = 0;                           
                        $date_approbation4_latrine_pre = '';                        
                        $paiement5_latrine_pre = 0;                           
                        $date_approbation5_latrine_pre = '';
                        foreach ($paiement_latrine_pre as $keyl => $valuel){

                            if ($valuel->code=='tranche 1') {
                                $paiement1_latrine_pre = $valueb->montant_paiement;                           
                                $date_approbation1_latrine_pre = $valueb->date_approbation;
                            }
                            if ($valuel->code=='tranche 2') {
                                $paiement2_latrine_pre = $valueb->montant_paiement;                           
                                $date_approbation2_latrine_pre = $valueb->date_approbation;
                               
                            }
                            if ($valuel->code=='tranche 3') {
                                $paiement3_latrine_pre = $valueb->montant_paiement;                           
                                $date_approbation3_latrine_pre = $valueb->date_approbation;
                               
                            }
                            $cumul_latrine = $cumul_latrine + $valuel->montant_paiement;
                            $decaissement_l = $decaissement_l + $valuel->pourcentage;
                            $data[$key]['cumul_latrine'] = $cumul_latrine;
                            $data[$key]['decaissement_latrine'] = $decaissement_l;
                        }


                        $data[$key]['paiement1_latrine_pre'] = $paiement1_latrine_pre;                           
                        $data[$key]['date_approbation1_latrine_pre'] = $date_approbation1_latrine_pre;

                        $data[$key]['paiement2_latrine_pre'] = $paiement2_latrine_pre;                           
                        $data[$key]['date_approbation2_latrine_pre'] = $date_approbation2_latrine_pre;

                        $data[$key]['paiement3_latrine_pre'] = $paiement3_latrine_pre;                           
                        $data[$key]['date_approbation3_latrine_pre'] = $date_approbation3_latrine_pre;
                       
                    }
                    
                    $data[$key]['paiement_mobilier_pre'] = $paiement_mobilier_pre;
                    if ($paiement_mobilier_pre) {
                        $cumul_mobilier= 0;
                        $decaissement_mo = 0;
                        $paiement1_mobilier_pre = 0;                           
                        $date_approbation1_mobilier_pre = '';                         
                        $paiement2_mobilier_pre = 0;                           
                        $date_approbation2_mobilier_pre = '';
                        foreach ($paiement_mobilier_pre as $keyl => $valuem){

                            if ($valuem->code=='tranche 1') {
                                $paiement1_mobilier_pre = $valuem->montant_paiement;                           
                                $date_approbation1_mobilier_pre = $valuem->date_approbation;
                            }
                            if ($valuem->code=='tranche 2') {
                                $paiement2_mobilier_pre = $valuem->montant_paiement;                           
                                $date_approbation2_mobilier_pre = $valuem->date_approbation;
                               
                            }
                            $cumul_mobilier = $cumul_mobilier + $valuem->montant_paiement;
                            $decaissement_mo = $decaissement_mo + $valuem->pourcentage;
                            $data[$key]['cumul_mobilier'] = $cumul_mobilier;
                            $data[$key]['decaissement_mobilier'] = $decaissement_mo;
                        }
                        $data[$key]['paiement1_mobilier_pre'] = $paiement1_mobilier_pre;                           
                        $data[$key]['date_approbation1_mobilier_pre'] = $date_approbation1_mobilier_pre;

                        $data[$key]['paiement2_mobilier_pre'] = $paiement2_mobilier_pre;                           
                        $data[$key]['date_approbation2_mobilier_pre'] = $date_approbation2_mobilier_pre;
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
        
        //********************************* fin Nombre echantillon *****************************
        if (count($data)>0) {
        
        $export=$this->export_excel($repertoire,$data);
            

        } else {
            $this->response([
                'status' => FALSE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }

   
    public function export_excel($repertoire,$data)
    {
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';      

        $nom_file='bdd_construction';
        $directoryName = dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire;
            
            //Check if the directory already exists.
        if(!is_dir($directoryName))
        {
            mkdir($directoryName, 0777,true);
        }
            
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Myexcel")
                    ->setLastModifiedBy("Me")
                    ->setTitle("suivi FEFFI")
                    ->setSubject("suivi FEFFI")
                    ->setDescription("suivi FEFFI")
                    ->setKeywords("suivi FEFFI")
                    ->setCategory("suivi FEFFI");

        $ligne=1;            
            // Set Orientation, size and scaling
            // Set Orientation, size and scaling
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        $objPHPExcel->getActiveSheet()->getPageMargins()->SetLeft(0.64); //***pour marge gauche
        $objPHPExcel->getActiveSheet()->getPageMargins()->SetRight(0.64); //***pour marge droite
        $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(10);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(10);


        $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CK')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CN')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CO')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CP')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CQ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CR')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CS')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CT')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CU')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CV')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CW')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CX')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CY')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CZ')->setWidth(10);


        $objPHPExcel->getActiveSheet()->getColumnDimension('DA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DD')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DE')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DF')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DH')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DK')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DN')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DO')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DP')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DQ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DR')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DS')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DT')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DU')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DV')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DW')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DX')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DY')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DZ')->setWidth(10);


        $objPHPExcel->getActiveSheet()->getColumnDimension('EA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('ED')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EE')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EF')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EH')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EK')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EN')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EO')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EP')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EQ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('ER')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('ES')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('ET')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EU')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EV')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EW')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EX')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EY')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EZ')->setWidth(10);


        $objPHPExcel->getActiveSheet()->getColumnDimension('FA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FD')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FE')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FF')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FH')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FK')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FN')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FO')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FP')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FQ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FR')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FS')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FT')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FU')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FV')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FW')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FX')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FY')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FZ')->setWidth(10);


        $objPHPExcel->getActiveSheet()->getColumnDimension('GA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GD')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GE')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GF')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GH')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GK')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GN')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GO')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GP')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GQ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GR')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GS')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GT')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GU')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GV')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GW')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GX')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GY')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GZ')->setWidth(10);


        $objPHPExcel->getActiveSheet()->getColumnDimension('HA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HD')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HE')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HF')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HH')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HK')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HN')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HO')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HP')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HQ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HR')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HS')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HT')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HU')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HV')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HW')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HX')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HY')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HZ')->setWidth(10);
           
       /* $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);*/
            
        $objPHPExcel->getActiveSheet()->setTitle("suivi FEFFI");

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

        $styleGras = array
        (
        'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
        'font' => array
            (
                'name'  => 'Arial Narrow',
                'bold'  => true,
                'size'  => 12
            ),
        );
        $styleTitre = array
        (

            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
        'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
        'font' => array
            (
                'name'  => 'Arial Narrow',
                'bold'  => true,
                'size'  => 8
            ),
        );
        $stylesousTitre = array
        (
            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
            'font' => array
            (
                'name'  => 'Arial Narrow',
                //'bold'  => true,
                'size'  => 8
            ),
        );
            
        $stylecontenu = array
        (
            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 10
            )
        );

        $stylepied = array
        (
            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
            'font' => array
            (
                    //'name'  => 'Times New Roman',
                'bold'  => true,
                'size'  => 11
            ),
        );

        $ligne++;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->applyFromArray($styleGras);
        //$objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "PROJET D'APPUI A L'EDUCATION DE BASE (PAEB)");

        $ligne++;
        //$objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($styleGras);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "TABLEAU DE SUIVI ");

        $ligne=$ligne+2;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":F".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":F".($ligne+1))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "(1) DONNEES GLOBALES");

        $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":AH".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":AH".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "(2) CONVENTIONFEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("AI".$ligne.":DM".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AI".$ligne.":DM".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI'.$ligne, "(3) PARTENAIRES RELAIS");

        $objPHPExcel->getActiveSheet()->mergeCells("DN".$ligne.":ER".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("DN".$ligne.":ER".($ligne+1))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DN'.$ligne, "(4) MAITRISE D'ŒUVRE");

        $objPHPExcel->getActiveSheet()->mergeCells("ES".$ligne.":GX".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("ES".$ligne.":GX".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ES'.$ligne, "(5) ENTREPRISE");

        $objPHPExcel->getActiveSheet()->mergeCells("GY".$ligne.":HB".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne.":HB".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GY'.$ligne, "(6) GESTION RELIQUATS DE FONDS");//4287f5
//GLOBAL
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":F".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bed4ed')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("A".($ligne+2).":F".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'dce6f1')
        )
        ));
//CONVENTION FEFFI

        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":AH".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '9ead95')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("G".($ligne+1).":AH".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bfcfb6')
        )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("G".($ligne+2).":AH".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'e2efda')
        )
        ));

//PARTENAIRE RELAI

        $objPHPExcel->getActiveSheet()->getStyle("AI".$ligne.":DM".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '8096bd')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("AI".($ligne+1).":DM".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '99abcc')
        )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("AI".($ligne+2).":DM".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'b4c6e7')
        )
        ));

//MAITRISE D4OEUVRE

        $objPHPExcel->getActiveSheet()->getStyle("DN".$ligne.":ER".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'ed7c31')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("DN".($ligne+2).":ER".($ligne+2))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'fa8f48')
        )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("DN".($ligne+3).":ER".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'faa770')
        )
        ));

//ENTREPRISE

        $objPHPExcel->getActiveSheet()->getStyle("ES".$ligne.":GX".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4f81bd')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("ES".($ligne+1).":GX".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '5e99bd')
        )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("ES".($ligne+2).":GX".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '97c8e6')
        )
        ));

//reliquat

        $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne.":HB".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '9266e3')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("GY".($ligne+1).":HB".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'b08df2')
        )
        ));
        

        $ligne++;

        $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":Q".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":Q".$ligne)->applyFromArray($styleTitre);
        //$objPHPExcel->getActiveSheet()->setColor(rgb(200,200,200));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "ESTIMATION DE LA CONVENTION");

        $objPHPExcel->getActiveSheet()->mergeCells("R".$ligne.":Z".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("R".$ligne.":Z".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$ligne, "SUIVI FINANCIER DAAF FEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("AA".$ligne.":AC".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AA".$ligne.":AC".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$ligne, "SUIVI FINANCIER FEFFI -PRESTATAIRE");

        $objPHPExcel->getActiveSheet()->mergeCells("AD".$ligne.":AF".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AD".$ligne.":AF".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$ligne, "SUIVI FINANCIER FEFFI FONCTIONNEMENT");

        //$objPHPExcel->getActiveSheet()->mergeCells("AG".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$ligne, "TOTAL CONVENTION DECAISSEE");

       // $objPHPExcel->getActiveSheet()->mergeCells("AH".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AH".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH'.$ligne, "Reliquat des fonds");

        $objPHPExcel->getActiveSheet()->mergeCells("AI".$ligne.":AQ".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AI".$ligne.":AQ".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI'.$ligne, "Suivi Passation des marchés PR");

        $objPHPExcel->getActiveSheet()->mergeCells("AR".$ligne.":AS".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AR".$ligne.":AS".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR'.$ligne, "");

        $objPHPExcel->getActiveSheet()->mergeCells("AT".$ligne.":DM".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AT".$ligne.":DM".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT'.$ligne, "Suivi Prestation par PR");

        $objPHPExcel->getActiveSheet()->mergeCells("ES".$ligne.":FL".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("ES".$ligne.":FL".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ES'.$ligne, "Passation des marchés");

        $objPHPExcel->getActiveSheet()->mergeCells("FM".$ligne.":GB".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("FM".$ligne.":GB".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FM'.$ligne, "Suivi de l'exécution de chaque contrat des travaux");

        $objPHPExcel->getActiveSheet()->mergeCells("GC".$ligne.":GX".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GC".$ligne.":GX".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GC'.$ligne, "Suivi de paiement de chaque contrat des travaux");

       $objPHPExcel->getActiveSheet()->mergeCells("GY".$ligne.":GY".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne.":GY".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GY'.$ligne, "Montant du reliquat de fonds");

        $objPHPExcel->getActiveSheet()->mergeCells("GZ".$ligne.":GZ".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("GZ".$ligne.":GZ".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GZ'.$ligne, "Objet de l'utilisation du reliquat");

        $objPHPExcel->getActiveSheet()->mergeCells("HA".$ligne.":HA".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HA".$ligne.":HA".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HA'.$ligne, "Situation de l'utilisation du reliquat");

        $objPHPExcel->getActiveSheet()->mergeCells("HB".$ligne.":HB".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HB".$ligne.":HB".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HB'.$ligne, "OBSERVATIONS");

        $ligne++;

        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":A".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":A".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":A".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "AGENCE");

        $objPHPExcel->getActiveSheet()->mergeCells("B".$ligne.":B".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("B".$ligne.":B".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, "ECOLE");

        $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":C".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("C".$ligne.":C".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, "COMMUNE");

        $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":D".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne.":D".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "CISCO");

        $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":E".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":E".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "REGION");


        //$objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":F".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "TYPE DE CONVENTION");

        $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":G".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":G".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "NOM FEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":H".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":H".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Date de signature convention CISCO FEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":I".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":I".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "Bâtiment");

        $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":J".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("J".$ligne.":J".($ligne+1))->applyFromArray($stylesousTitre);
       // $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, "Latrine");

        $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":K".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":K".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "Mobilier scolaire");

        $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":L".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne.":L".($ligne+1))->applyFromArray($stylesousTitre);
       // $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, "Maitrise d'œuvre");

        $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":M".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("M".$ligne.":M".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, "Sous total Dépenses TAVAUX");

        $objPHPExcel->getActiveSheet()->mergeCells("N".$ligne.":N".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("N".$ligne.":N".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, "Frais de fonctionnement FEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("O".$ligne.":O".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("O".$ligne.":O".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("O".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, "Montant convention");

        $objPHPExcel->getActiveSheet()->mergeCells("P".$ligne.":P".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("P".$ligne.":P".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$ligne, "AVENANT A LA CONVENTION");

        $objPHPExcel->getActiveSheet()->mergeCells("Q".$ligne.":Q".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("Q".$ligne.":Q".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("Q".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, "MONTANT CONVENTION APRES AVENANT");

        //$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->mergeCells("R".$ligne.":R".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("R".$ligne.":R".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("R".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("R".$ligne, "Montant 1ère tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("S".$ligne.":S".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("S".$ligne.":S".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("S".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("S".$ligne, "Date d'approbation 1ère tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("T".$ligne.":T".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("T".$ligne.":T".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("T".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("T".$ligne, "Montant 2ème tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("U".$ligne.":U".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("U".$ligne.":U".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("U".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("U".$ligne, "Date d'approbation 2ème tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("V".$ligne.":V".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("V".$ligne.":V".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("V".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("V".$ligne, "Montant 3ème tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("W".$ligne.":W".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("W".$ligne.":W".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("W".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("W".$ligne, "Date d'approbation 3ème tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("X".$ligne.":X".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("X".$ligne.":X".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("X".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("X".$ligne, "Total");

        $objPHPExcel->getActiveSheet()->mergeCells("Y".$ligne.":Y".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("Y".$ligne.":Y".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("Y".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Y".$ligne, "% décaissement");

        $objPHPExcel->getActiveSheet()->mergeCells("Z".$ligne.":Z".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("Z".$ligne.":Z".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("Z".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Z".$ligne, "OBSERVATIONS");

//SUIVI FINANCIER FEFFI -PRESTATAIRE
        $objPHPExcel->getActiveSheet()->mergeCells("AA".$ligne.":AA".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AA".$ligne.":AA".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AA".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AA".$ligne, "Montant décaissé");

        $objPHPExcel->getActiveSheet()->mergeCells("AB".$ligne.":AB".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AB".$ligne.":AB".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AB".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AB".$ligne, "% décaissement");

        $objPHPExcel->getActiveSheet()->mergeCells("AC".$ligne.":AC".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AC".$ligne.":AC".($ligne+1))->applyFromArray($stylesousTitre);
       // $objPHPExcel->getActiveSheet()->getStyle("AC".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AC".$ligne, "OBSERVATIONS");

//SUIVI FINANCIER FEFFI FONCTIONNEMENT
        $objPHPExcel->getActiveSheet()->mergeCells("AD".$ligne.":AD".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AD".$ligne.":AD".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AD".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AD".$ligne, "Montant décaissé");

        $objPHPExcel->getActiveSheet()->mergeCells("AE".$ligne.":AE".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AE".$ligne.":AE".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AE".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AE".$ligne, "% décaissement");

        $objPHPExcel->getActiveSheet()->mergeCells("AF".$ligne.":AF".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AF".$ligne.":AF".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AF".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AF".$ligne, "OBSERVATIONS");


        $objPHPExcel->getActiveSheet()->mergeCells("AG".$ligne.":AG".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AG".$ligne.":AG".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AG".$ligne, "MONTANT");

        $objPHPExcel->getActiveSheet()->mergeCells("AH".$ligne.":AH".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AH".$ligne.":AH".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AH".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AH".$ligne, "MONTANT");

        $objPHPExcel->getActiveSheet()->mergeCells("AI".$ligne.":AI".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AI".$ligne.":AI".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AI".$ligne, "Appel manifestation");

        $objPHPExcel->getActiveSheet()->mergeCells("AJ".$ligne.":AJ".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne.":AJ".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AJ".$ligne, "Lancement D.P.");

        $objPHPExcel->getActiveSheet()->mergeCells("AK".$ligne.":AK".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AK".$ligne.":AK".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AK".$ligne, "Remise proposition");

        $objPHPExcel->getActiveSheet()->mergeCells("AL".$ligne.":AL".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AL".$ligne.":AL".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AL".$ligne, "Nbre plis reçu");

        $objPHPExcel->getActiveSheet()->mergeCells("AM".$ligne.":AM".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AM".$ligne.":AM".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AM".$ligne, "Date O.S. commencement");

        $objPHPExcel->getActiveSheet()->mergeCells("AN".$ligne.":AN".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AN".$ligne.":AN".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AN".$ligne, "Nom du Consultant");

        $objPHPExcel->getActiveSheet()->mergeCells("AO".$ligne.":AO".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AO".$ligne.":AO".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AO".$ligne, "Montant contrat");

        $objPHPExcel->getActiveSheet()->mergeCells("AP".$ligne.":AP".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AP".$ligne.":AP".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AP".$ligne, "Cumul paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("AQ".$ligne.":AQ".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne.":AQ".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AQ".$ligne, "% paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("AR".$ligne.":AR".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AR".$ligne.":AR".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AR".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AR".$ligne, "Avenant contrat PR");

        $objPHPExcel->getActiveSheet()->mergeCells("AS".$ligne.":AS".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AS".$ligne.":AS".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AS".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AS".$ligne, "Montant contrat après avenant");

        $objPHPExcel->getActiveSheet()->mergeCells("AT".$ligne.":BE".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AT".$ligne.":BE".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AT".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AT".$ligne, "MODULE DPP");

        $objPHPExcel->getActiveSheet()->mergeCells("BF".$ligne.":BQ".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("BF".$ligne.":BQ".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("BF".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BF".$ligne, "MODULE ODC");

        $objPHPExcel->getActiveSheet()->mergeCells("BR".$ligne.":CC".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("BR".$ligne.":CC".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("BR".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BR".$ligne, "MODULE PMC");

        $objPHPExcel->getActiveSheet()->mergeCells("CD".$ligne.":CO".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("CD".$ligne.":CO".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("CD".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CD".$ligne, "MODULE GFPC");

        $objPHPExcel->getActiveSheet()->mergeCells("CP".$ligne.":DA".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("CP".$ligne.":DA".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("CP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CP".$ligne, "MODULE SEP");

        $objPHPExcel->getActiveSheet()->mergeCells("DB".$ligne.":DM".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("DB".$ligne.":DM".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("DB".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DB".$ligne, "MODULE EMIES");

        $objPHPExcel->getActiveSheet()->mergeCells("DN".$ligne.":EE".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("DN".$ligne.":EE".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("DN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DN".$ligne, "Passation des marchés BE");

        $objPHPExcel->getActiveSheet()->mergeCells("EF".$ligne.":EO".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("EF".$ligne.":EO".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EF".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EF".$ligne, "Suivi préstation BE");

        $objPHPExcel->getActiveSheet()->mergeCells("EP".$ligne.":EQ".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("EP".$ligne.":EQ".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EP".$ligne, "Suivi paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("ER".$ligne.":ER".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("ER".$ligne.":ER".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ER".$ligne, "DATE D'EXPIRATION POLICE D'ASSURANCE BE");

        $objPHPExcel->getActiveSheet()->mergeCells("ES".$ligne.":ES".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("ES".$ligne.":ES".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ES".$ligne, "Date lancement de l'Appel d'Offres de travaux");

        $objPHPExcel->getActiveSheet()->mergeCells("ET".$ligne.":ET".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("ET".$ligne.":ET".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ET".$ligne, "Date remise des Offres");

        $objPHPExcel->getActiveSheet()->mergeCells("EU".$ligne.":EU".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EU".$ligne.":EU".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EU".$ligne, "Nombre offres recues");

        $objPHPExcel->getActiveSheet()->mergeCells("EV".$ligne.":EV".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EV".$ligne.":EV".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EV".$ligne, "MPE soumissionaires (liste)");

        $objPHPExcel->getActiveSheet()->mergeCells("EW".$ligne.":EW".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EW".$ligne.":EW".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EW".$ligne, "Montant TTC offre moins chere");

        $objPHPExcel->getActiveSheet()->mergeCells("EX".$ligne.":EX".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EX".$ligne.":EX".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EX".$ligne, "Datte rapport d'évaluation");

        $objPHPExcel->getActiveSheet()->mergeCells("EY".$ligne.":EY".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EY".$ligne.":EY".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EY".$ligne, "Demande ANO DPFI");

        $objPHPExcel->getActiveSheet()->mergeCells("EZ".$ligne.":EZ".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EZ".$ligne.":EZ".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EZ".$ligne, "ANO DPFI");

        $objPHPExcel->getActiveSheet()->mergeCells("FA".$ligne.":FA".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FA".$ligne.":FA".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FA".$ligne, "Notification d'intention");

        $objPHPExcel->getActiveSheet()->mergeCells("FB".$ligne.":FB".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FB".$ligne.":FB".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FB".$ligne, "Date notification d'attribution");

        $objPHPExcel->getActiveSheet()->mergeCells("FC".$ligne.":FC".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FC".$ligne.":FC".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FC".$ligne, "Date signature contrat de travaux");

        $objPHPExcel->getActiveSheet()->mergeCells("FD".$ligne.":FD".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FD".$ligne.":FD".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FD".$ligne, "Date OS");

        $objPHPExcel->getActiveSheet()->mergeCells("FE".$ligne.":FE".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FE".$ligne.":FE".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FE".$ligne, "Titulaire des travaux");

        $objPHPExcel->getActiveSheet()->mergeCells("FF".$ligne.":FF".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FF".$ligne.":FF".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FF".$ligne, "OBSERVATIONS");

        $objPHPExcel->getActiveSheet()->mergeCells("FG".$ligne.":FL".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("FG".$ligne.":FL".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FG".$ligne, "Montant contrat");

        $objPHPExcel->getActiveSheet()->mergeCells("FM".$ligne.":FP".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("FM".$ligne.":FP".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FM".$ligne, " ");

        $objPHPExcel->getActiveSheet()->mergeCells("FQ".$ligne.":GA".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("FQ".$ligne.":GA".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FQ".$ligne, "Réception");
       
        $objPHPExcel->getActiveSheet()->mergeCells("GB".$ligne.":GB".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("GB".$ligne.":GB".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GB".$ligne, "SUIVI DATE D'EXPIRATION POLICE D'ASSURANCE MPE");

        $objPHPExcel->getActiveSheet()->mergeCells("GC".$ligne.":GD".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GC".$ligne.":GD".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GC".$ligne, "Premier paiement batiment");

        $objPHPExcel->getActiveSheet()->mergeCells("GE".$ligne.":GF".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GE".$ligne.":GF".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GE".$ligne, "Deuxième paiement batiment");

        $objPHPExcel->getActiveSheet()->mergeCells("GG".$ligne.":GH".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GG".$ligne.":GH".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GG".$ligne, "Troisième paiement batiment");

        $objPHPExcel->getActiveSheet()->mergeCells("GI".$ligne.":GJ".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GI".$ligne.":GJ".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GI".$ligne, "Quatrième paiement batiment");

        $objPHPExcel->getActiveSheet()->mergeCells("GK".$ligne.":GL".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GK".$ligne.":GL".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GK".$ligne, "Cinquième paiement batiment");

        $objPHPExcel->getActiveSheet()->mergeCells("GM".$ligne.":GN".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GM".$ligne.":GN".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GM".$ligne, "Premier paiement Latrine");

        $objPHPExcel->getActiveSheet()->mergeCells("GO".$ligne.":GP".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GO".$ligne.":GP".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GO".$ligne, "Deuxième paiement Latrine");

        $objPHPExcel->getActiveSheet()->mergeCells("GQ".$ligne.":GR".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GQ".$ligne.":GR".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GQ".$ligne, "Troisième paiement Latrine");

        $objPHPExcel->getActiveSheet()->mergeCells("GS".$ligne.":GT".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GS".$ligne.":GT".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GS".$ligne, "Premier paiement mobilier");

        $objPHPExcel->getActiveSheet()->mergeCells("GU".$ligne.":GV".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GU".$ligne.":GV".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GU".$ligne, "Deuxième paiement mobilier");

        $objPHPExcel->getActiveSheet()->mergeCells("GW".$ligne.":GX".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GW".$ligne.":GX".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GW".$ligne, "Taux d'avancement financier (%)");

        $ligne++;
        //$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(FALSE);

        $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($stylesousTitre);
       // $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Zone Côtière:C01/C02/C03/ ou Zone Hauts plateaux Rurale HPR1/HPR2/HPR3/ ou Zone Hauts plateaux Urbaine:HPU1/HPU2/HPU3");

        $objPHPExcel->getActiveSheet()->getStyle("AT".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT'.$ligne, "Date début prévisionnelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("AU".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU'.$ligne, "Date fin prévisionnelle formation");

        $objPHPExcel->getActiveSheet()->getStyle("AV".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV'.$ligne, "Date prévisionnelle de la restitution");

        $objPHPExcel->getActiveSheet()->getStyle("AW".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW'.$ligne, "Date début réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("AX".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AX'.$ligne, "Date fin réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("AY".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AY'.$ligne, "Date réelle de restitution");

        $objPHPExcel->getActiveSheet()->getStyle("AZ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AZ'.$ligne, "Nombre prévisionnel   participant");

        $objPHPExcel->getActiveSheet()->getStyle("BA".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BA'.$ligne, "Nombre de participant");

        $objPHPExcel->getActiveSheet()->getStyle("BB".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BB'.$ligne, "Nombre prévisionnel de femme participant");

        $objPHPExcel->getActiveSheet()->getStyle("BC".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BC'.$ligne, "Nombre réel de femme  participant");

        $objPHPExcel->getActiveSheet()->getStyle("BD".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BD'.$ligne, "Lieu de formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("BE".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BE'.$ligne, "observations");


        $objPHPExcel->getActiveSheet()->getStyle("BF".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BF'.$ligne, "Date début prévisionnelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BG".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BG'.$ligne, "Date fin prévisionnelle formation");

        $objPHPExcel->getActiveSheet()->getStyle("BH".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BH'.$ligne, "Date prévisionnelle de la restitution");

        $objPHPExcel->getActiveSheet()->getStyle("BI".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BI'.$ligne, "Date début réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BJ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BJ'.$ligne, "Date fin réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BK".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BK'.$ligne, "Date réelle de restitution");

        $objPHPExcel->getActiveSheet()->getStyle("BL".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BL'.$ligne, "Nombre prévisionnel   participant");

        $objPHPExcel->getActiveSheet()->getStyle("BM".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BM'.$ligne, "Nombre de participant");

        $objPHPExcel->getActiveSheet()->getStyle("BN".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BN'.$ligne, "Nombre prévisionnel de femme  participant");

        $objPHPExcel->getActiveSheet()->getStyle("BO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BO'.$ligne, "Nombre réel de femme  participant ");

        $objPHPExcel->getActiveSheet()->getStyle("BP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BP'.$ligne, "Lieu de formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("BQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BQ'.$ligne, "observations");


        $objPHPExcel->getActiveSheet()->getStyle("BR".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BR'.$ligne, "Date début prévisionnelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BS".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BS'.$ligne, "Date fin prévisionnelle formation");

        $objPHPExcel->getActiveSheet()->getStyle("BT".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BT'.$ligne, "Date prévisionnelle de la restitution");

        $objPHPExcel->getActiveSheet()->getStyle("BU".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BU'.$ligne, "Date début réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BV".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BV'.$ligne, "Date fin réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BV".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BV'.$ligne, "observations");

        $objPHPExcel->getActiveSheet()->getStyle("BW".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BW'.$ligne, "Date réelle de restitution");

        $objPHPExcel->getActiveSheet()->getStyle("BX".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BX'.$ligne, "Nombre prévisionnel   participant");

        $objPHPExcel->getActiveSheet()->getStyle("BY".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BY'.$ligne, "Nombre de participant");

        $objPHPExcel->getActiveSheet()->getStyle("BZ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BZ'.$ligne, "Nombre prévisionnel de femme participant");

        $objPHPExcel->getActiveSheet()->getStyle("CA".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CA'.$ligne, "Nombre réel de femme  participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("CB".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CB'.$ligne, "Lieu de formation");


        $objPHPExcel->getActiveSheet()->getStyle("CC".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CC'.$ligne, "observations");
        
        $objPHPExcel->getActiveSheet()->getStyle("CD".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CD'.$ligne, "Date début prévisionnelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("CE".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CE'.$ligne, "Date fin prévisionnelle formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("CF".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CF'.$ligne, "Date prévisionnelle de la restitution");


        $objPHPExcel->getActiveSheet()->getStyle("CG".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CG'.$ligne, "Date début réelle de la formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("CH".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CH'.$ligne, "Date fin réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("CI".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CI'.$ligne, "Date réelle de restitution");
        
        $objPHPExcel->getActiveSheet()->getStyle("CJ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CJ'.$ligne, "Nombre prévisionnel   participant");

        $objPHPExcel->getActiveSheet()->getStyle("CK".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CK'.$ligne, "Nombre de participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("CL".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CL'.$ligne, "Nombre prévisionnel de femme  participant");

        $objPHPExcel->getActiveSheet()->getStyle("CM".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CM'.$ligne, "Nombre réel de femme  participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("CN".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CN'.$ligne, "Lieu de formation");

        $objPHPExcel->getActiveSheet()->getStyle("CO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CO'.$ligne, "observations");
        
        $objPHPExcel->getActiveSheet()->getStyle("CP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CP'.$ligne, "Date début prévisionnelle de la formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("CQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CQ'.$ligne, "Date fin prévisionnelle formation");

        $objPHPExcel->getActiveSheet()->getStyle("CR".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CR'.$ligne, "Date prévisionnelle de la restitution");
        
        $objPHPExcel->getActiveSheet()->getStyle("CS".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CS'.$ligne, "Date début réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("CT".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CT'.$ligne, "Date fin réelle de la formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("CU".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CU'.$ligne, "Date réelle de restitution");
        
        $objPHPExcel->getActiveSheet()->getStyle("CV".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CV'.$ligne, "Nombre prévisionnel   participant");


        $objPHPExcel->getActiveSheet()->getStyle("CW".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CW'.$ligne, "Nombre de participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("CX".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CX'.$ligne, "Nombre prévisionnel de femme  participant ");


        $objPHPExcel->getActiveSheet()->getStyle("CY".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CY'.$ligne, "Nombre réel de femme  participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("CZ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CZ'.$ligne, "Lieu de formation");

        $objPHPExcel->getActiveSheet()->getStyle("DA".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DA'.$ligne, "observations");
        
        $objPHPExcel->getActiveSheet()->getStyle("DB".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DB'.$ligne, "Date début prévisionnelle de la formation");


        $objPHPExcel->getActiveSheet()->getStyle("DC".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DC'.$ligne, "Date fin prévisionnelle formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("DD".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DD'.$ligne, "Date prévisionnelle de la restitution");


        $objPHPExcel->getActiveSheet()->getStyle("DE".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DE'.$ligne, "Date début réelle de la formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("DF".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DF'.$ligne, "Date fin réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("DG".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DG'.$ligne, "Date réelle de restitution");
        
        $objPHPExcel->getActiveSheet()->getStyle("DH".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DH'.$ligne, "Nombre prévisionnel   participant");

        $objPHPExcel->getActiveSheet()->getStyle("DI".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DI'.$ligne, "Nombre de participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("DJ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DJ'.$ligne, "Nombre prévisionnel de femme  participant");

        $objPHPExcel->getActiveSheet()->getStyle("DK".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DK'.$ligne, "Nombre réel de femme  participant ");
        
        $objPHPExcel->getActiveSheet()->getStyle("DL".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DL'.$ligne, "Lieu de formation");

        $objPHPExcel->getActiveSheet()->getStyle("DM".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DM'.$ligne, "observations");


        $objPHPExcel->getActiveSheet()->getStyle("DN".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DN'.$ligne, "Date établissement shortlist");
        
        $objPHPExcel->getActiveSheet()->getStyle("DO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DO'.$ligne, "Appel à manifestation d'interêt");

        $objPHPExcel->getActiveSheet()->getStyle("DP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DP'.$ligne, "Lancement D.P.");
        
        $objPHPExcel->getActiveSheet()->getStyle("DQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DQ'.$ligne, "Remise proposition");

        $objPHPExcel->getActiveSheet()->getStyle("DR".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DR'.$ligne, "Nbre plis reçu");
        
        $objPHPExcel->getActiveSheet()->getStyle("DS".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DS'.$ligne, "Date du rapport d'évaluation");

        $objPHPExcel->getActiveSheet()->getStyle("DT".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DT'.$ligne, "Date demande ANO DPFI");
        
        $objPHPExcel->getActiveSheet()->getStyle("DU".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DU'.$ligne, "DANO DPFI");

        $objPHPExcel->getActiveSheet()->getStyle("DV".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DV'.$ligne, "Notification d'intention");

        $objPHPExcel->getActiveSheet()->getStyle("DW".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DW'.$ligne, "Notification d'attribution");
        
        $objPHPExcel->getActiveSheet()->getStyle("DX".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DX'.$ligne, "Date signature de contrat");

        $objPHPExcel->getActiveSheet()->getStyle("DY".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DY'.$ligne, "Date O.S. commencement");
        
        $objPHPExcel->getActiveSheet()->getStyle("DZ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DZ'.$ligne, "Raison sociale ou nom Consultant");

        $objPHPExcel->getActiveSheet()->getStyle("EA".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EA'.$ligne, "Statut (BE/CI)");
        
        $objPHPExcel->getActiveSheet()->getStyle("EB".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EB'.$ligne, "Montant contrat ");

        $objPHPExcel->getActiveSheet()->getStyle("EC".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EC'.$ligne, "Avenant");
        
        $objPHPExcel->getActiveSheet()->getStyle("ED".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ED'.$ligne, "Montant après avenant");
        
        $objPHPExcel->getActiveSheet()->getStyle("EE".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EE'.$ligne, "Observations");

        $objPHPExcel->getActiveSheet()->getStyle("EF".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EF'.$ligne, "Livraison Mémoire technique (MT)");
        
        $objPHPExcel->getActiveSheet()->getStyle("EG".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EG'.$ligne, "Date d'approbation MT par FEFFI");

        $objPHPExcel->getActiveSheet()->getStyle("EH".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EH'.$ligne, "Date livraison DAO");
        
        $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EI'.$ligne, "Date d'approbation DAO par FEFFI");
        
        
        $objPHPExcel->getActiveSheet()->mergeCells("EJ".$ligne.":EK".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("EJ".$ligne.":EK".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EJ'.$ligne, "Livraison Rapport mensuel ");
        
        $objPHPExcel->getActiveSheet()->mergeCells("EL".$ligne.":EM".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("EL".$ligne.":EM".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EL'.$ligne, "Date livraison");
        
        $objPHPExcel->getActiveSheet()->getStyle("EN".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EN'.$ligne, "Livraison manuel de gestion et d'entretien");
        
        $objPHPExcel->getActiveSheet()->getStyle("EO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EO'.$ligne, "Observations");

        
        $objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EP'.$ligne, "Cumul Paiement effectué");
        
        $objPHPExcel->getActiveSheet()->getStyle("EQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EQ'.$ligne, "% paiement");
        
        $objPHPExcel->getActiveSheet()->getStyle("FG".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FG'.$ligne, "bloc  de 2 sdc");
        
        $objPHPExcel->getActiveSheet()->getStyle("FH".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FH'.$ligne, " latrines");
        
        $objPHPExcel->getActiveSheet()->getStyle("FI".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FI'.$ligne, "Mobiliers");
        
        $objPHPExcel->getActiveSheet()->getStyle("FJ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FJ'.$ligne, "Montant total");
        
        $objPHPExcel->getActiveSheet()->getStyle("FK".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FK'.$ligne, "Avenant");
        
        $objPHPExcel->getActiveSheet()->getStyle("FL".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FL'.$ligne, "Montant après avenant");
        
        $objPHPExcel->getActiveSheet()->getStyle("FM".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FM'.$ligne, "Phase du sous-projet");
        
        $objPHPExcel->getActiveSheet()->getStyle("FN".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FN'.$ligne, "Date prévisionnelle début travaux");
        
        $objPHPExcel->getActiveSheet()->getStyle("FO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FO'.$ligne, "Date réelle début travaux");
        
        $objPHPExcel->getActiveSheet()->getStyle("FP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FP'.$ligne, "Délai d'exécution (jours)");
        
        $objPHPExcel->getActiveSheet()->getStyle("FQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FQ'.$ligne, "Date prévisionnelle réception technique");
        
        $objPHPExcel->getActiveSheet()->getStyle("FR".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FR'.$ligne, "Date réeelle  réception technique");
        
        $objPHPExcel->getActiveSheet()->getStyle("FS".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FS'.$ligne, "Date levée des réserves de la réception technique");
        
        $objPHPExcel->getActiveSheet()->getStyle("FT".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FT'.$ligne, "Date ptévisionnelle reception provisoire");
        
        $objPHPExcel->getActiveSheet()->getStyle("FU".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FU'.$ligne, "Date réelle reception provisoire");
        
        $objPHPExcel->getActiveSheet()->getStyle("FV".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FV'.$ligne, "Date prévisionnelle de levee des reserves avant RD");
        
        $objPHPExcel->getActiveSheet()->getStyle("FW".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FW'.$ligne, "Date réelle de levee des reserves avant RD");
        
        $objPHPExcel->getActiveSheet()->getStyle("FX".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FX'.$ligne, "Dateprévisionnelle  reception définitive");
        
        $objPHPExcel->getActiveSheet()->getStyle("FY".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FY'.$ligne, "Date réelle  reception définitive");
        
        $objPHPExcel->getActiveSheet()->getStyle("FZ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FZ'.$ligne, "Avancement physique");
        
        $objPHPExcel->getActiveSheet()->getStyle("GA".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GA'.$ligne, "OBSERVATIONS");

        $objPHPExcel->getActiveSheet()->getStyle("GC".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GC'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GD".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GD'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GE".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GE'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GF".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GF'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GG".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GG'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GH".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GH'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GI".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GI'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GJ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GJ'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GK".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GK'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GL".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GL'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GM".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GM'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GN".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GN'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GO'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GP'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GQ'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GR".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GR'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GS".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GS'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GT".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GT'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GU".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GU'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GV".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GV'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GW".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GW'.$ligne, "Cumul");
        
        $objPHPExcel->getActiveSheet()->getStyle("GX".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GX'.$ligne, "% decaissement");

        $ligne++;

        
        if ($data[0]['site'])
        {   
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $data[0]['site']->agence_acc);
        }
        if ($data[0]['ecole'])
        {
            $objPHPExcel->getActiveSheet()->getStyle("B".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, $data[0]['ecole']->code);
        }
        if ($data[0]['commune'])
        {
            $objPHPExcel->getActiveSheet()->getStyle("C".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $data[0]['commune']->nom);
        }
        if ($data[0]['cisco'])
        {
            $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $data[0]['cisco']->code);
        }
        if ($data[0]['region'])
        {
            $objPHPExcel->getActiveSheet()->getStyle("E".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $data[0]['region']->nom);
        }
        if ($data[0]['ecole'])
        {
            $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $data[0]['ecole']->libelle_zone.$data[0]['ecole']->libelle_acces);
        }

        //estomation convention
        if ($data[0]['feffi'])
        {
            $objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $data[0]['feffi']->denomination);
        }
        if ($data[0]['convention_detail'])
        {
            $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $data[0]['convention_detail']->date_signature);
        }
        if ($data[0]['convention_detail'])
        {
            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $data[0]['montant_batiment']);
        }
        if ($data[0]['convention_detail'])
        {
            $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, $data[0]['montant_latrine']);
        }
        if ($data[0]['convention_detail'])
        {
            $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $data[0]['montant_mobilier']);
        }
        if ($data[0]['convention_detail'])
        {
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L".$ligne, $data[0]['montant_maitrise']);
        
            $objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M".$ligne, $data[0]['montant_depense']);
       
            $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("N".$ligne, $data[0]['montant_sousprojet']);
        
            $objPHPExcel->getActiveSheet()->getStyle("O".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("O".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("O".$ligne, $data[0]['montant_total']);
        
            $objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("P".$ligne, $data[0]['avenant_convention']->montant);
        
            $objPHPExcel->getActiveSheet()->getStyle("Q".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("Q".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Q".$ligne, $data[0]['montant_apres_avenant']);

//SUIVI FINANCIER DAAF FEFFI
           //$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(FALSE);
            $objPHPExcel->getActiveSheet()->getStyle("R".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("R".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("R".$ligne, $data[0]['paiement1_feffi']);
        
            $objPHPExcel->getActiveSheet()->getStyle("S".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("S".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("S".$ligne, $data[0]['date1_feffi']);
       
            $objPHPExcel->getActiveSheet()->getStyle("T".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("T".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("T".$ligne, $data[0]['paiement2_feffi']);
        
            $objPHPExcel->getActiveSheet()->getStyle("U".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("U".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("U".$ligne, $data[0]['date2_feffi']);
        
            $objPHPExcel->getActiveSheet()->getStyle("V".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("V".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("V".$ligne, $data[0]['paiement3_feffi']);
        
            $objPHPExcel->getActiveSheet()->getStyle("W".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("W".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("W".$ligne, $data[0]['date3_feffi']);
        
            $objPHPExcel->getActiveSheet()->getStyle("X".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("X".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("X".$ligne, $data[0]['cumul_feffi']);
        
            $objPHPExcel->getActiveSheet()->getStyle("Y".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("Y".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Y".$ligne, $data[0]['decaissement']);
        
            $objPHPExcel->getActiveSheet()->getStyle("Z".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("Z".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Z".$ligne, $data[0]['montant_apres_avenant']);



//SUIVI FINANCIER FEFFI -PRESTATAIRE
        
        $objPHPExcel->getActiveSheet()->getStyle("AA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AA".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AA".$ligne, $data[0]['paiement_prestataire_total']);

        
        $objPHPExcel->getActiveSheet()->getStyle("AB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AB".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AB".$ligne, $data[0]['decaissement_prestataire']);

        $objPHPExcel->getActiveSheet()->getStyle("AC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AF".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AC".$ligne, "");

//SUIVI FINANCIER FEFFI FONCTIONNEMENT
        
        $objPHPExcel->getActiveSheet()->getStyle("AD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AD".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AD".$ligne, $data[0]['montant_fonct_feffi']);

        
        $objPHPExcel->getActiveSheet()->getStyle("AE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AE".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AE".$ligne, $data[0]['decaissement_fonct_feffi']);

        
        $objPHPExcel->getActiveSheet()->getStyle("AF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AF".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AF".$ligne, "");

        
        $objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AG".$ligne, $data[0]['montant_fonct_feffi']+$data[0]['paiement_prestataire_total']);

        
        $objPHPExcel->getActiveSheet()->getStyle("AH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AH".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AH".$ligne, $data[0]['montant_total']-($data[0]['montant_fonct_feffi']+$data[0]['paiement_prestataire_total']));


//Suivi Passation des marchés PR
        
        $objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AR".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AS".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
       
       if ($data[0]['passation_pr'])
       {
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AI".$ligne, $data[0]['passation_pr']->date_manifestation);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AJ".$ligne, $data[0]['passation_pr']->date_lancement_dp);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AK".$ligne, $data[0]['passation_pr']->date_remise);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AL".$ligne, $data[0]['passation_pr']->nbr_offre_recu);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AM".$ligne, $data[0]['passation_pr']->date_os);
       }

        if ($data[0]['contrat_pr'])
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AN".$ligne, $data[0]['contrat_pr']->nom);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AO".$ligne, $data[0]['contrat_pr']->montant_contrat);
        }
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AP".$ligne, $data[0]['paiement_pr_total']);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AQ".$ligne, $data[0]['decaissement_pr']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AR".$ligne, $data[0]['montant_avenant']);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AS".$ligne, $data[0]['montant_apres_avenant_pr']);        
        
        

//Suivi Module DPP
        
        $objPHPExcel->getActiveSheet()->getStyle("AT".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("AZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
       
       if ($data[0]['module_dpp'])
       {
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AT".$ligne, $data[0]['module_dpp']->date_debut_previ_form);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AU".$ligne, $data[0]['module_dpp']->date_fin_previ_form);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AV".$ligne, $data[0]['module_dpp']->date_previ_resti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AW".$ligne, $data[0]['module_dpp']->date_debut_reel_form);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AX".$ligne, $data[0]['module_dpp']->date_fin_reel_form);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AY".$ligne, $data[0]['module_dpp']->date_reel_resti);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AZ".$ligne, $data[0]['module_dpp']->nbr_previ_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BA".$ligne, $data[0]['module_dpp']->nbr_parti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BB".$ligne, $data[0]['module_dpp']->nbr_previ_fem_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BC".$ligne, $data[0]['module_dpp']->nbr_feminin);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BD".$ligne, $data[0]['module_dpp']->lieu_formation);
       }


       //Suivi Module ODC
        
        $objPHPExcel->getActiveSheet()->getStyle("BF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
       
       if ($data[0]['module_odc'])
       {
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BF".$ligne, $data[0]['module_odc']->date_debut_previ_form);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BG".$ligne, $data[0]['module_odc']->date_fin_previ_form);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BH".$ligne, $data[0]['module_odc']->date_previ_resti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BI".$ligne, $data[0]['module_odc']->date_debut_reel_form);           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BJ".$ligne, $data[0]['module_odc']->date_fin_reel_form);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BK".$ligne, $data[0]['module_odc']->date_reel_resti);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BL".$ligne, $data[0]['module_odc']->nbr_previ_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BM".$ligne, $data[0]['module_odc']->nbr_parti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BN".$ligne, $data[0]['module_odc']->nbr_previ_fem_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BO".$ligne, $data[0]['module_odc']->nbr_feminin);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BP".$ligne, $data[0]['module_odc']->lieu_formation);
       }

       //Suivi Module PMC
        
        $objPHPExcel->getActiveSheet()->getStyle("BR".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BS".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BT".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("BZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
       
       if ($data[0]['module_pmc'])
       {
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BR".$ligne, $data[0]['module_pmc']->date_debut_previ_form);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BS".$ligne, $data[0]['module_pmc']->date_fin_previ_form);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BT".$ligne, $data[0]['module_pmc']->date_previ_resti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BU".$ligne, $data[0]['module_pmc']->date_debut_reel_form);           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BV".$ligne, $data[0]['module_pmc']->date_fin_reel_form);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BW".$ligne, $data[0]['module_pmc']->date_reel_resti);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BX".$ligne, $data[0]['module_pmc']->nbr_previ_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BY".$ligne, $data[0]['module_pmc']->nbr_parti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BZ".$ligne, $data[0]['module_pmc']->nbr_previ_fem_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CA".$ligne, $data[0]['module_pmc']->nbr_feminin);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CB".$ligne, $data[0]['module_pmc']->lieu_formation);
       }

       //Suivi Module GFPC
        
        $objPHPExcel->getActiveSheet()->getStyle("CD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
       
       if ($data[0]['module_gfpc'])
       {
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CD".$ligne, $data[0]['module_gfpc']->date_debut_previ_form);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CE".$ligne, $data[0]['module_gfpc']->date_fin_previ_form);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CF".$ligne, $data[0]['module_gfpc']->date_previ_resti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CG".$ligne, $data[0]['module_gfpc']->date_debut_reel_form);           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CH".$ligne, $data[0]['module_gfpc']->date_fin_reel_form);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CI".$ligne, $data[0]['module_gfpc']->date_reel_resti);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CJ".$ligne, $data[0]['module_gfpc']->nbr_previ_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CK".$ligne, $data[0]['module_gfpc']->nbr_parti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CL".$ligne, $data[0]['module_gfpc']->nbr_previ_fem_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CM".$ligne, $data[0]['module_gfpc']->nbr_feminin);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CN".$ligne, $data[0]['module_gfpc']->lieu_formation);
       }

              //Suivi Module SEP
        
        $objPHPExcel->getActiveSheet()->getStyle("CP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CR".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CS".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CT".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("CZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
       
       if ($data[0]['module_sep'])
       {
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CP".$ligne, $data[0]['module_sep']->date_debut_previ_form);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CQ".$ligne, $data[0]['module_sep']->date_fin_previ_form);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CR".$ligne, $data[0]['module_sep']->date_previ_resti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CS".$ligne, $data[0]['module_sep']->date_debut_reel_form);           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CT".$ligne, $data[0]['module_sep']->date_fin_reel_form);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CU".$ligne, $data[0]['module_sep']->date_reel_resti);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CV".$ligne, $data[0]['module_sep']->nbr_previ_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CW".$ligne, $data[0]['module_sep']->nbr_parti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CX".$ligne, $data[0]['module_sep']->nbr_previ_fem_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CY".$ligne, $data[0]['module_sep']->nbr_feminin);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CZ".$ligne, $data[0]['module_sep']->lieu_formation);
       }

    //Suivi Module EMIES
        
        $objPHPExcel->getActiveSheet()->getStyle("DB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
       
       if ($data[0]['module_emies'])
       {
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DB".$ligne, $data[0]['module_emies']->date_debut_previ_form);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DC".$ligne, $data[0]['module_emies']->date_fin_previ_form);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DD".$ligne, $data[0]['module_emies']->date_previ_resti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DE".$ligne, $data[0]['module_emies']->date_debut_reel_form);           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DF".$ligne, $data[0]['module_emies']->date_fin_reel_form);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DG".$ligne, $data[0]['module_emies']->date_reel_resti);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DH".$ligne, $data[0]['module_emies']->nbr_previ_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DI".$ligne, $data[0]['module_emies']->nbr_parti);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DJ".$ligne, $data[0]['module_emies']->nbr_previ_fem_parti);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DK".$ligne, $data[0]['module_emies']->nbr_feminin);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DL".$ligne, $data[0]['module_emies']->lieu_formation);
       }

    //Suivi Module PASSATION BE
        
        $objPHPExcel->getActiveSheet()->getStyle("DN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DR".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DS".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DT".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("DZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("EA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("EB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("EC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("ED".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("EE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
       
       if ($data[0]['passation_moe'])
       {
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DN".$ligne, $data[0]['passation_moe']->date_shortlist);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DO".$ligne, $data[0]['passation_moe']->date_manifestation);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DP".$ligne, $data[0]['passation_moe']->date_lancement_dp);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DQ".$ligne, $data[0]['passation_moe']->date_remise);           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DR".$ligne, $data[0]['passation_moe']->nbr_offre_recu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DS".$ligne, $data[0]['passation_moe']->date_rapport_evaluation);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DT".$ligne, $data[0]['passation_moe']->date_demande_ano_dpfi);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DU".$ligne, $data[0]['passation_moe']->date_ano_dpfi);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DV".$ligne, $data[0]['passation_moe']->notification_intention);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DW".$ligne, $data[0]['passation_moe']->date_notification_attribution);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DX".$ligne, $data[0]['passation_moe']->date_signature_contrat);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DY".$ligne, $data[0]['passation_moe']->date_os);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EA".$ligne, $data[0]['passation_moe']->statut);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EE".$ligne, $data[0]['passation_moe']->observation);
       }

       if ($data[0]['contrat_moe'])
       {        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DZ".$ligne, $data[0]['contrat_moe']->nom);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EB".$ligne, $data[0]['contrat_moe']->montant_contrat);
       }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EC".$ligne, $data[0]['montant_avenant_moe']);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ED".$ligne, $data[0]['montant_apre_avenant_moe']);

            $objPHPExcel->getActiveSheet()->getStyle("EF".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("EF".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EF".$ligne, $data[0]['date_liv_mt']);
        
            $objPHPExcel->getActiveSheet()->getStyle("EG".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("EG".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EG".$ligne, $data[0]['date_appro_mt']);
       
            $objPHPExcel->getActiveSheet()->getStyle("EH".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("EH".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EH".$ligne, $data[0]['date_liv_dao']);
        
            $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EI".$ligne, $data[0]['date_appro_dao']);
        
            $objPHPExcel->getActiveSheet()->getStyle("EN".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EN".$ligne, $data[0]['date_liv_mg']);
        
            $objPHPExcel->getActiveSheet()->getStyle("EO".$ligne)->applyFromArray($stylecontenu);
        
            $objPHPExcel->getActiveSheet()->getStyle("ER".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ER".$ligne, $data[0]['date_expir_pa']);
            $lignerapport = $ligne;
            $i=1;
            foreach ($data[0]['rapport_mensuel'] as $key => $value)
            {
                $objPHPExcel->getActiveSheet()->mergeCells("EJ".$lignerapport.":EK".$lignerapport);
                $objPHPExcel->getActiveSheet()->getStyle("EJ".$lignerapport.":EK".$lignerapport)->applyFromArray($stylecontenu);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EJ".$lignerapport, 'Livraison Rapport mensuel '.$i);

                $objPHPExcel->getActiveSheet()->mergeCells("EL".$lignerapport.":EM".$lignerapport);
                $objPHPExcel->getActiveSheet()->getStyle("EL".$lignerapport.":EM".$lignerapport)->applyFromArray($stylecontenu);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EL".$lignerapport, $value->date_livraison);
                $lignerapport++;
                $i++;
            }

            $objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EP".$ligne, $data[0]['cumul_paiement_moe']);
        
            $objPHPExcel->getActiveSheet()->getStyle("EQ".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EQ".$ligne, $data[0]['decaissement_paiement_moe']);

//PASSATION MPE
        
        $objPHPExcel->getActiveSheet()->getStyle("ES".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("ET".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("EU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("EV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("EW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("EX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("EY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("EZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true)
        $objPHPExcel->getActiveSheet()->getStyle("FL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true)
       
       if ($data[0]['passation_mpe'])
       {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ES".$ligne, $data[0]['passation_mpe']->date_lancement);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ET".$ligne, $data[0]['passation_mpe']->date_remise);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EU".$ligne, $data[0]['passation_mpe']->nbr_soumissionnaire);            
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("EV".$ligne, $data[0]['passation_mpe']->);           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EW".$ligne, $data[0]['passation_mpe']->montant_moin_chere);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EX".$ligne, $data[0]['passation_mpe']->date_rapport_evaluation);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EY".$ligne, $data[0]['passation_mpe']->date_demande_ano_dpfi);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EZ".$ligne, $data[0]['passation_mpe']->date_ano_dpfi);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FA".$ligne, $data[0]['passation_mpe']->notification_intention);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FB".$ligne, $data[0]['passation_mpe']->date_notification_attribution);            
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("FC".$ligne, $data[0]['passation_mpe']->date_signature);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FD".$ligne, $data[0]['passation_mpe']->date_os);
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("FE".$ligne, $data[0]['passation_mpe']->Titulaire);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FF".$ligne, $data[0]['passation_mpe']->observation);

            $lignerapport = $ligne;
            foreach ($data[0]['passation_mpe']->mpe_soumissionaire as $key1 => $value1)
            {
                $objPHPExcel->getActiveSheet()->getStyle("EV".$lignerapport)->applyFromArray($stylecontenu);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EV".$lignerapport, $value1->nom);
                $lignerapport++;
            }
       }
       if ($data[0]['contrat_mpe'])
       {
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FC".$ligne, $data[0]['contrat_mpe']->date_signature);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FE".$ligne, $data[0]['contrat_mpe']->nom);

           $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FG".$ligne, $data[0]['contrat_mpe']->cout_batiment);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FH".$ligne, $data[0]['contrat_mpe']->cout_latrine);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FI".$ligne, $data[0]['contrat_mpe']->cout_mobilier);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FJ".$ligne, $data[0]['contrat_mpe']->cout_batiment+$data[0]['contrat_mpe']->cout_latrine+$data[0]['contrat_mpe']->cout_mobilier);
       }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FK".$ligne, $data[0]['montant_avenant_mpe']);            
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FL".$ligne, $data[0]['montant_apre_avenant_mpe']);


        
      // prestation mpe
        $objPHPExcel->getActiveSheet()->getStyle("FM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true)
        $objPHPExcel->getActiveSheet()->getStyle("GB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true)
       
       if ($data[0]['prestation_mpe'])
       {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FM".$ligne, $data[0]['prestation_mpe']->libelle);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FN".$ligne, $data[0]['prestation_mpe']->date_pre_debu_trav);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FO".$ligne, $data[0]['prestation_mpe']->date_reel_debu_trav);           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FP".$ligne, $data[0]['prestation_mpe']->delai_execution);           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GB".$ligne, $data[0]['prestation_mpe']->date_expiration_assurance_mpe);

       }

       // RECEPTION mpe
        $objPHPExcel->getActiveSheet()->getStyle("FQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FR".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FS".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FT".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true)
        $objPHPExcel->getActiveSheet()->getStyle("FV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("FZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true)
        $objPHPExcel->getActiveSheet()->getStyle("GA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
       
       if ($data[0]['reception_mpe'])
       {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FQ".$ligne, $data[0]['reception_mpe']->date_previ_recep_tech);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FR".$ligne, $data[0]['reception_mpe']->date_reel_tech);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FS".$ligne, $data[0]['reception_mpe']->date_leve_recep_tech);           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FT".$ligne, $data[0]['reception_mpe']->date_previ_recep_prov);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FU".$ligne, $data[0]['reception_mpe']->date_reel_recep_prov);       
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FV".$ligne, $data[0]['reception_mpe']->date_previ_leve);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FW".$ligne, $data[0]['reception_mpe']->date_reel_lev_ava_rd);           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FX".$ligne, $data[0]['reception_mpe']->date_previ_recep_defi);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FY".$ligne, $data[0]['reception_mpe']->date_reel_recep_defi); 

       }

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FZ".$ligne, $data[0]['avancement']);

            $objPHPExcel->getActiveSheet()->getStyle("GC".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
           
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GC".$ligne, $data[0]['paiement1_batiment_pre']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GD".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GD".$ligne, $data[0]['date_approbation1_batiment_pre']);

            $objPHPExcel->getActiveSheet()->getStyle("GE".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GE".$ligne, $data[0]['paiement2_batiment_pre']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GF".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GF".$ligne, $data[0]['date_approbation2_batiment_pre']);

            $objPHPExcel->getActiveSheet()->getStyle("GG".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GG".$ligne, $data[0]['paiement3_batiment_pre']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GH".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GH".$ligne, $data[0]['date_approbation3_batiment_pre']);

            $objPHPExcel->getActiveSheet()->getStyle("GI".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GI".$ligne, $data[0]['paiement4_batiment_pre']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GJ".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GJ".$ligne, $data[0]['date_approbation4_batiment_pre']);

            $objPHPExcel->getActiveSheet()->getStyle("GK".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GK".$ligne, $data[0]['paiement5_batiment_pre']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GL".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GL".$ligne, $data[0]['date_approbation5_batiment_pre']);

            $objPHPExcel->getActiveSheet()->getStyle("GM".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GM".$ligne, $data[0]['paiement1_latrine_pre']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GN".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GN".$ligne, $data[0]['date_approbation1_latrine_pre']);

            $objPHPExcel->getActiveSheet()->getStyle("GO".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GO".$ligne, $data[0]['paiement2_latrine_pre']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GP".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GP".$ligne, $data[0]['date_approbation2_latrine_pre']);

            $objPHPExcel->getActiveSheet()->getStyle("GQ".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GQ".$ligne, $data[0]['paiement3_latrine_pre']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GR".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GR".$ligne, $data[0]['date_approbation3_latrine_pre']);

            $objPHPExcel->getActiveSheet()->getStyle("GS".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GS".$ligne, $data[0]['paiement1_mobilier_pre']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GT".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GT".$ligne, $data[0]['date_approbation1_mobilier_pre']);

            $objPHPExcel->getActiveSheet()->getStyle("GU".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GU".$ligne, $data[0]['paiement2_mobilier_pre']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GV".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GV".$ligne, $data[0]['date_approbation2_mobilier_pre']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GW".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GW".$ligne, $data[0]['cumul_mobilier']+$data[0]['cumul_latrine']+$data[0]['cumul_batiment']);
        
            $objPHPExcel->getActiveSheet()->getStyle("GX".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GX".$ligne, (($data[0]['cumul_mobilier']+$data[0]['cumul_latrine']+$data[0]['cumul_batiment'])*100)/($data[0]['contrat_mpe']->cout_batiment+$data[0]['contrat_mpe']->cout_latrine+$data[0]['contrat_mpe']->cout_mobilier));
            
            $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GY".$ligne, $data[0]['transfert_reliquat']->montant);
                $affiche1 = "Fournir des fourniture";
                $affiche2 = "Transferer";
                if ($data[0]['transfert_reliquat']->objet_utilisation==0) {
                   
                    $affiche = "Amelioration infrastructure";
                   
                }
                $objPHPExcel->getActiveSheet()->getStyle("GZ".$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GZ".$ligne, $affiche);

                if ($data[0]['transfert_reliquat']->validation==0) {
                
                    $affiche2 = "Pas Transferer";
                
                }


                $objPHPExcel->getActiveSheet()->getStyle("HA".$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HA".$ligne, $affiche2);

                $objPHPExcel->getActiveSheet()->getStyle("HB".$ligne)->applyFromArray($stylecontenu);
        
        $objPHPExcel->getActiveSheet()->getStyle("A5:HB".$ligne)->getAlignment()->setWrapText(true);
        
    }
        

        /*$objPHPExcel->getActiveSheet()->mergeCells("GY".$ligne.":HO".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne.":HO".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GY'.$ligne, "(7) INDICATEURS");*/
       /*

        if ($pivot=="mois_id_unite_peche_and_id_espece")
        {
            $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":H".$ligne);
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->applyFromArray($styleTitre);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, 'L4.3 & L4.4 Mois, Unité de pêche et Espèce');                       
            $ligne++;
            $ligne_entete= $this->insertion_entete($styleEntete,$ligne,$objPHPExcel,$id_region,$id_district,$id_site_embarquement,$id_unite_peche,$id_espece);
            if ($ligne_entete!=$ligne)
            {
                $ligne=$ligne_entete+1;
            }

            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel-> getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->getNumberFormat()->setFormatCode('00');
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, ' Mois'.'        ');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, 'Unite de pêche');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, 'Nom local');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Nom scientifique');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, 'Captures totales');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, 'Valeurs totales');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Moy Erreur Rel PUE 90%');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, 'Moy Erreur Rel Capture 90%');
            $ligne++;
            foreach ($data as $key => $value)
            {
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->applyFromArray($stylecontenu);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$value['mois']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne,$value['unite_peche']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $value['espece_nom_local']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value['espece_nom_scientifique']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $this->conversion_kg_tonne($value['capture']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, number_format($value['prix'],0,","," ")." Ar");
               
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value['erreur_relative']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value['erreur_rel_capture']);

                $ligne++;
            }
            $objPHPExcel->getActiveSheet()->getStyle("D".$ligne.":H".$ligne)->applyFromArray($stylepied);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Total');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $this->conversion_kg_tonne($total['total_capture']));

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, number_format($total['total_prix'],0,","," ")." Ar /".number_format($total['total_prix']*5,0,","," ")." Fmg");

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $total['erreur_relative_total']);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $total['erreur_relative_capture_total']);
          
        }

         if ($pivot=="mois_id_site_embarquement_id_unite_peche_and_id_espece")
        {
            $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":I".$ligne);
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->applyFromArray($styleTitre);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, 'L4.5 Mois,Site de débarquement, Unité de pêche et Espèce');                       
            $ligne++;
            $ligne_entete= $this->insertion_entete($styleEntete,$ligne,$objPHPExcel,$id_region,$id_district,$id_site_embarquement,$id_unite_peche,$id_espece);
            if ($ligne_entete!=$ligne)
            {
                $ligne=$ligne_entete+1;
            }

            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel-> getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->getNumberFormat()->setFormatCode('00');
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, ' Mois'.'        ');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, 'Site d\'enquête');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, 'Unité de pêche');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Nom local');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, 'Nom scientifique');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, 'Captures totales');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Valeurs totales');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, 'Moy Erreur Rel PUE 90%');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Moy Erreur Rel Capture 90%');
            $ligne++;
            foreach ($data as $key => $value)
            {
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->applyFromArray($stylecontenu);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$value['mois']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne,$value['site_embarquement']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne,$value['unite_peche']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne,$value['espece_nom_local']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value['espece_nom_scientifique']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $this->conversion_kg_tonne($value['capture']));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, number_format($value['prix'],0,","," ")." Ar");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value['erreur_relative']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value['erreur_rel_capture']);

                $ligne++;
            }
            $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":I".$ligne)->applyFromArray($stylepied);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, 'Total');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $this->conversion_kg_tonne($total['total_capture']));

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, number_format($total['total_prix'],0,","," ")." Ar /".number_format($total['total_prix']*5,0,","," ")." Fmg");

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $total['erreur_relative_total']);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $total['erreur_relative_capture_total']);
          
        }*/

        try
        {
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save(dirname(__FILE__) . "/../../../../../../assets/excel/bdd_construction/".$nom_file.".xlsx");
            
            $this->response([
                'status' => TRUE,
                'nom_file' =>$nom_file.".xlsx",
                'message' => 'Get file success',
            ], REST_Controller::HTTP_OK);
          
        } 
        catch (PHPExcel_Writer_Exception $e)
        {
            $this->response([
                  'status' => FALSE,
                   'nom_file' => $paiement_batiment_pre,
                   'message' => "Something went wrong: ". $e->getMessage(),
                ], REST_Controller::HTTP_OK);
        }

    }

    public function insertion_entete($style,$ligne,$objPHPExcel,$id_region,$id_district,$id_site_embarquement,$id_unite_peche,$id_espece)
    {

        if($id_region!='*' && $id_region!="undefined")
        {
            $tmp= $this->RegionManager->findById($id_region);

            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
               
            $objRichText = new PHPExcel_RichText();

            $titre = $objRichText->createTextRun('Region : ');
            $titre->getFont()->applyFromArray(array( "bold" => true, "size" => 11, "name" => "Calibri"));

            $contenu = $objRichText->createTextRun($tmp->nom);
            $contenu->getFont()->applyFromArray(array("size" => 11, "name" => "Calibri"));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$objRichText);
            $ligne++;
        }
        if($id_district!='*' && $id_district!="undefined")
        {
            $tmp= $this->DistrictManager->findById($id_district);
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
               
            $objRichText = new PHPExcel_RichText();

            $titre = $objRichText->createTextRun('District : ');
            $titre->getFont()->applyFromArray(array( "bold" => true, "size" => 11, "name" => "Calibri"));

            $contenu = $objRichText->createTextRun($tmp->nom);
            $contenu->getFont()->applyFromArray(array("size" => 11, "name" => "Calibri"));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$objRichText);
            $ligne++;
        }
        if($id_site_embarquement!='*' && $id_site_embarquement!="undefined")
        {
            $tmp= $this->Site_embarquementManager->findById($id_site_embarquement);

            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
            $objRichText = new PHPExcel_RichText();

            $titre = $objRichText->createTextRun('Site de débarquement : ');
            $titre->getFont()->applyFromArray(array( "bold" => true, "size" => 11, "name" => "Calibri"));

            $contenu = $objRichText->createTextRun($tmp->libelle);
            $contenu->getFont()->applyFromArray(array("size" => 11, "name" => "Calibri"));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$objRichText);

            $ligne++;
        }
        if($id_unite_peche!='*' && $id_unite_peche!="undefined")
        {
            $tmp= $this->Unite_pecheManager->findById($id_unite_peche);

            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
             $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->getAlignment()->setWrapText(false);  
            $objRichText = new PHPExcel_RichText();

            $titre = $objRichText->createTextRun('Unite de pêche : ');
            $titre->getFont()->applyFromArray(array( "bold" => true, "size" => 11, "name" => "Calibri"));

            $contenu = $objRichText->createTextRun($tmp->libelle);
            $contenu->getFont()->applyFromArray(array("size" => 11, "name" => "Calibri"));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$objRichText);
            $ligne++;
        }
        if($id_espece!='*' && $id_espece!="undefined")
        {
            $tmp= $this->EspeceManager->findById($id_espece);

            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
             $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->getAlignment()->setWrapText(false);  
            $objRichText = new PHPExcel_RichText();

            $titre = $objRichText->createTextRun('Espece : ');
            $titre->getFont()->applyFromArray(array( "bold" => true, "size" => 11, "name" => "Calibri"));

            $contenu = $objRichText->createTextRun($tmp->nom_scientifique." (".$tmp->nom_local.")");
            $contenu->getFont()->applyFromArray(array("size" => 11, "name" => "Calibri"));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$objRichText);
            $ligne++;
        }

        return $ligne;
    }

    public function conversion_kg_tonne($val)
    {   
        if ($val > 1000) 
        {
          $res = $val/1000 ;
          $res=number_format(($val/1000),3,","," ");

          return $res." t" ;
        }
        else
        { 
            $res=number_format($val,3,","," ");

            return $res." Kg" ;
        }
    }    

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
?>