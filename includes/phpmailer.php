<?php
	include("lib/phpmailer/class.phpmailer.php");
	global $mail;
	
	$mail = new phpmailer();

/*	
	
	$mail->Mailer   = "smtp";
	$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
  	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
  	$mail->Port       = 465;
	$mail->SMTPAuth= true;	
	$mail->Username= "noreply@textlink.vn";
	$mail->Password= "text@link.vn";	
*/
	
	$mail->Host     = "localhost";
	$mail->IsSendmail();
	$mail->IsHTML(true);	
	$mail->SMTPDebug  = 1;
	
	$mail->CharSet	  =	"utf8";
	$mail->SetFrom("noreply@textlink.vn", "Textlink.vn");	
	
	$mail->ClearReplyTos();
	$mail->AddReplyTo("support@textlink.vn", "Textlink.vn Support");
	
	$signature= '
		<br><br>Cảm ơn bạn đã đồng hành cùng Textlink.vn !
		<br />-----<br />
		<strong>Textlink.vn Support</strong><br />
		Tel: (04) 62.69.899 - Email: support@textlink.vn - Website: <a href="http://www.textlink.vn">www.textlink.vn</a><br />
		Add: 9 Floor, Thanglong tower, 98A Nguy Nhu KonTum Street, Thanh Xuan, Ha Noi	
	'; 
	
	function sendMail($to_email, $to_name, $subject, $body, $reply_email= "", $reply_name= "", $from_email= "", $from_name= "")
	{
		global $mail, $signature;

		if($from_email!="")
			$mail->SetFrom($from_email, $from_name);
			
		if($reply_email!="")
		{
			$mail->ClearReplyTos();
			$mail->AddReplyTo($reply_email, $reply_name);
		}
			

		$mail->Subject= $subject;
		$mail->Body= $body.$signature;

		$mail->ClearAddresses();
		$mail->AddAddress($to_email, $to_name);

		if(!$mail->Send())
			return false;
		else
			return true;
	}
?>
