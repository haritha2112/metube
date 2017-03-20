function RegisterPageValidation() {
	if( document.Register.fname.value == "" )
	{
		alert( "Please provide your First Name!" );
		document.Register.fname.focus() ;
		return false;
   }
	if( document.Register.lname.value == "" )
	{
		alert( "Please provide your Last Name!" );
		document.Register.lname.focus() ;
		return false;
	}
	if( document.Register.uname.value == "" )
	{
		alert( "Please provide a UserName!" );
		document.Register.uname.focus() ;
		return false;
	}
	if( document.Register.uname.value == "" )
	{
		alert( "Please provide a UserName!" );
		document.Register.uname.focus() ;
		return false;
	}
	var unameLen = document.Register.uname.value.length;
	if(unameLen<= 3 || unameLen >= 10)
	{
		alert("Username should be within 3 to 10 characters!")
		return false;
	}
	var email = document.Register.emailid.value;
	at = email.indexOf("@");
	dot = email.lastIndexOf(".");
	if(at<1 || dot<at+2 || dot+2>=email.length)
	{
        alert("Not a valid e-mail address");
        return false;
	}
	if( document.Register.pwd.value == "" )
	{
		alert( "Please provide a Password!" );
		document.Register.pwd.focus() ;
		return false;
	}
	var pwdLen = document.Register.pwd.value.length;
	if( pwdLen <= 3 || pwdLen >= 10 )
	{
		alert("Password should be within 3 to 10 Characters!");
		return false;
	}
	if( document.Register.cpwd.value == "" )
	{
		alert( "Please retype your password!" );
		document.Register.cpwd.focus() ;
		return false;
	}
	if( document.Register.pwd.value != document.Register.cpwd.value )
	{
		alert( "Passwords do not match!" );
		return false;
	}
	if ( ( Register.gender[0].checked == false ) && ( Register.gender[1].checked == false ) )
	{
		alert ( "Please choose your Gender" );
		return false;
	}
}
  