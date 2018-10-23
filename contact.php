<?php

/*
|--------------------------------------------------------------------------
| Settings
|--------------------------------------------------------------------------
*/

define("EMAIL" , "contact@acecommerce.com");
define("SUBJECT" , "Ace Commerce - Contact");

define("NAME_MSG" , "Please insert your name");
define("EMAIL_MSG" , "Please insert an email");
define("EMAIL_WRONG" , "Please insert a valid email");
define("PHONE_MSG" , "Please insert a phonenumber");
define("MESSAGE_MSG" , "Please insert a message");

/*
|--------------------------------------------------------------------------
| Simple Sender Script
|--------------------------------------------------------------------------
*/

if( $_POST ) {

  /* check mandatory fields */
  if( empty( $_POST['name'] ) ) {
    exit( NAME_MSG );
  }

  if( empty( $_POST['email'] ) ) {
    exit( EMAIL_MSG );
  }

  if( empty( $_POST['phone'] ) ) {
    exit( PHONE_MSG );
  }

  if( empty( $_POST['message'] ) ) {
    exit( MESSAGE_MSG );
  }

  /* validate email */
  if ( !empty( $_POST['email']) && !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['email'])) {
    exit( EMAIL_WRONG );
  }

  /* create body message */
  $message = '';

  // Name
  $message.= $_POST['name'];

  // Email
  $message.= '<br />' . $_POST['email'] . '<br />';

  // Phone
  $message.= $_POST['phone'];

  // Message
  $message.= '<p>' . $_POST['message'] . '</p>';


  require_once "vendor/autoload.php";
  $mail = new PHPMailer;

  define('GUSER', 'sayemmkhan@gmail.com'); // GMail username
  define('GPWD', '6batmanrastignac'); // GMail password

  function smtpmailer($to, $from, $from_name, $subject, $body) {
    global $error;
    $mail = new PHPMailer();  // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom($from, $from_name);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->IsHTML(true);
    $mail->AddAddress($to);
    if(!$mail->Send()) {
      echo 'ERROR';
      $error = 'Mail error: '.$mail->ErrorInfo;
      return false;
    } else {
      echo 'OK';
      $error = 'Message sent!';
      return true;
    }
  }

  smtpmailer(EMAIL, 'sayemmkhan@gmail.com', 'Ace Commerce', SUBJECT, $message);
}

?>
