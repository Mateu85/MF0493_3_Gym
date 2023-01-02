<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Security {

	protected function secure_input($data) {
		
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;

	}

	protected function en_de_cryptIt($string, $action) {

		$secret_key = '32452c24d2e5242394f51L24eEr210';
		$secret_iv = 'A)2C!u427z^';

		$output = false;
		$encrypt_method = 'AES-256-CBC';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv ), 0, 16);

		if($action == 'en') {
			$output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
		} else if($action == 'de') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}

		return $output;
	}

	protected function tokenGen($length) {

		$code = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789';
		$str_shuffle = str_shuffle($code);
		$token = substr($str_shuffle, 0, $length);
		return $token;

	}

	protected function email($email, $subject, $body) {

		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->IsHTML(true);
		$mail->SMTPDebug = 0;
		$mail->CharSet = 'UTF-8';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPAuth = true;
		$mail->Username = 'pruebascifovioleta20@gmail.com';
		$mail->Password = 'cifo1920';
		$mail->setFrom('pruebascifovioleta20@gmail.com', 'MVC-PHP');
		$mail->addAddress($email);
		$mail->Subject = $subject;
		$mail->MsgHTML($body);

		if($mail->send()) { return true;
		} else { return false; }

	}

}
