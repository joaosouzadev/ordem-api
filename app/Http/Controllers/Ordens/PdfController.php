<?php

namespace App\Http\Controllers\Ordens;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function pdfOrdem($id) {
    	// verificar se $ordem->user == auth->user
    	$pdf = storage_path() . '/uploads/pdfs/ordem_' . $id . '.pdf';

    	$headers = [
    	    'Content-Type' => 'application/pdf',
    	];

        return response()->download($pdf, 'aaa.pdf', $headers);
    }
}
