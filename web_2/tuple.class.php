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

class Detail {
  var $cType;

  function __construct($cType) {
    $this->cType 	= $cType;
    $this->{$this->cType} = array();
  }

  function addDetail($product, $type, $value) {
    $this->{$this->cType}[$product][$type] += $value;
  }
}

Class Tuple {
	public $oDetails;

	function __construct() {
		$this->oDetails = array();
	}

	public function addDetail($oDetail){
		$this->oDetails[] = $oDetail;
	}
}

Class CalculateDetails {

	public function getCalculatedTuple($aFile){
		$oNetworkDetail = new Detail('By Network');
		$oProductDetail = new Detail('By Product');
		$oMonthDetail = new Detail('By Month');
		foreach($aFile as $nRow => $aDetails){
			$cNetwork = $aDetails[1]; 
			$cProduct = $aDetails[3];
			
			$aMonth = explode("-", $aDetails[2]);
			$cMonth = $aMonth[1];

			$oNetworkDetail->addDetail($cNetwork, 'loan_count', 1);
			$oNetworkDetail->addDetail($cNetwork, 'loan_ammount', $aDetails[4]);

			$oProductDetail->addDetail($cProduct, 'loan_count', 1);
			$oProductDetail->addDetail($cProduct, 'loan_ammount', $aDetails[4]);

			$oMonthDetail->addDetail($cMonth, 'loan_count', 1);
			$oMonthDetail->addDetail($cMonth, 'loan_ammount', $aDetails[4]);

		}
		$oTuple = new Tuple();
		$oTuple->addDetail($oNetworkDetail);
		$oTuple->addDetail($oProductDetail);
		$oTuple->addDetail($oMonthDetail);

		return $oTuple;
	} 
}

Class CSV {

  public function processCsv($file_name){
    //echo 'in processCsv function!';
	return $this->readCSV($file_name);
  }

  public function readCSV($csvFile){
    //echo 'in readCSV function!';
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

}

?>