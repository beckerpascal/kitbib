<?php
$bib_array = array('LSG','LST','LSW','LSN','LBS','FBP','FBI','FBA','BIBN','FBH','TheaBib', 'FBW', 'FBC', 'FBM');
$max_array = array(164,192,176,186,72,86,59,15,37,250,150,90,147,40);

include('connect.php');

$connection = mysql_connect($localhost, $user, $pw);
if (!$connection) {
    die('Could not connect: ' . mysql_error());
} else {
    $dbcheck = mysql_select_db($db);
    if (!$dbcheck) {
        echo mysql_error();
    }
}

	$allocation = $_GET['alloc'];
	$type = $_GET['type'];
	$points = $_GET['points'];

	if($points == ''){
		$points = 200;
	}elseif ($points == 0) {
		$points = 1;
	}
	
	switch ($allocation) {
		case '':
			$allocation = 'occupied';
			break;
		case 'free':
			break;
		case 'occupied':
			break;
		default:
			$allocation = 'occupied';
			break;
	}

	$sql = 'SELECT time, '.join($bib_array, ', ').' FROM kitbib_v2 ORDER BY time';
    $result = mysql_query($sql);
	if (!$result) {
	    $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
	    $message .= 'Gesamte Abfrage: ' . $query;
	    die($message);
	}


	while ($row = mysql_fetch_row($result)) {

		$time[] = $row[0];
		$timeString[] = (strtotime($row[0]) + 2*60*60) *1000; // convert from Unix timestamp to JavaScript time
		$dataLSG[] = $row[1];
		$dataLST[] = $row[2];
		$dataLSW[] = $row[3];
		$dataLSN[] = $row[4];
		$dataLBS[] = $row[5];
		$dataFBP[] = $row[6];
		$dataFBI[] = $row[7];
		$dataFBA[] = $row[8];
		$dataBIBN[] = $row[9];
		$dataFBH[] = $row[10];
		$dataTheaBib[] = $row[11];
		$dataFBW[] = $row[12];
		$dataFBC[] = $row[13];
		$dataFBM[] = $row[14];

	}

	$dataLSGstring = generateDataString($timeString, $dataLSG, $points);
	$dataLSTstring = generateDataString($timeString, $dataLST, $points);
	$dataLSWstring = generateDataString($timeString, $dataLSW, $points);
	$dataLSNstring = generateDataString($timeString, $dataLSN, $points);
	$dataLBSstring = generateDataString($timeString, $dataLBS, $points);
	$dataFBPstring = generateDataString($timeString, $dataFBP, $points);
	$dataFBIstring = generateDataString($timeString, $dataFBI, $points);
	$dataFBAstring = generateDataString($timeString, $dataFBA, $points);
	$dataBIBNtring = generateDataString($timeString, $dataBIBN, $points);
	$dataFBHstring = generateDataString($timeString, $dataFBH, $points);
	$dataTheaBibstring = generateDataString($timeString, $dataTheaBib, $points);
	$dataFBWstring = generateDataString($timeString, $dataLSW, $points);
	$dataFBCstring = generateDataString($timeString, $dataFBC, $points);
	$dataFBMstring = generateDataString($timeString, $dataFBM, $points);

	mysql_close($connection);

	if($allocation == 'free'){
		$allocText = 'frei';
	}else{
		$allocText = 'belegt';
	}

	function getValue($max, $value){
		if($_GET['type'] == 'percent'){
			return round(($value/$max),2)*100;
		}elseif($_GET['alloc'] == 'free'){
			return $max - $value;
		}else{
			return $value;
		}
	}

	function generateDataString($timeString, $dataArray, $points){
		$string = '';
		$amountOfPoints = round(sizeof($dataArray)/$points) - 1;
		for ($i=0; $i < sizeof($dataArray); $i = $i + $amountOfPoints) { 
			$string .= '['.$timeString[$i].','.$dataArray[$i].']';
			if($i< sizeof($dataArray)-1){
				$string .= ',';
			}
		}
		return $string;
	}
?>