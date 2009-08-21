<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="ISO-8859-1"%>  
<%@ taglib prefix="s" uri="/struts-tags" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Sydney Hotspot</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="/style/common.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/style/searchbox.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/style/autosuggest.css" type="text/css" media="all" />    
    <link rel="stylesheet" href="/style/homePage_keywordForm.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="/style/sitetemplateimage/favicon.ico" />    

    	<link rel="stylesheet" href="/style/homePage.css" type="text/css" media="all" />
    	
</head>
<body>


<center>
	<div id="wrap">
		<jsp:include page="common/header.jsp"></jsp:include>
		<div id="ContentPHDiv">
		   	<div id="content-wrap">
				<div id="content-left">
				    <div id="content-left-up">
				         <!--<div id="content-left-up-left"></div>-->
				        <div id="logo"></div>
				    </div>
				    <div id="content-left-down">
					<jsp:include page="common/search.html"></jsp:include>
				    </div>
					<jsp:include page="common/footer.html"></jsp:include>
				</div>
				<div id="content-right"><!--<img src="" width="253" height="474" border="0"/>-->
	
				</div>
				<div class = "clearall" ></div>
			</div>
        </div>
	</div>
</center> 	
	<jsp:include page="common/ajaxload.html"></jsp:include>
</body>
</html>
