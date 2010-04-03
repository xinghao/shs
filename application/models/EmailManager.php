<?php
/*
 * Application emails management module.
 * Basically all the email related jobs should be do by this class.
 *
 * YPEX Email system design:
 * 1. If you want to send an email, you just create an email into emails table.
 *    e.g. When user subscribe a listing we create a registration email to emails table (call EmailManager::CreateSubscriptionRegistrationletter())
 * 2. We have an batch job (called by crontab every minute) to query emails table to get emails whose status is waiting and send them.
 *
 *
 * @author		Xinghao Yu <xinghao@airarena.net>
 * @version		$Rev: 7374 $ $xinghao $Id: EmailManager.php 7374 2010-01-28 00:38:29Z timw $Date: 2009-06-02 15:34:13 +1000 (Tue, 02 Jun 2009) $
 * @package		application
 * @subpackage	models
 * @copyright	Copyright (c) 2008 Creagency (www.creagency.com.au)
 */
class EmailManager
{

	// Email subject for receipt.
	const CONTACTEMAILSUBJECT = 'Question from [Sender] -- SydneyHotspot';


	public static function sentContactEmail($formData, $postingData, $isLog = true)
	{
		$mail_subject = str_replace('[Sender]', $formData["fullname"], self::CONTACTEMAILSUBJECT);
		$mail_body    = TemplatingManager::getContactEmail($formData, $postingData);


		Email::sendMail($formData["email_from"],
						$formData["fullname"],
						$mail_subject,
						$mail_body);

		$emaillog = new Emaillog();
		$emaillog->writelog($postingData["id"], $formData["fullname"], $formData["email_from"], $formData["question"]);

	}


}

?>
