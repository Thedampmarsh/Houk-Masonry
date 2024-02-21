<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '/home/houkmasonry/public_html/PHPMailer/src/Exception.php';
    require '/home/houkmasonry/public_html/PHPMailer/src/PHPMailer.php';
    require '/home/houkmasonry/public_html/PHPMailer/src/SMTP.php';

    $msg = '';
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 
        $mail->SMTPAuth = true;
        $mail->Username = 
        $mail->Password = 
        $mail->Port = 25; 
        $mail->SMTPAutoTLS = false;
        $mail->SMTPSecure = false;
        $mail->isHTML(false);
        $mail->setFrom($_POST['email'], $_POST['name']);
        $mail->addAddress
        $mail->Subject = 'New Project Inquiry';
        $mail->Body = <<<EOT
Email: {$_POST['email']}
Name: {$_POST['name']}
Message: {$_POST['message']}
EOT;
 //Attach multiple files one by one
 if (!empty($_FILES['userfile']['tmp_name'])) {
    for ($ct = 0, $ctMax = count($_FILES['userfile']['tmp_name']); $ct < $ctMax; $ct++) {
        //Extract an extension from the provided filename
        $ext = PHPMailer::mb_pathinfo($_FILES['userfile']['name'][$ct], PATHINFO_EXTENSION);
        //Define a safe location to move the uploaded file to, preserving the extension
        $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['userfile']['name'][$ct])) . '.' . $ext;
        $filename = $_FILES['userfile']['name'][$ct];
        if (move_uploaded_file($_FILES['userfile']['tmp_name'][$ct], $uploadfile)) {
            if (!$mail->addAttachment($uploadfile, $filename)) {
                $msg .= 'Failed to attach file ' . $filename;
            }
        } else {
            $msg .= 'Failed to move file to ' . $uploadfile;
        }
    }
 }
        $mail->send();
        echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Message Sent</title>
<style>
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.message-container {
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1), 0 6px 6px rgba(255, 255, 255, 0.1);
    padding: 50px;
    display: flex;
    flex-direction: column;
    align-items: center;
    color: black;
}

.message {
    font-size: 24px;
    color: black;
    padding: 20px;
}
img {
    width: 50px; /* Adjust the width as needed */
    height: auto; /* Maintains the aspect ratio */
}
.message2{
    font-size: 20px;
    word-wrap: break-word;
    color:grey;
    max-width:250px;
    text-align:center;
}
button {
    font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  background: #000000;
  border: rgb(255, 255, 255) 2px double;
  width: 57%;
  border: 0;
  padding: 15px;
  margin-top: 25px;
  margin-bottom: 25px;
  color: #FFFFFF;
  font-size: 14px;
  cursor: pointer;
}

button:hover {
 box-shadow: inset -5px -5px 30px 5px #0093E9;
  background: lightblue;
  color: black;
}
</style>
</head>
<body>
    <div class="message-container">
        <p class="message">Message sent</p>
        <img src="masonry.png" alt="Example Image">
        <p class="message2"> Thank you for contacting Houk Masonry! </p>
        <button onclick="goBack()">Go Back</button>
    </div>
    
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>

HTML;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
    
?>
