<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


//require_once __DIR__ . '/vendor/autoload.php';
require_once '/var/www/.composer/vendor/autoload.php';
// Abrir o nosso ficheiro e ver o que a Auferma tem em stock
$spreadsheetInterno = IOFactory::load("aufermaInterno.xlsx");
$spreadsheetAuferma = IOFactory::load("aufermaStock.xlsx");
$intSheet= $spreadsheetInterno->getActiveSheet();
$aSheet=$spreadsheetAuferma->getActiveSheet();
foreach ($intSheet->getRowIterator() as $iRow) {
    if ($iRow->getRowIndex() == 1) {
        continue;
    }
    $codProduto = $intSheet->getCell('A'.$iRow->getRowIndex())->getValue();
    $intSheet->setCellValue('L'.$iRow->getRowIndex(),'não');
    foreach ($aSheet->getRowIterator() as $aRow ){
        if ($aRow->getRowIndex() == 1) {
            continue;
        }
        $codProdAuf = $aSheet->getCell('A'.$aRow->getRowIndex())->getCalculatedValue();
        if(strcmp($codProduto,$codProdAuf) == 0){
            print_r($codProduto."<->".$codProdAuf."->".$aRow->getRowIndex()."SIM\n");
            $intSheet->setCellValue('L'.$iRow->getRowIndex(),'sim');
            break;
        }elseif ($aRow->getRowIndex() == $aSheet->getHighestRow()){
            print_r("Sem Codigo->".$codProdAuf."\n");
        }
    }
}
$writer = new Xlsx($spreadsheetInterno);
$writer->save('aufermaInterno.xlsx');