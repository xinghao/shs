function checkOwnRule(){

		var inputObj=$("#contactform input");

		var prehint="Please check your ";

		var posthint=". It should not be empty";

		var phonecnt=-1;

		var objphone=0;

		$("#recaptcha_response_field").attr("hint", "validation code");
		
		for (i=0;i<inputObj.length-1;i++){


			strHint=$(inputObj[i]).attr("hint");
	

			

				if (inputObj[i].value==""){

					alert(prehint+strHint+posthint);
					//alert($(inputObj[i]).attr("hint"));
					inputObj[i].focus();

					return false;

				}

		}
		
		inputObj=$("#contactform textarea");
		for (i=0;i<inputObj.length;i++){


			strHint=$(inputObj[i]).attr("hint");
	

			

				if (inputObj[i].value==""){

					alert(prehint+strHint+posthint);

					inputObj[i].focus();

					return false;

				}

		}
	

		return true;

	}

	

function echeck(str) {

        var at="@"

		var dot="."

		var lat=str.indexOf(at)

		var lstr=str.length

		var ldot=str.indexOf(dot)

		if (str.indexOf(at)==-1){

		   alert("Invalid E-mail Address")

		   return false

		}



		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){

		   alert("Invalid E-mail Address")

		   return false

		}



		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){

		    alert("Invalid E-mail Address")

		    return false

		}



		 if (str.indexOf(at,(lat+1))!=-1){

		    alert("Invalid E-mail Address")

		    return false

		 }



		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){

		    alert("Invalid E-mail Address")

		    return false

		 }



		 if (str.indexOf(dot,(lat+2))==-1){

		    alert("Invalid E-mail Address")

		    return false

		 }

		

		 if (str.indexOf(" ")!=-1){

		    alert("Invalid E-mail Address")

		    return false

		 }



 		 return true					

	}



function ValidateForm(){

	var email=$("input#email_from");
	var emailID = $(email).attr("value");

	

	if ((emailID==null)||(emailID=="")){

		alert("Please check your email address. It does not appear to be valid.")

		email.focus()

		return false

	}

	if (echeck(emailID)==false){

		$(email).attr("value", "");

		email.focus()

		return false

	}

	if(checkOwnRule()==false){

		return false

	}

	return true

 }

