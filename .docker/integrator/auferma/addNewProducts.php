<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require_once __DIR__ . '/vendor/autoload.php';
//require_once '/var/www/.composer/vendor/autoload.php';
// Abrir o nosso ficheiro e ver o que a Auferma tem em stock
$spreadsheetInterno = IOFactory::load("aufermaInterno.xlsx");
$spreadsheetAuferma = IOFactory::load("aufermaStock.xlsx");
$intSheet= $spreadsheetInterno->getActiveSheet();
$aSheet=$spreadsheetAuferma->getActiveSheet();
print_r("Interno: ".$intSheet->getHighestRow()."\n");
print_r("Stocks: ".$aSheet->getHighestRow()."\n");
foreach ($aSheet->getRowIterator() as $aRow) {
    if ($aRow->getRowIndex() == 1) {
        continue;
    }
    $codProdAuf = $aSheet->getCell('A'.$aRow->getRowIndex())->getValue();
    foreach ($intSheet->getRowIterator() as $iRow ){
        if ($iRow->getRowIndex() == 1) {
            continue;
        }
        $codProd = $intSheet->getCell('A'.$iRow->getRowIndex())->getValue();
        if(strcmp($codProd,$codProdAuf) == 0){
            break;
        //Se for a ultima linha e não encontrou adiciona o artigo!
        }elseif ($iRow->getRowIndex() == $intSheet->getHighestRow()){
            print_r("new  Product: ".$codProdAuf."\n");
            $intSheet->insertNewRowBefore($intSheet->getHighestRow()+1,1);
            $intSheet->setCellValue('A'.$intSheet->getHighestRow(),$codProdAuf);
            $intSheet->setCellValue('B'.$intSheet->getHighestRow(),$aSheet->getCell('B'.$aRow->getRowIndex())->getValue());
            $intSheet->setCellValue('C'.$intSheet->getHighestRow(),$aSheet->getCell('C'.$aRow->getRowIndex())->getValue());
            $intSheet->setCellValue('D'.$intSheet->getHighestRow(),$aSheet->getCell('D'.$aRow->getRowIndex())->getValue());
            $intSheet->setCellValue('E'.$intSheet->getHighestRow(),$aSheet->getCell('E'.$aRow->getRowIndex())->getValue());
            $intSheet->setCellValue('F'.$intSheet->getHighestRow(),$aSheet->getCell('F'.$aRow->getRowIndex())->getValue());
            $intSheet->setCellValue('G'.$intSheet->getHighestRow(),$aSheet->getCell('G'.$aRow->getRowIndex())->getValue());
            $intSheet->setCellValue('H'.$intSheet->getHighestRow(),$aSheet->getCell('H'.$aRow->getRowIndex())->getValue());
            $intSheet->setCellValue('L'.$intSheet->getHighestRow(),'sim');
        }
    }
}
$writer = new Xlsx($spreadsheetInterno);
$writer->save('aufermaInterno.xlsx');