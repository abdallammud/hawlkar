<?php 
// require("./assets/fpdf186/fpdf.php");
// require("./assets/fpdf186/barcode/FpdfBarcode.php");
require("./assets/fpdf186/phpqrcode/qrlib.php");
require('./assets/fpdf186/code128.php');

if(isset($_GET['print'])) {
	if($_GET['print'] == 'barcode') {
		require('barcode.php');
	} else if($_GET['print'] == 'qrcode') {
		require('qrcode.php');
	}
} else {header("Location: /");}

?>