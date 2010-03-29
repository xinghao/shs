<?php
class Email
{

    public static function sendMail($toMailAddress, $name, $subject, $body)
    {
    	try{
	    	$config		= Zend_Registry::get('CONFIG');
	        $sitename = $config->website->host;


	        $mailer = new Zend_Mail('utf-8');
	        $mailer->addTo($toMailAddress, $name);
	        $mailer->setSubject($subject);
	        $mailer->setBodyHtml($body, 'utf8');
	        $mailer->setFrom($config->mail->from);
	        $mailer->send();
        }catch(Exception $e){
			logError('send mail failed',$e->getMessage());
    	}
    }


}
?>
