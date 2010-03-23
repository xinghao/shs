<div id="headerwrap">
	<div id="weather">

		<span class="timeinfo"><?=Common::getTimeByWeekDayMonthDayMonthYearHourMinute()?></span><!-- weather -->
	</div>
	<!-- <div id="newsletter"><a href="#">E-Newsletter</a> | <a href="#">Language <small>&#9660;</small></a></div>  -->
	<div id="loginbox">
		<a href="/UCP/index.php/Authentication">Sign in</a> | <a href="/UCP/index.php/SignUp/newClient/open">Sign Up</a>
	</div>
	<div class="clear"></div>
	<?php /*
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
	*/?>
</div>