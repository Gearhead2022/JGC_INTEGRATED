<?php


function getSuffix($name) {
    // Remove leading and trailing spaces from the name
    $name1 = trim($name);
    // Initialize the suffix variable
    $suffix = null;
    // Split the name into parts based on spaces
    $name_parts = preg_split('/[\s,]+/', $name1);
    // Check each part from the end to see if it matches "JR." or "SR."
    foreach (array_reverse($name_parts) as $part) {
        if (strcasecmp($part, 'JR.') === 0) {
            $suffix = 'JR';
            break;
        } elseif (strcasecmp($part, 'SR.') === 0) {
            $suffix = 'SR';
            break;
        }
    }
    // Return the suffix
    return $suffix;
}


function removeSuffix($name) {
    // Define an array of suffixes to remove
    $suffixes = array('JR.', 'SR.');

    // Remove leading and trailing spaces from the name
    $name = trim($name);

    // Loop through each suffix and remove it from the name
    foreach ($suffixes as $suffix) {
        // Check if the name ends with the current suffix
        if (stripos($name, $suffix) === strlen($name) - strlen($suffix)) {
            // Remove the suffix from the name
            $name = trim(str_ireplace($suffix, '', $name));
            break; // Exit the loop once the suffix is removed
        }
    }

    // Return the modified name
    return $name;
}
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
 $activeWorksheet->setCellValue('A5', '#');
 $activeWorksheet->setCellValue('B5', 'ID #');
 $activeWorksheet->setCellValue('C5', 'LAST NAME');
 $activeWorksheet->setCellValue('D5', 'FIRST NAME');
 $activeWorksheet->setCellValue('E5', 'MIDDLE INITIAL');
 $activeWorksheet->setCellValue('F5', 'SUFFIX');
 $activeWorksheet->setCellValue('G5', 'DATE OF BIRTH');
 $activeWorksheet->setCellValue('H5', 'Age');
 $activeWorksheet->setCellValue('I5', 'GENDER');
 $activeWorksheet->setCellValue('J5', 'CIVIL STATUS');
 $activeWorksheet->setCellValue('K5', 'LOAN RELEASE DATE');
 $activeWorksheet->setCellValue('L5', 'END DATE OF LOAN');
 $activeWorksheet->setCellValue('M5', 'TERM OF LOAN');
 $activeWorksheet->setCellValue('N5', 'LOAN AMOUNT');
 $activeWorksheet->setCellValue('O5', 'PREMIUM');
 $activeWorksheet->setCellValue('P5', 'RATE');
 $activeWorksheet->setCellValue('Q5', 'BRANCH'); 

$spreadsheet->getActiveSheet()->getStyle('A5:Q5')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A5:Q5')->getFont()->setSize(9);
// Set horizontal alignment to center for range 'A5:R5'
$spreadsheet->getActiveSheet()->getStyle('A5:Q5')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
    ->setVertical(Alignment::VERTICAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('A:Q')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Setting Column Width 
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(7);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(8);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(9);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(6);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(6);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(9);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(12);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(12);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20);

$spreadsheet->getActiveSheet()->getStyle('A5')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('J')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('K')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('M')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('R')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('I')->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('L')->getAlignment()->setWrapText(true);

$spreadsheet->getActiveSheet()->setCellValue('A1', 'Daily Summary of Insurance Availment (PHILINSURE)');
$spreadsheet->getActiveSheet()->setCellValue('A2', 'Branch: '.$exName.'');
$spreadsheet->getActiveSheet()->setCellValue('A3', 'Date: '.$date.'');

$spreadsheet->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);

$spreadsheet->getActiveSheet()->mergeCells("A1:D1");
$spreadsheet->getActiveSheet()->mergeCells("A2:C2");

$spreadsheet->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('A3:B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

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

for ($row = 5; $row <= 5; $row++) {
    $spreadsheet->getActiveSheet()->getStyle("A$row:Q$row")->applyFromArray($borderStyle);
    // $spreadsheet->getActiveSheet()->getStyle("A$row:O$row")->applyFromArray($fillStyle);
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




// Content 
if($branch == "ALL" || $branch == ""){
    $ins = (new ControllerInsurance)->ctrShowFilterPhilInsurance($date);
}else{
    $ins = (new ControllerInsurance)->ctrShowFilterPhilInsuranceByBranch($date, $branch);
}

if(!empty($ins)){
$row = 6;
$id = 1;
$total_loan =0;
$total_65 =0;
$total_66_70=0;
$total_71_75=0;
$total_amount=0;
foreach($ins as $insurance){
    $name = $insurance['name'];
    $ins_rate = $insurance['ins_rate'];
   $account_id = $insurance['account_id'];
   $avail_date =  $insurance['avail_date'];
   $amount_loan =  floatval($insurance['amount_loan']);
   $age =  $insurance['age'];
   $birth_date = date("m/d/Y", strtotime($insurance['birth_date']));
   $avail_date = date("m/d/Y", strtotime($insurance['avail_date']));
   if($insurance['expire_date'] != ""){
     $expire_date = date("m/d/Y", strtotime($insurance['expire_date']));
   }else{
    $expire_date = "";
   }
 
   
//    $amount = number_format((float)$insurance['amount'], 2, '.', ',');
//    $amount_loan =  $insurance['amount_loan'];

//     if($amount_loan != ""){
//         $amount_loan = number_format((float)$insurance['amount_loan'], 2, '.', ',');
//     }
   
    // Split the full name by the comma
    $name_parts = explode(',', $name);

    // Extract the last name
    $last_name = $name_parts[0];
    $full_name = $name_parts[1];
    

    $lastLetter = substr($full_name, -1);
    if($lastLetter == "."){
        $middle_name = substr($full_name, -2, 2);
        $first_name = substr($full_name, 0, -2);
    }else{
        $middle_name = "";
        $first_name = $full_name;
    }
    
    $suffix = getSuffix($name);
    $first_name = removeSuffix($first_name);
    $last_name = removeSuffix($last_name);

    // if($age<=59){
    //     $below65 = $ins_rate;
    // }else{
    //     $below65 = "";
    // }

    // if($age >= 60 && $age <= 65){
    //     $between66_70 = $ins_rate;
    // }else{
    //     $between66_70 = "";
    // }

    // if($age>70 && $age <=80){
    //     $between71_75 = $ins_rate;
    // }else{
    //     $between71_75 = "";
    // }
   


    $spreadsheet->getActiveSheet()
    ->setCellValue('A'.$row, $id)
    ->setCellValue('B'.$row, $account_id)
    ->setCellValue('C'.$row, $last_name)
    ->setCellValue('D'.$row, $first_name)
    ->setCellValue('E'.$row, $middle_name)
    ->setCellValue('F'.$row, $suffix)
    ->setCellValue('G'.$row, $birth_date)
    ->setCellValue('H'.$row, $insurance['age'])
    ->setCellValue('I'.$row, $insurance['gender'])
    ->setCellValue('J'.$row, $insurance['civil_status'])
    ->setCellValue('K'.$row, $avail_date)
    ->setCellValue('L'.$row, $expire_date)
    ->setCellValue('M'.$row, $insurance['terms'])
    ->setCellValue('N'.$row, $insurance['amount_loan'])
    ->setCellValue('O'.$row, $insurance['amount'])
    ->setCellValue('P'.$row, $ins_rate)
    ->setCellValue('Q'.$row, $insurance['branch_name']);
    $spreadsheet->getActiveSheet()->getStyle("A$row:Q$row")->applyFromArray($borderStyle);
    $spreadsheet->getActiveSheet()->getStyle("A$row:Q$row")->getFont()->setSize(9);
    $spreadsheet->getActiveSheet()->getCell("N$row")->getStyle()->getNumberFormat()->setFormatCode('#,##0.00_-;-#,##0.00_-;_- "-"_-;_-@_-');
    $spreadsheet->getActiveSheet()->getCell("R$row")->getStyle()->getNumberFormat()->setFormatCode('#,##0.00_-;-#,##0.00_-;_- "-"_-;_-@_-');
    $row ++;
    $id ++;
    // $total_loan = $total_loan + $amount_loan;
    // $total_65= $total_65 + floatval($below65);
    // $total_66_70= $total_66_70 + floatval($between66_70);
    // $total_71_75=$total_71_75 + floatval($between71_75);
    $total_amount = $total_amount + floatval($insurance['amount']);
  
}

$rowadd = $row + 1;
// $spreadsheet->getActiveSheet()->setCellValue("M$row",  $total_loan);
// $spreadsheet->getActiveSheet()->setCellValue("O$row",  $total_65);
// $spreadsheet->getActiveSheet()->setCellValue("P$row",  $total_66_70);
// $spreadsheet->getActiveSheet()->setCellValue("Q$row",  $total_71_75);
$spreadsheet->getActiveSheet()->setCellValue("O$rowadd",  $total_amount);
$spreadsheet->getActiveSheet()->getStyle("A$row:Q$row")->applyFromArray($borderStyle);
$spreadsheet->getActiveSheet()->getStyle("A$rowadd:Q$rowadd")->applyFromArray($borderStyle);
$spreadsheet->getActiveSheet()->getStyle("A$rowadd:Q$rowadd")->applyFromArray($fillStyle);
$spreadsheet->getActiveSheet()->getStyle("O$rowadd")->getFont()->setBold(true);
// $spreadsheet->getActiveSheet()->setCellValue("P$row",  "TOTAL");
// $spreadsheet->getActiveSheet()->getCell("M$row")->getStyle()->getNumberFormat()->setFormatCode('#,##0.00_-;-#,##0.00_-;_- "-"_-;_-@_-');
// $spreadsheet->getActiveSheet()->getCell("O$row")->getStyle()->getNumberFormat()->setFormatCode('#,##0.00_-;-#,##0.00_-;_- "-"_-;_-@_-');
// $spreadsheet->getActiveSheet()->getCell("P$row")->getStyle()->getNumberFormat()->setFormatCode('#,##0.00_-;-#,##0.00_-;_- "-"_-;_-@_-');
// $spreadsheet->getActiveSheet()->getCell("Q$row")->getStyle()->getNumberFormat()->setFormatCode('#,##0.00_-;-#,##0.00_-;_- "-"_-;_-@_-');
$spreadsheet->getActiveSheet()->getCell("R$row")->getStyle()->getNumberFormat()->setFormatCode('#,##0.00_-;-#,##0.00_-;_- "-"_-;_-@_-');
// $spreadsheet->getActiveSheet()->getStyle("O$row:R$row")->applyFromArray($borderStyle);
// $spreadsheet->getActiveSheet()->getStyle("M$row")->getFont()->setBold(true);
// $spreadsheet->getActiveSheet()->getStyle("R$row")->applyFromArray($borderStyle);
$spreadsheet->getActiveSheet()->getStyle("R$row")->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle("Q$row")->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('A3', 'DATE:');
$spreadsheet->getActiveSheet()->setCellValue('B3', $avail_date);
}


$fileName = "INSURANCE SUMMARY PHILINSURE " . $date;

// Set the HTTP headers to make the file downloadable
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$fileName.'.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);

// Output the file directly to the browser
$writer->save('php://output');
