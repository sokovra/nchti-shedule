<?php
$tbl = $_POST['tbl'];

$project_name = $_POST['project_name'];


$styles = "
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
</head>
<style>

*{
    font-family: arial;
}

#tbl_to_pdf{
        border: solid 1px;
        border-collapse: collapse;
        z-index:3;
    }
   #tbl_to_pdf td{
        border: solid 1px;
        height:30px;
        text-align:center;
    }
     #tbl_to_pdf td[major]{
        padding: 0 13px; 
    }

    .writ{
        display:inline;
        max-width:150px;
        text-align:center;
        padding:0px;
        background:white;
        margin:9px;
        margin-bottom:5px;
        z-index:5;
        position:relative;
    }
</style>";


$html = $styles.$tbl;


use Dompdf\Dompdf;
include_once '/dompdf/autoload.inc.php';
$dompdf = new Dompdf();
$dompdf->loadHtml($html,'UTF-8');
//$dompdf->setPaper('A3', 'Landscape');
$dompdf->setPaper('A3', 'portrait');
$dompdf->render();
 
// Вывод файла в браузер:
//$dompdf->stream('schet-10'); 
 
// Или сохранение на сервере:
$pdf = $dompdf->output(); 


$name_pdf = 'pdf/'.$project_name.'.pdf';
file_put_contents($name_pdf, $pdf); 

echo $name_pdf;
?>
