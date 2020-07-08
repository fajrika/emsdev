<?php 
require_once 'vendor/MPDF/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf(['mode'=>'utf-8', 'format'=>'A4']);
// $mpdf = new \Mpdf\Mpdf(['mode'=>'utf-8', 'format'=>'A4', 'orientation' => 'L']);
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kirim Konfirmasi Tagihan</title>
    <style type="text/css">
        body {
            font-size: 13.5px;
        }
        table {
            width: 100%;
        }
        .laporan th,
        .laporan td {
            border: 1px solid #444;
        }
        .laporan tbody td {
            padding: 4px;
        }
    </style>
</head>
<body>

</body>
</html>

<?php
// $nama_file = "Konfirmasi_tagihan";
// $html = ob_get_contents(); //Proses untuk mengambil data
// ob_end_clean();
// //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
// $mpdf->WriteHTML(utf8_encode($html));
// // LOAD a stylesheet
// // $stylesheet = file_get_contents('mpdfstyletables.css');
// // $mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
// $mpdf->WriteHTML($html,1);
// $mpdf->Output($nama_file."-".date("Y/m/d His").".pdf" ,'I');
?>