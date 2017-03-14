function LoginPageValidation() {
	var x = document.forms["Login"]["username"].value;
	if (x == "") {
		alert("Name must be filled out");
		return false;
	}
	var x = document.forms["Login"]["pwd"].value;
	if (x == "") {
		alert("Password cannot be empty");
		return false;
	}	
	return true;
}