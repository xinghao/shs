<?php 



class CrFramework_Db_Adapter_Pdo_Pgsql extends Zend_Db_Adapter_Pdo_Pgsql {
	
    public function getConnection()
    {
        logStd('getConnection', 'using customer pgsql adapter');
        return parent::getConnection();
    }
	
    public function fetchAll($sql, $bind = array(), $fetchMode = null)
    {
        logStd('fetchAll', 'using customer pgsql adapter');
    	return parent::fetchAll($sql, $bind, $fetchMode);
    }
    
    public function fetchRow($sql, $bind = array(), $fetchMode = null)
    {
        logStd('fetchRow', 'using customer pgsql adapter');
    	return parent::fetchRow($sql, $bind, $fetchMode);
    }

    public function query($sql, $bind = array())
    {
    	logStd('query', 'using customer pgsql adapter');
    	return parent::query($sql,$bind);
    	
    }
}	