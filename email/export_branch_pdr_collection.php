<?php
// Your PHP code here
require '../vendor/autoload.php';
require_once "../controllers/pdrcollection.controller.php";
require_once "../models/pdrcollection.model.php";
require_once "../views/modules/session.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$branch_name = $_SESSION['branch_name'];

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

$spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Calibri')
    ->setSize(11);

    // Heading 
$activeWorksheet->setCellValue('A5', 'ID #');
$activeWorksheet->setCellValue('B5', 'SSP / GSP');
$activeWorksheet->setCellValue('C5', 'STATUS');
$activeWorksheet->setCellValue('D5', 'DATE ENDORSED');
$activeWorksheet->setCellValue('E5', 'DATE OF PAYMENT');
$activeWorksheet->setCellValue('F5', 'REF.');
$activeWorksheet->setCellValue('G5', 'PREVIOUS BALANCE');
$activeWorksheet->setCellValue('H5', 'AMOUNT PAID');
$activeWorksheet->setCellValue('I5', 'ENDING BALANCE');


$spreadsheet->getActiveSheet()->getStyle('A5:I5')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A5:I5')->getFont()->setSize(11);
// Set horizontal alignment to center for range 'A5:R5'
$spreadsheet->getActiveSheet()->getStyle('A5:I5')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    ->setVertical(Alignment::VERTICAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('A:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Setting Column Width 
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(22);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(22);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(23);


$spreadsheet->getActiveSheet()->getStyle('A5')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('J')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('K')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('M')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('R')->getAlignment()->setWrapText(true);

if ($from_date == $to_date) {
    $spreadsheet->getActiveSheet()->setCellValue('A2', 'DAILY PASTDUE SUMMARY (CREDIT PDR)');
    $spreadsheet->getActiveSheet()->setCellValue('A3', 'DATE COVERED: ' . date("M d, Y", strtotime($from_date)));
} else {
    $spreadsheet->getActiveSheet()->setCellValue('A2', 'WEEKLY PASTDUE SUMMARY (CREDIT PDR)');
    $spreadsheet->getActiveSheet()->setCellValue('A3', 'DATE COVERED: ' . date("M d, Y", strtotime($from_date)) .' - '. date("M d, Y", strtotime($to_date))); 
}

// $spreadsheet->getActiveSheet()->setCellValue('L4', 'ENCODE LOT DATE');

$spreadsheet->getActiveSheet()->getStyle('A2:A4')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
// $spreadsheet->getActiveSheet()->setCellValue('O3', "FILL UP THE  RATES (REFER TO INSURANCE TABLE) ACCDG TO SSP's ACTUAL AGE ");



$spreadsheet->getActiveSheet()->mergeCells("A2:C2");
$spreadsheet->getActiveSheet()->mergeCells("A3:C3");
// $spreadsheet->getActiveSheet()->mergeCells("O3:Q4");

$spreadsheet->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('A3:B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
// $spreadsheet->getActiveSheet()->getStyle("O3:Q4")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('O3')->getAlignment()->setWrapText(true);
// $spreadsheet->getActiveSheet()->getStyle('O3')->getFont()->setBold(true);
$borderStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$fillStyle = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '9BC2E6', // Blue color
        ],
    ],
];

for ($row = 5; $row <= 5; $row++) {
    $spreadsheet->getActiveSheet()->getStyle("A$row:I$row")->applyFromArray($borderStyle);
    $spreadsheet->getActiveSheet()->getStyle("A$row:I$row")->applyFromArray($fillStyle);
}

$style = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'FFFF00', // Yellow color
        ],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

// $spreadsheet->getActiveSheet()->getStyle('L4')->applyFromArray($style);
// $spreadsheet->getActiveSheet()->getStyle('O5:Q5')->applyFromArray($style);
// $spreadsheet->getActiveSheet()->getStyle('O3:Q4')->applyFromArray($style);

// $style1 = [
//     'font' => [
//         'color' => ['rgb' => 'FF0000'], // RGB color code for red
//     ],
// ];

// // Apply the style to the range 'O3:Q4'
// $spreadsheet->getActiveSheet()->getStyle('O3:Q4')->applyFromArray($style1);

$update_p_status = (new ControllerPDRColl)->ctrUpdatePrintStatus($branch_name, $from_date, $to_date);

// Content 
$report = "YES";
$pdr = (new ControllerPDRColl)->ctrShowAllFilterArchivePDRList($branch_name, $from_date, $to_date, $report);
if(!empty($pdr)){
$row = 6;
$id = 1;
foreach($pdr as $pdrcoll){
    $account_no = $pdrcoll["account_no"];
    $name = $pdrcoll["last_name"].', '.$pdrcoll["first_name"].' '.$pdrcoll["middle_name"];
    $status = $pdrcoll["status"];
    $edate = $pdrcoll["edate"];
    $tdate = date("m.d.y", strtotime($pdrcoll["tdate"]));
    $ref = $pdrcoll["ref"];
    $prev_bal = $pdrcoll["prev_bal"]; // Convert string to float
    $amt_paid = $pdrcoll["credit"];
    $end_bal = $pdrcoll["end_bal"]; // Convert string to float
   
    $spreadsheet->getActiveSheet()
    ->setCellValue('A'.$row, $account_no)
    ->setCellValue('B'.$row, $name)
    ->setCellValue('C'.$row, $status)
    ->setCellValue('D'.$row, $edate)
    ->setCellValue('E'.$row, $tdate)
    ->setCellValue('F'.$row, $ref)
    ->setCellValue('G'.$row, $prev_bal)
    ->setCellValue('H'.$row, $amt_paid)
    ->setCellValue('I'.$row, $end_bal);
  
    $spreadsheet->getActiveSheet()->getStyle("A$row:I$row")->applyFromArray($borderStyle);

    $row ++;
    $id ++;
  
}

   // Add headers for the total row, if necessary
    $spreadsheet->getActiveSheet()->setCellValue('G' . $row + 1, 'Total Amount Paid');

    // Calculate and set the total for each relevant column
    // Sum for previous balance
    // $spreadsheet->getActiveSheet()->setCellValue(
    //     'G' . $row,
    //     '=SUM(G6:G' . ($row - 1) . ')'
    // );

    // Sum for amount paid
    $spreadsheet->getActiveSheet()->setCellValue(
        'H' . $row + 1,
        '=SUM(H6:H' . ($row - 1) . ')'
    );

    // Sum for ending balance
    // $spreadsheet->getActiveSheet()->setCellValue(
    //     'I' . $row,
    //     '=SUM(I6:I' . ($row - 1) . ')'
    // );

    // Add headers for the total row, if necessary
    $spreadsheet->getActiveSheet()->setCellValue('A' . $row + 1, 'Total PDR Collection');

     // Count for ending balance
     $spreadsheet->getActiveSheet()->setCellValue(
        'C' . $row + 1,
        ($row - 6)
    );

    $addrow = $row + 1;

    $spreadsheet->getActiveSheet()->mergeCells("A{$addrow}:B{$addrow}");


    // Style the totals row if needed
    $spreadsheet->getActiveSheet()->getStyle("G$addrow:H$addrow")->getFont()->setBold(true);
    $spreadsheet->getActiveSheet()->getStyle("G$addrow:H$addrow")->applyFromArray($borderStyle);
    $spreadsheet->getActiveSheet()->getStyle("G$addrow:H$addrow")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFFFD700'); // Example: Gold color for totals row background

           // Style the totals row if needed
    $spreadsheet->getActiveSheet()->getStyle("A$addrow:C$addrow")->getFont()->setBold(true);
    $spreadsheet->getActiveSheet()->getStyle("A$addrow:C$addrow")->applyFromArray($borderStyle);
    $spreadsheet->getActiveSheet()->getStyle("A$addrow:C$addrow")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFFFD700'); // Example: Gold color for totals row background

    // Adjust row count if you're adding anything else after this
    $row++;


    // $spreadsheet->getActiveSheet()->setCellValue('A3', 'DATE:');
    // $spreadsheet->getActiveSheet()->setCellValue('B3', $tdate);
}

$fileName = $branch_name . " PDR COLLECTION " . $tdate;
// Set the HTTP headers to make the file downloadable
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$fileName.'.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);

// Output the file directly to the browser
$writer->save('php://output');
