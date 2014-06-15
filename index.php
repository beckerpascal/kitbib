<?php include('loadData.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">          
<head>

	<meta name="Pascal Becker" content=" Plätze in den Bibs" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Platzbelegung in den Bibliotheken des KIT</title>

		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="http://code.highcharts.com/stock/highstock.js"></script>
		<?php include('graph.js'); ?>

	</head>

	<body>
		<select>
			<option value="occupied"<?php if($allocation=='occupied') echo ' selected'; ?>>Belegte Plätze</option>
			<option value="occupiedP"<?php if($allocation=='occupied' && $type=='percent') echo ' selected'; ?>>Belegte Plätze [%]</option>
			<option value="free"<?php if($allocation=='free') echo ' selected'; ?>>Freie Plätze</option>
			<option value="freeP"<?php if($allocation=='free' && $type=='percent') echo ' selected'; ?>>Freie Plätze [%]</option>
		</select>
		<div id="container"></div>
		<div id="categories">
			<button id="onlyBib">nur KIT-Bibliothek</button>
			<button id="onlyFak">nur Fakultätsbibliotheken</button>
			<button id="others">andere Bibliotheken</button>
			<button id="none">alle ausblenden</button>
			<button id="all">alle einblenden</button>
		</div>
		<div id="timetable">
			<table cellspacing="0">
				<?php include('loadTable.php'); ?>
			</table>
		</div>
		<div id="disclaimer">Daten von <a target="_blank" href="http://www.bibliothek.kit.edu/cms/freie-lernplaetze.php">der offiziellen KIT-Seite</a> gesammelt.<br/>By P. Becker</div>
	</body>
</html>