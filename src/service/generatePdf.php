<?php
namespace App\Service;
// reference the Dompdf namespace
use Dompdf\Dompdf;



class Pdf extends AbstractController{
    // instantiate and use the dompdf class

public function generatePdf($html){
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');
    // Render the HTML as PDF
    $dompdf->render();
    // Output the generated PDF to Browser (inline view)
    $dompdf->stream('rapport', [
        "Attachment" => false
    ]);
}
}

?>