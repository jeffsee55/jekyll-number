<?php

$isWP = false;
if (file_exists("../../../../../wp-load.php")) {
    include("../../../../../wp-load.php");
    $isWP = true;
}

$emailTo       = '<lex@craftcreative.nl>';
$sender_email = 'website@lesdeuxponts.nl';
$subject = 'Nieuw bericht via de website!';

$errors = array();
$data   = array();
$body    = '';
$email = '';
$name = '';
$domain = '';
if (isset($_POST['email'])) $domain = $_POST['domain'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $arr = $_POST['values'];
    $sender_email = 'contacts@' . $domain;
    $email = 'no-replay@' . $domain;

    if (isset($_POST['email']) && strlen($_POST['email']) > 0)  $emailTo = $_POST['email'];
    if (isset($_POST['subject_email']) && strlen($_POST['subject_email']) > 0) $subject = $_POST['subject_email'];
    else $subject = '[' . $domain . '] New message';

    foreach ($arr as $key => $value ) {
        $val =  stripslashes(trim($value[0]));
        if (!empty($val)) {
            $body .= ucfirst($key) . ': ' . $val . PHP_EOL . PHP_EOL;
            if ($key == "email"||$key == "Email"||$key == "E-mail"||$key == "e-mail") $email = $val;
            if ($key == "name"||$key == "nome"||$key == "Nome") $name = $val;
        }
    }
    $body .= "-------------------------------------------------------------------------------------------" . PHP_EOL . PHP_EOL;
    $body .= "New messagge from " . $domain;
    if ($name == '') $name = $subject;

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {
        $headers  = "From: " . $sender_email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";

        $result;
        if ($isWP) {
            try {
                $result = wp_mail($emailTo, $subject, $body, $headers);
            }
            catch (Exception $exception) {
                $result = mail($emailTo, $subject, $body, $headers);
            }
        } else {
            $result = mail($emailTo, $subject, $body, $headers);
        }

        if ($result) {
            $data['success'] = true;
            $data['message'] = 'Uw bericht is verstuurd.';
        } else {
            $data['success'] = false;
            $data['message'] = 'Er is iets fout gegaan. Probeer het nog eens.';
        }
    }
    // return all our data to an AJAX call
    echo json_encode($data);
}
