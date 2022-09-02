<?php

namespace App\Controllers;
require FCPATH . 'vendor/autoload.php';

use CodeIgniter\Controller;
use phpoffice\phpspreadsheet\Spreadsheet;
use phpoffice\phpspreadsheet\Writer\Xlsx;

class Excel extends Controller
{
    public function index()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');
    }
}
