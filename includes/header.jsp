<div id="headerwrap">
	<div id="weather">
	<jsp:useBean id="time" scope="session" class="com.hotspot.general.MyTime"></jsp:useBean>
	<span class="timeinfo"><% out.print(time.getTime());%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><% out.print(time.getWeather());%> 
	</div>
	<!-- <div id="newsletter"><a href="#">E-Newsletter</a> | <a href="#">Language <small>&#9660;</small></a></div>  -->
	<div id="loginbox">
	<%
    Object user_name =  session.getAttribute(com.hotspot.interceptor.AuthenticationInterceptor.USER_Name_SESSION_KEY);

	//out.println("username = "+username);
		if(user_name == null || ((String)user_name).equalsIgnoreCase(""))
		{
			%>
			<a href="app/login.action">Sign in</a> | <a href="app/register.action">Sign Up</a></div>
			<%
		}else{
			%>
			Welcome <%out.print((String)user_name);%> | <a href="app/logout.action">Sign Out</a></div>
			<%			
		}
	%>
	
</div>