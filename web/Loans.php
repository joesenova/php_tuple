<?php
ini_set('memory_limit',-1);
ini_set('max_execution_time', 0);


/**
*
* @author 	Johan Kasselman <johankasselman@live.com>
* @since 	26/05/2017
*
*/

//-----------------------------------------------------------------------------------------------

//Set empty Error array
$aError = array();// Define empty error array

//Set all the Requested parameters into varuables
extract($_POST); //Converts the URL params to PHP varuables
//-----------------------------------------------------------------------------------------------
do{
	
	if((!empty($_FILES["file"])) && ($_FILES['file']['error'] == 0)) {
	
		// $limitSize	= 15000; //(15 kb) - Maximum size of uploaded file, change it to any size you want

		$limitSize	= 2048000; // (~2MB)
		$fileName	= basename($_FILES['file']['name']);
		$fileSize	= $_FILES["file"]["size"];
		$fileExt	= substr($fileName, strrpos($fileName, '.') + 1);
		
		if(($fileExt == "csv") && ($fileSize < $limitSize)){
			$aFile = readCSV( $_FILES['file']['tmp_name'] );

		}else{
			$aError[] =  "Sorry, this script only allowes .csv file under '.($limitSize/1000).' Kb!";
		}
	}

	if(!is_array($aFile)){
		$aError[] = "File parse error !object";
		break;
	}

	$aOut = array();
	$total_loan_count = 0;
	$total_loan_total = 0;
	foreach($aFile as $aRow){
		$network = $aRow[1];
		$product = $aRow[3];
		$aMonth = explode("-", $aRow[2]);
		$month = $aMonth[1];

		$aOut['Network'][$network]['loan_count'] += 1;
		$aOut['Network'][$network]['loan_total'] += $aRow[4];

		$aOut['Product'][$product]['loan_count'] += 1;
		$aOut['Product'][$product]['loan_total'] += $aRow[4];

		$aOut['Month'][$month]['loan_count'] += 1;
		$aOut['Month'][$month]['loan_total'] += $aRow[4];

		$total_loan_count += 1;
		$total_loan_total += $aRow[4];

	}
	//print '-=-=-=-=--=-=-=-=--=-=-=-=-=-=-=-=-=-=-=-';
	// print '<pre>';
	// 	print_r($aOut);
	// print '</pre>';

	$cTuple = '[';
	foreach($aOut as $key => $aValue){
		$cTuple .= '{ "'.$key . '" : ';
		foreach($aValue as $cKey => $aDet){
			$cTuple .= '('.$cKey.','.$aDet['loan_count'].', '.$aDet['loan_total'].'),';
		}
		$cTuple = rtrim($cTuple, ',');
		$cTuple .= '},';
	}
	$cTuple = rtrim($cTuple, ',');
	$cTuple .= ']';

	$file = 'Output.txt';
	// Write the contents back to the file
	file_put_contents($file, $cTuple);
	?>
	<textarea><?= $cTuple; ?></textarea>
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

function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle)) {
    	$row = fgetcsv($file_handle, 1024);
    	if($row[0] == 'MSISDN'){
    		continue;
    	}
        $line_of_text[] = $row;
    }
    fclose($file_handle);
    return $line_of_text;
}
