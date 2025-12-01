<?php
// Your PHP code here
require '../vendor/autoload.php';
require_once "../controllers/insurance.controller.php";
require_once "../models/insurance.model.php";
require_once "../views/modules/session.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$date = $_GET['date'];
$branch = $_GET['branch'];
$branch_name = $_SESSION['branch_name'];
$type = $_SESSION['type'];

if($type == "admin"){
    $exName = $branch;
}else{
    $exName = $branch_name;
}
$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

$spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Calibri')
    ->setSize(11);

    // Heading 
$activeWorksheet->setCellValue('A3', '');
$activeWorksheet->setCellValue('B3', 'ID #');
$activeWorksheet->setCellValue('C3', 'DCHS #');
$activeWorksheet->setCellValue('D3', 'NAME');
$activeWorksheet->setCellValue('E3', 'AGE');
$activeWorksheet->setCellValue('F3', 'AMOUNT OF LOAN');
$activeWorksheet->setCellValue('G3', 'TERM (# OF DAYS)');
$activeWorksheet->setCellValue('H3', 'RELEASE DATE');
$activeWorksheet->setCellValue('I3', 'EXPIRY DATE');
$activeWorksheet->setCellValue('J3', 'PREM. PAID');
$activeWorksheet->setCellValue('K3', 'BRANCH');
$spreadsheet->getActiveSheet()->getStyle('A3:S3')->getFont()->setSize(11);
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
// Set horizontal alignment to center for range 'A5:R5'
$spreadsheet->getActiveSheet()->getStyle('A3:S3')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    ->setVertical(Alignment::VERTICAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('A:S')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Setting Column Width 
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(7);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(16);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(24);
$spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('J')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('K')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('M')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('R')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('G')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->setCellValue('A1', 'BRANCH MASTERLIST OF PENSIONERS WHO AVAILED CBINS');
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->mergeCells("A1:F1");
$spreadsheet->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);


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
            'rgb' => '00B0F0', // Blue color
        ],
    ],
];

for ($row = 3; $row <= 3; $row++) {
    $spreadsheet->getActiveSheet()->getStyle("A$row:K$row")->applyFromArray($borderStyle);
    $spreadsheet->getActiveSheet()->getStyle("A$row:K$row")->applyFromArray($fillStyle);
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


// $style1 = [
//     'font' => [
//         'color' => ['rgb' => 'FF0000'], // RGB color code for red
//     ],
// ];




// Content 
if($branch == "ALL" || $branch == ""){
    $ins = (new ControllerInsurance)->ctrShowFilterCBIInsurance($date);
}else{
    $ins = (new ControllerInsurance)->ctrShowFilterCBIInsuranceByBranch($date, $branch);
}
$total_amount=0;
function dayConverter($avail_date1, $expire_date1){
    // Convert dates from YYYYMMDD to m/d/Y format
    $avail_date1 = DateTime::createFromFormat('Y-m-d', $avail_date1)->format('m/d/Y');
    $expire_date1 = DateTime::createFromFormat('Y-m-d', $expire_date1)->format('m/d/Y');
    // Create DateTime objects
    $avail_date_obj = DateTime::createFromFormat('m/d/Y', $avail_date1);
    $expiry_date_obj = DateTime::createFromFormat('m/d/Y', $expire_date1);
    // Check if date objects were created successfully
    if (!$avail_date_obj || !$expiry_date_obj) {
        // Output JavaScript to log to the browser console
        echo "<script>console.error('Invalid date format. Avail date: $avail_date1, Expiry date: $expire_date1');</script>";
        return null; // Return null if date conversion fails
    }
    // Calculate the difference
    $interval = $avail_date_obj->diff($expiry_date_obj);
    $days = $interval->days;

    return $days;

}


if(!empty($ins)){
$row = 4;
$id = 1;

foreach($ins as $insurance){
    $account_id = $insurance['account_id'];
    $name = $insurance['name'];
    $age = $insurance['age'];
    $amount_loan = $insurance['amount_loan'];
    $terms = $insurance['terms'];
    $avail_date = $insurance['avail_date'];
    $expire_date = $insurance['expire_date'];
    $amount = $insurance['amount'];
    $branch_name = $insurance['branch_name'];
    $dchs = $insurance['dchs'];
    $avail_dateForamtted = date("m/d/y", strtotime($avail_date));
    $expire_dateForamtted = date("m/d/y", strtotime($expire_date));

    $days = dayConverter($avail_date, $expire_date);
  
    $spreadsheet->getActiveSheet()
    ->setCellValue('A'.$row, $id)
    ->setCellValue('B'.$row, $account_id)
    ->setCellValue('c'.$row, $dchs)
    ->setCellValue('D'.$row, $name)
    ->setCellValue('E'.$row, $age)
    ->setCellValue('F'.$row, $amount_loan)
    ->setCellValue('G'.$row, $days)
    ->setCellValue('H'.$row, $avail_dateForamtted)
    ->setCellValue('I'.$row, $expire_dateForamtted)
    ->setCellValue('J'.$row, $amount)
    ->setCellValue('K'.$row, $branch_name);
    $spreadsheet->getActiveSheet()->getStyle("A$row:K$row")->applyFromArray($borderStyle);
    $spreadsheet->getActiveSheet()->getCell("F$row")->getStyle()->getNumberFormat()->setFormatCode('#,##0.00_-;-#,##0.00_-;_- "-"_-;_-@_-');
    $spreadsheet->getActiveSheet()->getCell("J$row")->getStyle()->getNumberFormat()->setFormatCode('#,##0.00_-;-#,##0.00_-;_- "-"_-;_-@_-');

    $row++;
    $id++;
    $total_amount = $total_amount + floatval($insurance['amount']);

}

$spreadsheet->getActiveSheet()->setCellValue("J$row",  $total_amount);
$spreadsheet->getActiveSheet()->setCellValue("H$row",  "TOTAL");

$spreadsheet->getActiveSheet()->getCell("J$row")->getStyle()->getNumberFormat()->setFormatCode('#,##0.00_-;-#,##0.00_-;_- "-"_-;_-@_-');
$spreadsheet->getActiveSheet()->getStyle("J$row")->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle("H$row")->getFont()->setBold(true);





}


$fileName = "CBI INSURANCE SUMMARY " . $date;

// Set the HTTP headers to make the file downloadable
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$fileName.'.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);

// Output the file directly to the browser
$writer->save('php://output');
