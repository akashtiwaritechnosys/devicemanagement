<?php
include_once('include/utils/GeneralConfigUtils.php');
function CalculateContractAndWarranty($entityData) {
	$recordInfo = $entityData->{'data'};
	$id = $recordInfo['id'];
	$id = explode('x', $id);
	$id = $id[1];
	$warrantyStatus = $recordInfo['eq_run_war_st'];
	$cotractStartDate = $recordInfo['cont_start_date'];
	$contractEndDate = $recordInfo['cont_end_date'];

	$beginGurantee = $recordInfo['cust_begin_guar'];
	$lastHMR = $recordInfo['eq_last_hmr'];

	$oldStatus = CalculateWarrantyAsPerWarrantyTerms($recordInfo);
	CalculateContractAsPerWarrantyTerms($recordInfo, $oldStatus);
}

function CalculateWarrantyAsPerWarrantyTerms($recordInfo) {
	$dataValues = $recordInfo['war_in_months'];
	$id = $recordInfo['id'];
	$id = explode('x', $id);
	$id = $id[1];
	$warrentyStartDate = $recordInfo['war_start_date'];

	$warrentyStartDate = date_create($warrentyStartDate);
	if (!empty($dataValues)) {
		$warrentyEndDate  = $warrentyStartDate->modify("+" . $dataValues . ' month');
	}

	// minus 1 day
	$warrentyEndDate = date_format($warrentyEndDate, "Y-m-d");
	$warrentyEndDate = date_create($warrentyEndDate);

	$today = date("Y-m-d");
	$todayDate = date_create($today);
	$interval  = date_diff($warrentyEndDate, $todayDate);
	$daysLeftInWarranty =  $interval->format('%a');

	$warrentyEndDate = $warrentyEndDate->modify('-1 day');
	$warrentyEndDate = date_format($warrentyEndDate, "Y-m-d");
	if ($warrentyEndDate > date("Y-m-d")) {
		$currStatus = "Under Warranty";
		$activeStatus = 'Active';
		ValueUpdateInDB($currStatus, $id, $warrentyEndDate, $daysLeftInWarranty, $activeStatus);
	} else {
		$activeStatus = 'In Active';
		$currStatus = "Outside Warranty";
		ValueUpdateInDB($currStatus, $id, $warrentyEndDate, $daysLeftInWarranty, $activeStatus);
	}
	return $currStatus;
}

function CalculateContractAsPerWarrantyTerms($recordInfo, $oldStatus) {
	$id = $recordInfo['id'];
	$id = explode('x', $id);
	$id = $id[1];
	$warrentyEndDate = $recordInfo['amc_end_date'];
	$warrentyEndDate = date_create($warrentyEndDate);
	$warrentyEndDate = date_format($warrentyEndDate, "Y-m-d");
	
	if ($warrentyEndDate > date("Y-m-d")) {
		$currStatus = "Under Contract";
		$activeStatus = 'Active';
		InsertDatabase($currStatus, $activeStatus, $id);
	} else {
		$activeStatus = 'In Active';
		$currStatus = "Outside Contract";
		if(empty($recordInfo['amc_start_date']) || empty($recordInfo['amc_end_date'])){
			$currStatus = $oldStatus;
		}
		InsertDatabase($currStatus, $activeStatus, $id);
	}
}