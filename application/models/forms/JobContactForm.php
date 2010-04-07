<?php
/**
 * RefineForm Form
 *      @version	$Id: ListingForm.php 5195 2009-05-26 07:10:02Z xinghao $
 *      @package	Application
 *      @subpackage	admin
 *      @author		Xinghao <xinghao@airarena.net>
 *      @copyright	Copyright (c) 2009 Creagency (www.creagency.com.au)
 */

require_once (WEBSITE_ROOT."/includes/recaptchalib.php");
class JobContactForm extends ContactForm
{


	protected function buildElements()
	{
		parent::buildElements();

		$comment = $this->getElement("question");
		$comment->setLabel("Comment:");
		$this->addElement($comment);

	}





}
