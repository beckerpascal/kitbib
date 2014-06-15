<?php
	$bib_array = array('LS Geisteswissens.','LS Technik','LS Naturwissens.','LS WiWi & Info.','Lehrbuchsammlung','Fak.Bib. Physik','Fak.Bib. Informatik','Fak.Bib. Architektur', 'Fak.Bib. WiWi', 'Fak.Bib. Chemie', 'Fak.Bib. Mathematik','KIT-Nord','Fachbibliothek FH','TheaBib');
	$max_array = array(164,192,176,186,72,86,59,15,90,147,40,37,250,150);

	echo '<tr><th>Bib</th>';
	for($i = 0; $i < 24; $i++){
		echo '<th>'.$i.':00 - '.($i+1).':00</th>';
	}
	echo '</tr>';

	$data = array($dataLSG, $dataLST, $dataLSW, $dataLSN, $dataLBS, $dataFBP, $dataFBI, $dataFBA, $dataFBW, $dataFBC, $dataFBM, $dataBIBN, $dataFBH, $dataTheaBib);
	for($i = 0; $i < sizeof($data); $i++){

		$hour_array = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		$hour_counter = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		for($j = 0; $j < sizeof($data[$i]); $j++){
			$hour = (date('H', strtotime($time[$j]))+22)%24;
			$hour_array[$hour] += ($data[$i][$j]/$max_array[$i]);
			$hour_counter[$hour]++;
			//echo $hour_array[$hour].' '.$hour_counter[$hour].' '.($hour_array[$hour]/$hour_counter[$hour]).'<br>';
		}

		echo '<tr id="'.$i.'"><td>'.$bib_array[$i].'</td>';

		for($j = 0; $j < sizeof($hour_array); $j++){
			$percent = round($hour_array[$j]/$hour_counter[$j], 3)*100;
			if($percent == 0){
				$color = 'sub0';
			}elseif($percent < 20){
				$color = 'sub20';
			}elseif($percent >= 20 && $percent < 40){
				$color = 'sub40';
			}elseif($percent >= 40 && $percent < 60){
				$color = 'sub60';
			}elseif($percent >= 60 && $percent < 80){
				$color = 'sub80';
			}else{
				$color = 'sub100';
			}
			echo '<td class="'.$color.'"">'.$percent.'</td>';
		}	
		echo '</tr>';
	}
	
?>