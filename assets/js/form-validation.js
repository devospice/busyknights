// JavaScript Document

/* 
RevHealth Form Validation Script 

--== Set Up ==--
1. 
Include this script on any page with a form.  Add the following code to the <form> element:
onSubmit="return validateForm(this);"

Also add a "novalidate" attribute to prevent the default browser validation.

Example:
<form id="some-form" onSubmit="return validateForm(this);" novalidate>

2. 
Add an "action" attribute to the <form> element as per usual to point to your form handler script.

3. Add a hidden input named "successCallback" and set its value to the name of a function that will run after your form successfully submits.

Example:
<input type="hidden" name="successCallback" value="showThankYou">

4.
Add a "required" attribute to any form elements that are required.

5.
For further validation add the attribute "data-validate" with the name of the validation that needs to be done.  

Example:
<input type="email" name="email" placeholder="Email Address*" required data-validate="email">

This will run the function validate_email() and check the value supplied.  Note that elements do not have to have the "required" attribute for further validation.

The following values for the "data-validate" attribute are currently supported:
email

"phone" and "zip" are to come.

If you need custom validation on additional fields that aren't natively supported you can write your own validation script.  To do this add a "data-validate" attribute to the element with a custom value you define.

Example:
<input type="text" name="occupation" data-validate="occupation">

Then, create a function below named "validate_[data-validate-value]" where data-validate-value is the value you supplied above.

Example
function validate_occupation (theElement) {
	// Perform validation here
}

All validation functions are passed the DOM element that is being validated as theElement.  To get its value read theElement.value.

--== Error Displays ==--
1.
For each form element being validated add a <p> element below it with the ID "[element name]-error".  This element should have the class "form-error" which would be styled appropriately for the site but be set to "display:none" by default.  For example, if the element's name being validated is "firstname" the code would be:
<p class="form-error" id="firstname-error">Please enter your first name.</p>

This element must be directly next to the element it's referring to so that it can be targeted with the ".error + p" selector.

2.
Create a CSS class called ".error" for styling fields that have errors.  Style it according to the design of the site.  This class will be added by the validation script when an error is detected.

Example:
.error {
	border: 2px solid #b61d24 !important;
}
.error + p {
	display: block;
}

p.form-error {
	font-family: arial;
	font-size: 12px;
	color: red;
	display: none;
}


--== Submitting the Form ==--
1.
Once all the validation is complete the values are packaged up and sent via an AJAX call to the script you defined in your <form>'s "action" attribute.

2. 
After the form is submitted the function you specified in the hidden input "successCallback" is called.  You will need to define this function either in this or another script.

*/

function showReportResult (response) {

	console.log(response);
	
	var msg = JSON.parse(response);
	
	var res = document.getElementById("report-result");
	res.innerHTML += msg.message;
	
}



// Called after the form submits.  Update this function to suit your needs for the site.
function showThankYou () {
	
	// alert("Thank you for your request. Someone will contact you shortly.");
	document.location = "/contact/thank-you";
	
}


/* 
--== validateForm(theForm) ==--
Validates the supplied form.  Always returns false so the script can be submitted via AJAX. 
*/
function validateForm (theForm) {
	
	var allOK = true;
	
	// Check each element in the form.
	for (var i=0; i<theForm.elements.length; i++) {
		
		thisElement = theForm.elements[i];
		var elementOK = true; // Start by assuming everything is OK
		
		// Check to see if this element is required
		if (thisElement.hasAttribute("required")) {
			var filledIn = isRequiredElementFilledIn(thisElement);
			if (filledIn == false) {
				elementOK = false;
			} 
		}
		
		// Check to see if this element has any special requirements
		if (thisElement.hasAttribute("data-validate")) {
			if (thisElement.value != "") {
				var functionName = "validate_" + thisElement.dataset.validate;
				console.log("function name: ", functionName);
				var valid = window[functionName](thisElement);
				if (valid == false) {
					elementOK = false;
				}
			}
		}
		
		// Check for Google's Captcha response
		if (thisElement.name == "g-recaptcha-response") {
			var notARobot = validateCaptcha(thisElement);
			if (notARobot == false) {
				elementOK = false;
			} 
		}
		
		// Show or hide the errors for this element
		if (elementOK == false) {
			allOK = false;
			showErrorForElement(thisElement);
		} else {
			removeErrorForElement(thisElement);
		}
		
	}

		
	// If properly submitted:
	if (allOK == true) {
		
		/* INSERT AJAX CODE TO SUBMIT FORM HERE */
		var newFormData = new FormData();
		var callback = theForm.successCallback.value;
		
		// Add each element to the form data
		for (var i=0; i<theForm.elements.length; i++) {
			
			thisElement = theForm.elements[i];

      if (thisElement.type == 'radio') {
        if (thisElement.checked) {
          newFormData.append(thisElement.name, thisElement.value);
        }
      } else {
        newFormData.append(thisElement.name, thisElement.value);
      }
			
		}
	
		var chAJAX = create_ajax();
		// console.log("posting to: ", theForm.action);
		chAJAX.open("POST", theForm.action, true);
		chAJAX.send(newFormData);
		
		chAJAX.onreadystatechange = function (e) {
			if (chAJAX.readyState == 4) {
				console.log("Form submitted:", chAJAX.responseText);
				// showThankYou();
				window[callback](chAJAX.responseText);
			}
		};

	} else {
		
		// Scroll the first error element into view
		var el = document.querySelector(".error");
		el.scrollIntoView({behavior: "smooth", block: "start"});	
		
	}
	
	return false;
	
}


/* Validation Function */

// Checks the value of the given element for any content
function isRequiredElementFilledIn (theElement) {
		
	if (theElement.value == "") {
		return false;
	} else {
		return true;
	}
	
}

// Checks the value of the email address against a regex expression for valid responses
function validate_email (theElement) {
	
	var isValid = testEmail(theElement.value);
	return isValid;
	
}

function validate_phone (theElement) {
	
	var isNum = isNumeric(theElement.value);
	return isNum;
	
}


// Adds a class named "error" to the provided element.
function showErrorForElement (theElement) {
	
	theElement.classList.add("error");
	
	if (theElement.name == "g-recaptcha-response") {
		var captchaBox = theElement.parentElement;
		captchaBox.classList.add("error");
	}

	
}

// Removes the "error" class from the provided element.
function removeErrorForElement (theElement) {
	
	theElement.classList.remove("error");

	if (theElement.name == "g-recaptcha-response") {
		var captchaBox = theElement.parentElement;
		captchaBox.classList.remove("error");
	}
	
}


// Validates the Google reCAPTCHA element.  Currently only checks for a value returned by Google.
// In the future this should properly validate using Google's API.
function validateCaptcha (theElement) {
	
	// console.log("Checking captcha", theElement.validity.valid);
	
	if (theElement.value == "") {
		return false;
	} else {
		return true;
	}
	
}




/* Utility Functions */
function testEmail (elementValue) { 
   var emailPattern = /^[a-zA-Z0-9.+'!#$&*//=?^`{|}~_-]+@[a-zA-Z0-9.+'!#$&*//=?^`{|}~-]+\.[a-zA-Z]{2,4}$/;
   return emailPattern.test(elementValue); 
} 


function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n) && (n>0);
}

/* Creates an AJAX object */
function create_ajax () 
{
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest(); // code for IE7+, Firefox, Chrome, Opera, Safari
	} else {
	  	var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); // code for IE6, IE5
	}
	
	return xmlhttp;
	
}
