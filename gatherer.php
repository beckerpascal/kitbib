<?php
#array with names of all bibs
	$bib_array = array('LSG','LST','LSW','LSN','LBS','FBP','FBI','FBA','BIB-N','FBH','TheaBib', 'FBW', 'FBC', 'FBM');
	$data_array = array();

	include('connect.php');

#connect to db
	$link = mysqli_connect($server, $user, $pw, $db);
	if (!$link) {
	    die('Verbindung schlug fehl: ' . mysqli_error());
	}
	echo 'Erfolgreich verbunden<br><br>';


#load data from bib
	$site = "http://services.bibliothek.kit.edu/leitsystem/getdata.php?callback=jQuery110205255369034130126_1400262483616&location%5B0%5D=LSG%2CLST%2CLSW%2CLSN%2CLBS%2CFBC%2CFBW%2CFBP%2CFBI%2CFBM%2CFBA%2CBIB-N%2CFBH%2CTheaBib&values%5B0%5D=seatestimate%2Cmanualcount&after%5B0%5D=-10800seconds&before%5B0%5D=now&limit%5B0%5D=-17&location%5B1%5D=LSG%2CLST%2CLSW%2CLSN&values%5B1%5D=temperature&after%5B1%5D=&before%5B1%5D=now&limit%5B1%5D=1&location%5B2%5D=LSG%2CLST%2CLSW%2CLSN%2CLBS%2CFBC%2CFBW%2CFBP%2CFBI%2CFBM%2CFBA%2CBIB-N%2CFBH%2CTheaBib&values%5B2%5D=location&after%5B2%5D=&before%5B2%5D=now&limit%5B2%5D=1&refresh=&_=1400262483622";
	$site_data = get_url_contents($site);

	for ($i = 0; $i < sizeof($bib_array); $i++) { 
		$bib = explode('"location_name":"'.$bib_array[$i], $site_data);
		if(sizeof($bib) > 1){
			$data_array[$i] = trim_seats(explode('occupied_seats":', $bib[1]));		
		}else{
			$data_array[$i] = 0;
		}
	}
	$bib_array[8] = 'BIBN';

	$query = "INSERT INTO kitbib_v2 (time, ".join($bib_array, ', ').") VALUES (NOW(), '".join($data_array, '\', \'')."')";
	echo $query;
	if (!mysqli_query($link,$query)) {
			die('Error: ' . mysqli_error($link));
	}	
	
#close connection to db
	mysqli_close($link);
	

	function trim_seats($seats){
		$seats = substr($seats[1], 0, 3);
		$seats = str_replace(',', '', $seats);
		$seats = str_replace('"', '', $seats);
		$seats = str_replace('}', '', $seats);
		return $seats;
	}


	function get_url_contents($url){
        $crl = curl_init();
        $timeout = 5;
        curl_setopt ($crl, CURLOPT_URL,$url);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $ret = curl_exec($crl);
        curl_close($crl);
        return $ret;
	}
?>