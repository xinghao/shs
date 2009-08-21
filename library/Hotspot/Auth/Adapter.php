<?php
/*
 * Becareful if you change this interface
 * it uses for gummo (debug) and userController
 */

class CrFramework_Auth_Adapter implements Zend_Auth_Adapter_Interface {
	

    protected $Identity = null; 	   

    protected $Credential = null; 	   
	
    protected $Rows = null;
     
    public function __construct($identity, $credential,$rows) 	  
    { 	    
        $this->Identity   = $identity; 	        
        $this->Credential = $credential;
        $this->Rows = $rows; 	
      	$this->RowsIdent=array();
    } 	    
	

    public function setIdentity($value) 	  
    { 	    
        $this->Identity = $value; 	    
        return $this; 	      
    } 	    
	
 
    public function setCredential($value) 
    { 	   
        $this->Credential = $value; 	        
        return $this; 	        
    } 	    
    
	 public function setRows($value) 
    { 	   
        $this->Rows = $value; 	        
        return $this; 	        
    }
     public function getUserDetail() 
    { 	         
    	$userInfo= $this->array2object($this->RowsIdent);
        return $userInfo; 	        
    }
  	 
  
    public function authenticate() 	   
    { 	   
        $exception = null; 	 
        $result    = array( 	 
            'code'     => Zend_Auth_Result::FAILURE, 	 
            'identity'  => $this->Identity, 	 
            'messages' => array() 	 
        ); 	 
  	 	$userInfo=array();

        if (empty($this->Identity)) { 	      
            $exception = 'You must provide a identity to authenticate'; 	            
            throw new Zend_Auth_Adapter_Exception('Please verify your username');
            
        } else if (empty($this->Credential)) { 	        
            $exception = 'You must provide a credential to authenticate'; 	
             
        } elseif($this -> Rows){
    
	        if(is_array($this->Rows)){
	        	$this->Rows=$this->array2object($this->Rows);
	        }
	
			$userInfo[0]['user_id']   =isset($this -> Rows->user_id)  && !empty($this -> Rows->user_id)   ?$this -> Rows->user_id   :'';
			$userInfo[0]['username']  =isset($this -> Rows->username) && !empty($this -> Rows->username)  ?$this -> Rows->username  :'';
			$userInfo[0]['firstname'] =isset($this -> Rows->firstname)&& !empty($this -> Rows->firstname) ?$this -> Rows->firstname :'';
			$userInfo[0]['lastname']  =isset($this -> Rows->lastname) && !empty($this -> Rows->lastname)  ?$this -> Rows->lastname  :'';
			$userInfo[0]['location']  =isset($this -> Rows->location) && !empty($this -> Rows->location)  ?$this -> Rows->location  :'';
			$userInfo[0]['email']     =isset($this -> Rows->email)    && !empty($this -> Rows->email)     ?$this -> Rows->email     :'';
			$userInfo[0]['role_id']   =isset($this -> Rows->role_id) && !empty($this -> Rows->role_id)  ?$this -> Rows->role_id  :'';
			$userInfo[0]['active']    =isset($this -> Rows->active)   && !empty($this -> Rows->active)    ?$this -> Rows->active    :'';
			$userInfo[0]['publisher_id']    =isset($this -> Rows->publisher_id)   && !empty($this -> Rows->publisher_id)    ?$this -> Rows->publisher_id    :'';
			$found=true;
			
			
			if(!empty($userInfo[0]['role_id'])){
			
				$role= new Roles();
	    		$roleid = $role->fetchROW("  role_id='".$userInfo[0]['role_id']."'");
	    	
	    		$userInfo[0]['rolename'] =$roleid->role_name; 
	    		 	 
			}else{
				$userInfo[0]['rolename'] =''; 
			} 
	    	 if (isset($userInfo) && !empty($userInfo)){
	        	$result['code']= Zend_Auth_Result::SUCCESS; 	        
	        	$result['messages'][] = 'Authentication success'; 
	        	$this->RowsIdent=$userInfo;
	        }else{
	        	//$exception = 'You must provide a credential to authenticate'; 	
	        	$result['code']= Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND; 	        
	      		$result['messages'][] = 'Authentication failed'; 
	        }
    	}	 
	    if (null != $exception) { 	       
	        throw new Zend_Auth_Adapter_Exception($exception);  	            
    	}	 
           

  	  return new Zend_Auth_Result($result['code'], $result['identity'], $result['messages'],$userInfo);
	}
	
	public function getResultRowObject($rowset){
		
		
		$identity = new stdClass();
		$identity->user_pk     =  $rowset[0]['user_id'];
	 	$identity->user_name   =  $rowset[0]['username'];
		$identity->firstname   =  $rowset[0]['firstname']; 
		$identity->lastname    =  $rowset[0]['lastname'];
		$identity->city_name   =  $rowset[0]['location'];
		$identity->email       =  $rowset[0]['email'];
		$identity->role_id     =  $rowset[0]['role_id'];
		$identity->rolename    =  $rowset[0]['rolename'];
		$identity->publisher_id    =  $rowset[0]['publisher_id'];
		
	}
	//works for usercontroller
	public function array2object(array $array){
 
	    $object = new stdClass();
	    foreach ($array[0] as $key => $val){
	    	
	        if (is_array($val)){
	            $object->$key = $this->array2Object($val);
	        } else {
	            $object->$key = $val;
	        }
	    }
	    return $object;

    	
    }
}
?>