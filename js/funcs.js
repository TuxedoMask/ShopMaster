//Funcs.js

//Function used to validate that appropriate values were entered into the
//shipping information form
function validateShip(form)
 {
	errors = new Array();
	if(form.fname.value.length == 0) {
		errors.push('Please enter a first name');
	}
	if(form.lname.value.length == 0) {
		errors.push('Please enter a last name');
	}
	phone = form.phone.value.replace(/[^0-9]/g, '');
	if(phone.length != 10)
	{
		errors.push('Invalid phone number');
	}
	if(form.address.value.length == 0) {
		errors.push('Please enter the address');
	}
	if(form.city.value.length == 0) {
		errors.push('Please enter your city');
	}
	if(form.zip.value.length != 5) {
		errors.push('Please enter a valid zip code');
	}
	else
	{
		var zipRegex = /^\d+$/;
		if (!zipRegex.test(form.zip.value))
		{
			errors.push('Please enter a valid zip code');
		}
	}
	//do other checks on other form fields
	if(errors.length > 0) {
		alert(errors.join('\n'));
		return false;
	}
	return true;
}
//Function used to validate that appropriate values were entered into the
//billing information form
function validateBill(form)
{
	errors = new Array();
	if(form.fname.value.length == 0) {
		errors.push('Please enter a first name');
	}
	if(form.lname.value.length == 0) {
		errors.push('Please enter a last name');
	}
	phone = form.phone.value.replace(/[^0-9]/g, '');
	if(phone.length != 10)
	{
		errors.push('Invalid phone number');
	}
	if(form.address.value.length == 0) {
		errors.push('Please enter the address');
	}
	if(form.city.value.length == 0) {
		errors.push('Please enter your city');
	}
	if(form.zip.value.length != 5) {
		errors.push('Please enter a valid zip code');
	}
	else
	{
		var zipRegex = /^\d+$/;
		if (!zipRegex.test(form.zip.value))
		{
			errors.push('Please enter a valid zip code');
		}
	}
	if(form.card.value.length < 12 || form.card.value.length > 19)
	{
		errors.push('Invalid credit card number length');
	}
	else
	{	var cardRegex = /^[0-9]\d*$/
		if (!cardRegex.test(form.card.value))
		{
			errors.push('Invalid credit card number');
		}
	}
	if(form.cardname.value.length == 0) {
		errors.push('Please enter the name of the Credit Card holder');
	}
	//do other checks on other form fields
	if(errors.length > 0) {
		alert(errors.join('\n'));
		return false;
	}
	return true;

}
//Function used to only allow numeric keys to be entered into a textbox
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;

       return true;
}