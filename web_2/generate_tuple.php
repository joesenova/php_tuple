<?php
ini_set('memory_limit',-1);
ini_set('max_execution_time', 0);


/**
*
* @author 	Johan Kasselman <johankasselman@live.com>
* @since 	27/05/2017
*
*/

//-----------------------------------------------------------------------------------------------

//Set empty Error array
$aError = array();// Define empty error array

//Set all the Requested parameters into varuables
extract($_REQUEST); //Converts the URL params to PHP varuables

//Include all classes
include 'tuple.class.php';
//-----------------------------------------------------------------------------------------------

do{

	if((!empty($_FILES["file"])) && ($_FILES['file']['error'] == 0)) {
	
		$limitSize	= 2048000; // (~2MB)
		$fileName	= basename($_FILES['file']['name']);
		$fileSize	= $_FILES["file"]["size"];
		$fileExt	= substr($fileName, strrpos($fileName, '.') + 1);
		
		if(($fileExt == "csv") && ($fileSize < $limitSize)){
			$cfileName = $_FILES['file']['tmp_name'];
		}else{
			$aError[] =  "Sorry, this script only allowes .csv file under '.($limitSize/1000).' Kb!";
			break;
		}
	}else{
		$cfileName = 'Loans.csv';
	}

	$oCsv = new CSV();
	$aFile = $oCsv->processCsv($cfileName);

	if(!is_array($aFile)){
		$aError[] = "File parse error !object";
		break;
	}

	if($lDebug){
		echo '<pre>';
			print_r($aFile);
		echo '</pre>';
	}

	$oDetails = new CalculateDetails();
	$oTuple = $oDetails->getCalculatedTuple($aFile);

	if($lDebug){
		print_r($oTuple);
		break;
	}

	$cTuple = json_encode($oTuple);
	
	$file = 'Output.txt';
	// Write the contents back to the file
	file_put_contents($file, $cTuple);

	?>
		<textarea style="width: 600px; height: 100px;"><?= $cTuple; ?></textarea>
			<br />
		<a href="Output.csv">Download Output.csv</a>
			<br />
		<a href="index.php">Upload another file!</a>
	<?php

}while(0);

if($aError){
	if($lDebug){
		print implode("\n", $aError);
	}else{
		$cResponse = implode(", ", $aError);
		print $cResponse;
	}
}


?>