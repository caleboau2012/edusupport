<?php
//phpinfo();

// Pear Mail Library
error_reporting(E_ALL);
require_once "Mail.php";

$from = 'caleb.mbakwe@cloudtechng.com';
    $to = 'caleboau2012@gmail.com';
        $subject = 'Hi!';
        $body = "Hi,\n\nHow are you?";

        $headers = array(
        'From' => $from,
        'To' => $to,
        'Subject' => $subject
        );

        $smtp = Mail::factory('smtp', array(
        'host' => 'smtp.gmail.com',
        'port' => '587',
        'auth' => true,
        'username' => 'caleb.mbakwe@cloudtechng.com',
        'password' => 'prince9143'
        ));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
        echo('<p>' . $mail->getMessage() . '</p>');
        } else {
        echo('<p>Message successfully sent!</p>');
        }