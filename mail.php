<?php

if ($_POST) {
    $name = $_POST['name'];  //some usual fields
    $phone = $_POST['phone'];

    $image = $_POST['image']; //image in base64 format
    $subject = "Your subject";
    $to = "example@gmail.com"; //your email

    $subject = '=?utf-8?b?' . base64_encode($subject) . '?=';
    $fromMail = 'info@example.com'; //from email
    $fromName = 'example'; //from name
    $date = date(DATE_RFC2822);
    $baseboundary = '==mime-boundary-' . md5(time());
    $messageId = '<' . time() . '-' . md5($fromMail . $to) . '@' . $_SERVER['SERVER_NAME'] . '>';

    $headers = 'From: ' . $fromName . ' <' . $fromMail . ">\r\n";
    $headers .= 'Reply-To: ' . $fromMail . "\r\n"; //use if you need
    $headers .= "Date: $date\r\n";
    $headers .= "Message-ID: $messageId\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=$baseboundary\r\n";

    $text = "Sender name - " . $name . "\n" . "Sender phone: " . $phone . "\n";

    $message = "--$baseboundary\r\n";
    $message .= "Content-Type: text/plain; charset=utf-8\r\n";
    $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $message .= $text . "\r\n\r\n";


    $imageMimeType = 'image/jpeg';
    $imageFileName = 'example.jpg'; //name of file which will be attached to a letter
    $message .= "--$baseboundary\r\n";
    $message .= "Content-Type: $imageMimeType;\r\n";
    $message .= "Content-Transfer-Encoding: base64 \r\n";
    $message .= "Content-Disposition: attachment; filename=\"$imageFileName\"\r\n";
    $message .= "\r\n";
    $message .= chunk_split($image);
    $message .= "\r\n";
    $message .= "--$baseboundary--\r\n";

    $result = mail($to, $subject, $message, $headers);
    var_dump($result); //check for function execution status
}
