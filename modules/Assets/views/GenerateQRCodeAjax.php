<?php
include 'phpqrcode\qrlib.php';
class Assets_GenerateQRCodeAjax_View extends Vtiger_BasicAjax_View {
	function __construct() {
		parent::__construct();
		$this->exposeMethod('GenerateQRCode');
		$this->exposeMethod('QrCodeButton');
	}

	function process(Vtiger_Request $request) {
		$mode = $request->get('mode');
		if(!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
	}
	function QrCodeButton(Vtiger_Request $request) {
		$mode = $request->getMode(); 
		$moduleName = $request->getModule();
		$recordIds = explode(',',$request->get('recordid')); 
		// print_r($recordIds); exit;
		$assetsData = array();
		foreach ($recordIds as $recordId) {
			global $adb; 
			// print_r($recordId); exit;
			$getAssetsQuery = $adb->pquery('SELECT * FROM vtiger_assets WHERE assetsid = ?', array($recordId));
			// print_r($getAssetsQuery); exit;
			while ($row = $adb->fetch_array($getAssetsQuery)) {
				$assetInfo = array(
					'assetsid' => $row['assetsid'],
					'asset_no' => $row['asset_no'],
					'assetname' => $row['assetname']
				);
		
				$assetsData[] = $assetInfo;
			}
		}
		// print_r($assetsData); exit;
		$assetsHtml = '
			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
				<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
				<style>
					table {
						font-family: arial, sans-serif;
						border-collapse: collapse;
						width: 100%;
					}
					td, th {
						border: 1px solid #dddddd;
						text-align: center;
						padding: 8px;
					}
				</style>
			</head>
			<body>
			<div class="container mt-3">       
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Assets Name</th>
							<th>Assets Number</th>
							<th>QR Code</th>
						</tr>
					</thead>
					<tbody>';
	
		foreach ($assetsData as $asset) {
			$qrCodeData = $asset['assetsid'];
				// Start output buffering to capture the QR code image output
				ob_start();
				QRcode::png($qrCodeData, null, QR_ECLEVEL_L, 3);
				$qrCodeImage = ob_get_contents();
				ob_end_clean();
				$qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCodeImage);
				$assetsHtml .= '<tr>
									<td>' . $asset['assetname'] . '</td>
									<td>' . $asset['asset_no'] . '</td>
									<td><img src="' . $qrCodeBase64 . '" alt="QR Code"/></td>
								</tr>';
		}
		$assetsHtml .= '
					</tbody>
				</table>
			</div>
			</body>
			</html>';
		// echo $assetsHtml; // Output the HTML content
		ob_start();
		require_once "libraries\mpdf\mpdf\mpdf.php"; 
		$mpdf = new mPDF('c', 'A4', '', '', 15, 15, 15, 15, 15, 15);  
		//write html to PDF
		$mpdf->WriteHTML($assetsHtml);
		$dateTime = new DateTime();
		$filename = 'Assets_' . $dateTime->format('Y-m-d_H:i:s') . '.pdf';
		$mpdf->Output($filename, 'D');
	}
	
}

?>