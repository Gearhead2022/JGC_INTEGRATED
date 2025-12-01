<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';

try {
    $permit = (new ControllerPermits)->ctrShowPermitByID($data);
    $wp_req_by = $permit[0]['wp_req_by'];
    $wp_date = $permit[0]['wp_date'];
    $wp_from = $permit[0]['wp_from'];
    $wp_req_for = $permit[0]['wp_req_for'];
    $request_level = $permit[0]['request_level'];
    // Replace double <br /> with a single one (any variation)
    $clean_wp_req_for = preg_replace('/(<br\s*\/?>\s*){2,}/i', '<br />', $wp_req_for);
    if($wp_from == 1){
        $department = "MANAGEMENT ACCOUNTING DEPARTMENT";
    }elseif($wp_from == 2){
            $department = "OPERATION DEPARTMENT";
    }elseif($wp_from == 3){
            $department = "HROM DEPARTMENT";
    }elseif($wp_from == 4){
            $department = "FINANCIAL ACCOUNTING DEPARTMENT";
    }elseif($wp_from == 5){
            $department = "AUDIT DEPARTMENT";
    }elseif($wp_from == 6){
            $department = "CREDIT AND COLLECTION DEPARTMENT";
    }elseif($wp_from == 7){
        $department = "GRCD DEPARTMENT";
    }elseif($wp_from == 8){
        $department = "PSPMI";
    }else{
        $department = "OTHER DEPARTMENT";
    }

    if($request_level == 2 || $wp_from == 4){
    
    $mail = new PHPMailer(true);
    // Server settings
    $mail->isSMTP();                                      // Send using SMTP
    $mail->Host = 'smtp.gmail.com';                // Set SMTP server
    $mail->SMTPAuth   = true;                             // Enable SMTP auth
    $mail->Username   = 'jgcmissoftwaredepartment@gmail.com';               // SMTP username
    $mail->Password   = 'yrvihzusblsbvtgg';                   // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Encryption
    $mail->Port       = 587;                              // SMTP port

    // Recipients
    $mail->setFrom('jgcmissoftwaredepartment@gmail.com', 'JGC MIS SOFTWARE DEPARTMENT');
    $mail->addAddress('tynz0304@yahoo.com', 'CGN');

    $mail->isHTML(true);
    $mail->Subject = 'New Working Permit Request Pending Approval';

// HTML version
$mail->Body = ' 
    <h2 style="color:#2c3e50;">Working Permit Request</h2>
    <p>Dear Approver,</p>

    <p>You have received a new working permit request from <strong>' . htmlspecialchars($department) . '</strong> that requires your review and approval.</p>

    <p><strong>Request Summary:</strong></p>
    <table cellpadding="6" cellspacing="0" border="0" style="font-family: Arial, sans-serif; font-size: 14px;">
        <tr>
            <td><strong>Requested By:</strong></td>
            <td>' . htmlspecialchars($wp_req_by) . '</td>
        </tr>
        <tr>
            <td><strong>Date Requested:</strong></td>
            <td>' . htmlspecialchars($wp_date) . '</td>
        </tr>
        <tr>
            <td><strong>Department:</strong></td>
            <td>' . htmlspecialchars($department) . '</td>
        </tr>
       <tr>
  <td><strong>Request For:</strong></td>
  <td>
    <div style="white-space: normal; font-family: Arial, sans-serif; font-size: 14px;">
      ' . html_entity_decode($clean_wp_req_for) . '
    </div>
  </td>
</tr>


    </table>

    <p>Please log in to the system to review the full details and take the necessary action.</p>

    <p style="color: gray; font-size: 12px;">This is an automated notification. Please do not reply to this email.</p>
';

// Plain-text version (for email clients that don’t support HTML)
$mail->AltBody = "Working Permit Request Pending Approval\n\n"
    . "You have received a new working permit request:\n"
    . "Requested By: " . $wp_req_by . "\n"
    . "Date Requested: " . $wp_date . "\n"
    . "Department: " . $department . "\n"
    . "Request For: " . $wp_req_for . "\n\n"
    . "Please log in to the system to review and take the necessary action.\n\n"
    . "This is an automated message. Do not reply.";

$mail->send();
// echo 'Message has been sent';
    }
} catch (Exception $e) {
    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
