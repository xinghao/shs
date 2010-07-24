<?php
class Email
{

    public static function sendMail($toMailAddress, $name, $subject, $body)
    {
    	try{
	    	$config		= Zend_Registry::get('CONFIG');
	        $sitename = $config->website->host;

	        logfire('send email', $toMailAddress);

	        $mailer = new Zend_Mail('utf-8');
	        $mailer->addTo($toMailAddress, $name);
	        $mailer->setFrom('x3k2pr10oynew@spot101.com','SydneyHostpot');
	        $mailer->setSubject($subject);
	        $mailer->setBodyHtml($body, 'utf8');
	        $mailer->send();
        }catch(Exception $e){
			logError('send mail failed',$e->getMessage());
    	}
    }


}
?>
