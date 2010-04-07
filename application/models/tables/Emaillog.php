<?php


class Emaillog extends Zend_Db_Table
{
	protected $_name = 'email_sendlog';
    protected $_primary = 'sendLogId';

    public  function getTableName()
    {
    	return $this->_name;
    }


	public function writelog($posting_id, $send_name, $send_email, $send_question)
	{
		try{
			$data = array();
			$data["postingID"] = $posting_id;
			$data["sendName"] = $send_name;
			$data["sendEmail"] = $send_email;
			$data["sendQuestion"] = $send_question;
			$data["sendDate"] = new Zend_Db_Expr('NOW()') ;

			$this->insert($data);
 		}catch(Exception $e)
 		{
 			logError('write log failed!', $e);
 			echo $e;
 			throw $e;
 		}
	}

}

