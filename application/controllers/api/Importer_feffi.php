<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer_feffi extends CI_Controller {
    public function __construct() {
        parent::__construct();        
        $this->load->model('ecole_model', 'EcoleManager');       
        $this->load->model('region_model', 'RegionManager');       
        $this->load->model('cisco_model', 'CiscoManager');      
        $this->load->model('commune_model', 'CommuneManager');       
        $this->load->model('zap_model', 'ZapManager');         
        $this->load->model('zap_commune_model', 'Zap_communeManager');     
        $this->load->model('fokontany_model', 'FokontanyManager');   
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');   
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('compte_feffi_model', 'Compte_feffiManager');
        

    }

	public function remove_upload_file()
	{	
		$chemin= $_POST['chemin'];
		$directoryName = dirname(__FILE__)."/../../../../../../assets/excel".$chemin;
	  	$delete = unlink($directoryName);
	}


	public function testfeffi() {

		$erreur="aucun";
		ini_set('upload_max_filesize', '200000000000000000M');  
		ini_set('post_max_size', '2000000000000000000000M');
		
        ini_set ('memory_limit', '100000000000000000000000M');
		$replace=array('e','e','e','a','o','c','_');
		$search= array('é','è','ê','à','ö','ç',' ');

		$replacename=array('_','_','_');
		$searchname= array('/','"\"',' ');

		$repertoire=$_POST['repertoire'];
		$name_fichier=$_POST['name_fichier'];

		$repertoire=str_replace($search,$replace,$repertoire);
		$name_fichier=str_replace($searchname,$replacename,$name_fichier);
		//The name of the directory that we need to create.
		$directoryName = dirname(__FILE__) ."/../../../../../../assets/excel/" .$repertoire;
		//Check if the directory already exists.
		if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0777,true);
		}				

		$rapport=array();
		//$rapport['repertoire']=dirname(__FILE__) ."/../../../../../../assets/ddb/" .$repertoire;
		$config['upload_path']          = dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire;
		$config['allowed_types'] = 'xls|xlsx';
		$config['max_size'] = 200000000;
		$config['overwrite'] = TRUE;
		if (isset($_FILES['file']['tmp_name']))
		{
			$name=$_FILES['file']['name'];
			$name1=str_replace($searchname,$replacename,$name);
			$file_ext = pathinfo($name,PATHINFO_EXTENSION);
			//$rapport['nomFile']=$name_fichier.'.'.$file_ext;
			$rapport['nomFile']=$name_fichier;
			$config['file_name']=$name_fichier;
			//$rapport['repertoire']=$name_image;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			//$ff=$this->upload->do_upload('file');
			if(!$this->upload->do_upload('file'))
			{
				$error = array('error' => $this->upload->display_errors());
				//$rapport["erreur"]= 'Type d\'image invalide. Veuillez inserer une image.png';
				$rapport["erreur"]= true;
				$rapport["erreur_value"]= $error;
				echo json_encode($rapport);
			}else{
				ini_set('upload_max_filesize', '2000000000M');  
		ini_set('post_max_size', '2000000000M');
		set_time_limit(0);
        ini_set ('memory_limit', '100000000000000M');
				$retour = $this->controler_donnees_importertestecole($name1,$repertoire);
				$rapport['nbr_inserer']=$retour['nbr_inserer'];
				$rapport['nbr_refuser']=$retour['nbr_erreur'];
				$rapport['zap_inserer']=$retour['zap_inserer'];
				$rapport['erreur']=false;
				$rapport["erreur_value"]= '' ;
				echo json_encode($rapport);
			}
			
		} else {


			$rapport["erreur"]= true ;
			$rapport["erreur_value"]= 'File upload not found' ;
           // echo 'File upload not found';
            echo json_encode($rapport);
		} 
		
	}
	public function controler_donnees_importertestecole($filename,$directory) {
		require_once 'Classes/PHPExcel.php';
		require_once 'Classes/PHPExcel/IOFactory.php';
		ini_set('upload_max_filesize', '2000000000M');  
		ini_set('post_max_size', '2000000000M');
		set_time_limit(0);
        ini_set ('memory_limit', '100000000000000M');
		$replace=array('e','e','e','a','o','c','_');
		$search= array('é','è','ê','à','ö','ç',' ');
		$repertoire= $directory;
		$nomfichier = $filename;		
		$repertoire=str_replace($search,$replace,$repertoire);
		$erreur=false;
		//$user_ok=false;
		$nbr_erreur=0;
		$nbr_inserer=0;
		$zap_inserer = array();
		//The name of the directory that we need to create.
		$directoryName = dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire;
		//Check if the directory already exists.
		if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0777,true);
		}	
		$chemin=dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire;
		$lien_vers_mon_document_excel = $chemin . $nomfichier;
		$array_data = array();
		if(strpos($lien_vers_mon_document_excel,"xlsx") >0) {
			// pour mise à jour après : G4 = id_fiche_paiement <=> déjà importé => à ignorer
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$rowIterator = $Excel->getActiveSheet()->getRowIterator();

		foreach($rowIterator as $row)
		{			
			$ligne = $row->getRowIndex ();
			$erreur = false;
				if($ligne >=10)
				{
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);
					$rowIndex = $row->getRowIndex ();
					foreach ($cellIterator as $cell)
					{
						if('B' == $cell->getColumn())
						{
							$eco =$cell->getValue();
						}  
						else if('D' == $cell->getColumn())
						{
							$foko =$cell->getValue();							
						}  
						else if('E' == $cell->getColumn())
						{
							$com =$cell->getValue();							
						}  
						else if('F' == $cell->getColumn())
						{
							$cis =$cell->getValue();							
						}  
						else if('G' == $cell->getColumn())
						{
							$reg =$cell->getValue();							
						}  
						else if('H' == $cell->getColumn())
						{
							$acc =$cell->getValue();							
						} 
						else if('I' == $cell->getColumn())
						{
							$fef =$cell->getValue();							
						}	 
					}
					
					// Si donnée incorrect : coleur cellule en rouge
					
					if($reg=="")
					{						
						$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					else
					{
						// Vérifier si nom_feffi existe dans la BDD
						$regn=strtolower($reg);
						$retour_region = $this->RegionManager->getregiontest($regn);
						if(count($retour_region) >0)
						{
							foreach($retour_region as $k=>$v)
							{
								$id_region = $v->id;
							}	
						}
						else
						{
							$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f24141'),
											 'endcolor'   => array('rgb' => 'f24141')
										 )
							);
							$erreur = true;
							$sheet->setCellValue('IQ'.$ligne, 'retour_region');
						}
					}
					if($cis=="")
					{						
						$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					else
					{
						// Vérifier si nom_feffi existe dans la BDD
						$cisn=strtolower($cis);
						$regn=strtolower($reg);
						$retour_cisco = $this->CiscoManager->getciscotest($cisn,$regn);
						if(count($retour_cisco) >0)
						{
							foreach($retour_cisco as $k=>$v)
							{
								$id_cisco = $v->id;
							}	
						}
						else
						{
							$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f24141'),
											 'endcolor'   => array('rgb' => 'f24141')
										 )
							);
							$erreur = true;
							$sheet->setCellValue('IQ'.$ligne, 'retour_cisco');
						}
					}
					
					if($com=="")
					{						
						$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;	
						$sheet->setCellValue('IQ'.$ligne, 'retour_commune1');												
					}
					else
					{
						// Vérifier si nom_feffi existe dans la BDD
						$regn=strtolower($reg);
						$distn=strtolower($cis);
						$comn=strtolower($com);
						$retour_commune = $this->CommuneManager->getcommunetest($regn,$distn,$comn);
						if(count($retour_commune) >0)
						{
							foreach($retour_commune as $k=>$v)
							{
								$id_commune = $v->id;
							}	
						}
						else
						{
							$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f24141'),
											 'endcolor'   => array('rgb' => 'f24141')
										 )
							);
							$erreur = true;
							$sheet->setCellValue('IQ'.$ligne, 'retour_commune');
						}
					}
					if($foko=="")
					{						
						$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					else
					{
						// Vérifier si nom_feffi existe dans la BDD
						$fokon=strtolower($foko);
						$retour_fokontany = $this->FokontanyManager->getfokontanytestbyid_commune($id_commune,$fokon);
						if(count($retour_fokontany) >0)
						{
							foreach($retour_fokontany as $k=>$v)
							{
								$id_fokontany = $v->id;
							}	
						}
						else
						{
							$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f24141'),
											 'endcolor'   => array('rgb' => 'f24141')
										 )
							);
							$erreur = true;
							$sheet->setCellValue('IQ'.$ligne, 'retour_fokontany');
						}
					}
					
					if($eco=="")
					{						
						$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					else
					{
						// Vérifier si nom_feffi existe dans la BDD
						$econ=strtolower($eco);
						$retour_ecole = $this->EcoleManager->getecoletestbyid_fokontany($id_fokontany,$econ);
						if(count($retour_ecole) >0)
						{
							foreach($retour_ecole as $k=>$v)
							{
								$id_ecole = $v->id;
								$code = $v->code;
								$description = $v->description;
								$lieu = $v->lieu;
								$latitude = $v->latitude;
								$longitude = $v->longitude;
								$altitude = $v->altitude;
								$id_zap = $v->id_zap;
								
							}	
						}
						else
						{
							$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f24141'),
											 'endcolor'   => array('rgb' => 'f24141')
										 )
							);
							$erreur = true;
							$sheet->setCellValue('IQ'.$ligne, $id_fokontany.$econ);
						}
					}
					
					if($fef=="")
					{						
						$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					/*$id_region =1;
					$id_cisco=1;
					$id_commune=1;
					$id_zap=1;
					$id_fokontany=1;*/
					if($erreur==false)
					{	
						$fefn=strtolower($fef);						
						$doublon = $this->FeffiManager->getfeffitest($id_ecole,$fefn);
						if (count($doublon)>0)//mis doublon
						{
							$sheet->setCellValue('IO'.$ligne, "Doublon");
							array_push($zap_inserer, $doublon);
							$nbr_erreur = $nbr_erreur + 1;							
						}
						else//ts doublon
						{

		                		//$dataId = $this->ZapManager->add($data); 
		                	
								$sheet->setCellValue('IO'.$ligne, "ok"); 
								$data = array(
									'identifiant' => $fef,
									'denomination' => $fef,
									'adresse' => $foko,
									'observation' => null,
									'id_ecole' => $id_ecole
									
									);
								$dataId = $this->FeffiManager->add($data);

								$datacompte = array(
									'nom_banque' => "xxx",
									'rib' => "1234",
									'numero_compte' => "1234",
									'adresse_banque' => "xxx",
									'id_feffi' => $dataId
									
									);
								$dataIdcompte = $this->Compte_feffiManager->add($datacompte);	
		                	//array_push($zap_inserer, $data);
							$nbr_inserer = $nbr_inserer + 1;
						}
	        																
					}
					else//mis erreur
					{
						$sheet->setCellValue('IO'.$ligne, "erreur");
						$nbr_erreur = $nbr_erreur + 1;
					}						
						
					$ligne = $ligne + 1;
				}
			
			
		}
		//$report['requete']=$subvention_initial;
		$report['nbr_erreur']=$nbr_erreur;
		$report['nbr_inserer']=$nbr_inserer;
		//$report['user']=$type_latrine;
		$report['zap_inserer']=$zap_inserer;
		//echo json_encode($report);	
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$objWriter->save(dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire. $nomfichier);
		unset($excel);
		unset($objWriter);
		return $report;
	}

////////////////////////////////////////////////////////////////////


} ?>	
