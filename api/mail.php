<?php
header("Content-Type: application/json;  charset=UTF-8");

if(isset($_POST['email'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "denizdemirci156@gmail.com";
    $email_subject = "Kral Faruk Yorum";

    function died($error) {
        // your error code can go here
        $results = array(
   'error' => true,
   'error_msg' => $error,
   'data' => array('İletiniz Gönderilemedi')
);
	echo json_encode($results);
		
        die();
    }

    // validation expected data exists
    if(!isset($_POST['username']) ||
        !isset($_POST['email']) ||
        !isset($_POST['phone']) ||        
        !isset($_POST['message'])) {
        $results = array(
   'error' => true,
   'error_msg' => $error_message,
   'data' => array('İletiniz Gönderilemedi')
);
	echo json_encode($results);
	die();       
    }

    $username = $_POST['username']; // required
    $email_from = $_POST['email']; // required
    $phone = $_POST['phone']; // required    
    $message = $_POST['message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'E-mail adresiniz doğru gözükmüyor.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$username)) {
    $error_message .= 'Gerçekten isminiz bu mu?.<br />';
  }
  
  if(strlen($comments) < 2) {
    $error_message .= 'Lütfen bi kaç satır daha yazın.<br />';
  }
  if(strlen($error_message) > 0) {
    $results = array(
   'error' => true,
   'error_msg' => $error_message,
   'data' => array('Hata')
);
	echo json_encode($results);
	die();
	
  }
    $email_message = "Form detayları :\n\n";

    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

    $email_message .= "First Name: ".clean_string($username)."\n";
    $email_message .= "Phone: ".clean_string($phone)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";   
    $email_message .= "Comments: ".clean_string($message)."\n";

// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);
sleep(2);
$results = array(
   'error' => false,
   'error_msg' => '',
   'data' => array('Gönderildi')
   
);
echo json_encode($results);
}
else{
    $results = array(
   'error' => true,
   'error_msg' => 'Degerler alınamadı',
   'data' => array('Hata')
   
);
echo json_encode($results);
}