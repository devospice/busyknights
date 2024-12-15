// JavaScript Document

window.onload = function() {
	
	setUpToggles();
    setUpScrollEvent();
	
};


function setUpScrollEvent () {
    
    window.addEventListener("scroll", showHideSubnav);
    
}


function showHideSubnav () {
    
    var mainNav = document.getElementById("subnav-main");
    var lockNav = document.getElementById("subnav-locked");
    
	if (mainNav) {
		if (mainNav.getBoundingClientRect().top < 20) {
			lockNav.classList.add("active");
			mainNav.classList.add("hidden");
		} else {
			lockNav.classList.remove("active");
			mainNav.classList.remove("hidden");
		}
	}
        
}


function setUpToggles () {
	
	var toggles = document.querySelectorAll(".toggle-select");
	
	for (var i=0; i<toggles.length; i++) {
		var toggle = toggles[i];
		console.log(toggle);
		toggle.addEventListener("change", toggleDivs);
	}
	
}

function toggleDivs () {
	
	// Hide all the other divs
	var group = document.querySelectorAll(".toggle-group");
	for (var i=0; i<group.length; i++) {
		group[i].style.display = "none";
	}
	
	// var targetDivID = e.target.options[e.target.options.selectedIndex].dataset.toggle;
	var selectList = document.getElementById("payment-method-select");
	var targetDivID = selectList.options[selectList.options.selectedIndex].dataset.toggle;
	targetDiv = document.getElementById(targetDivID);
	targetDiv.style.display = "block";
	
}

function deleteTransaction (entryID) {

	var formData = new FormData();	
	formData.append('id', entryID);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/delete-transaction", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			// location.reload();  // This causes any just-submitted forms to resubmit
			
			// This always redirects to the transactions page, which isn't always what we want.
			// document.location = "/transactions?x=" + Date.now();
			
			// This should refresh the current page without resubmitting any forms
			document.location = document.location.pathname + "/" + Date.now();
			
			// console.log(response.response);
			
		}
	};
}

function deleteTemplate (templateId) {

	var formData = new FormData();	
	formData.append('id', templateId);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/delete-transaction-template", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			// location.reload();  // This causes any just-submitted forms to resubmit
			document.location = "/transactions/templates?x=" + Date.now();
			// console.log(response.response);
			
		}
	};
}

function deletePreallocation (allocID) {

	var formData = new FormData();	
	formData.append('id', allocID);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/delete-preallocation", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			location.reload();
			// console.log(response.response);
			
		}
	};
}

function deleteAccount (accountID) {

	var formData = new FormData();	
	formData.append('id', accountID);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/delete-account", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			location.reload();
			// console.log(response.response);
			
		}
	};
}

function addToNav (accountID) {

	var formData = new FormData();	
	formData.append('id', accountID);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/add-to-nav", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			location.reload();
			// console.log(response.response);
			
		}
	};
}

function removeFromNav (accountID) {

	var formData = new FormData();	
	formData.append('id', accountID);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/remove-from-nav", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			location.reload();
			// console.log(response.response);
			
		}
	};
}


function deleteCategory (categoryId) {

	var formData = new FormData();	
	formData.append('id', categoryId);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/delete-category", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			location.reload();
			// console.log(response.response);
			
		}
	};
}

function deleteContact (contactID) {

	var formData = new FormData();	
	formData.append('id', contactID);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/delete-contact", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			location.reload();
			// console.log(response.response);
			
		}
	};
}


function deleteCompany (companyID) {

	var formData = new FormData();	
	formData.append('id', companyID);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/delete-company	", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			location.reload();
			// console.log(response.response);
			
		}
	};
}


function deleteArtist (artistID) {

	var formData = new FormData();	
	formData.append('id', artistID);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/delete-artist	", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			location.reload();
			// console.log(response.response);
			
		}
	};
}



function deleteSaleItem (accountID) {

	var formData = new FormData();	
	formData.append('id', accountID);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/delete-sale-item", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			location.reload();
			// console.log(response.response);
			
		}
	};
}


function deleteRoyalty (royaltyID) {

	var formData = new FormData();	
	formData.append('id', royaltyID);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/delete-royalty", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			location.reload();
			// console.log(response.response);
			
		}
	};
	
}




function newInlineAccount (theForm, e) {

	// var theForm = document.getElementById("add-account-overlay-form");
	
	var formData = new FormData();	
	formData.append('name', theForm.name.value);
	formData.append('starting_balance', theForm.starting_balance.value);
	formData.append('contact', theForm.contact.value);
	formData.append('company', theForm.company.value);
	formData.append('type', theForm.type.value);
	formData.append('notes', theForm.notes.value);

	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/add-account", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Close the overlay
			closeOverlay("add-account-overlay");
			
			// Update the select list
			var overlayDiv = document.getElementById("add-account-overlay");
			var whichSelect = overlayDiv.dataset.selectlist;
			updateSelectList(whichSelect);
			
		}
	};	
}

function openNewAccountOverlay (counter) {
	
	var div = document.getElementById("add-account-overlay");
	div.dataset.selectlist = "account-" + counter;
	
	div.classList.add("active");
	
}

function openNewAllocationOverlay () {
	
	var div = document.getElementById("new-pre-allocation-overlay");	
	div.classList.add("active");
	
}


function openNewTransactionTemplateOverlay () {
	
	var div = document.getElementById("new-transaction-template-overlay");
		
	div.classList.add("active");
	
}



function closeOverlay (targetID) {
	console.log("close " + targetID);
	var div = document.getElementById(targetID);
	div.classList.remove("active");
	
}

function updateSelectList (selectID) {
	
	var formData = new FormData();	
	formData.append('selectID', selectID);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/update-account-select-list", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {

			console.log(fAJAX.responseText);
			
			var selectLists = document.getElementsByName(selectID);
			var selectList = selectLists[0];
			
			selectList.innerHTML = fAJAX.responseText;
			
		}
	};
}


function updateAccountCategories (theSelect) {
	
	var newType = theSelect.value;
	// console.log(newType);
	
	var formData = new FormData();	
	formData.append('newType', newType);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/get-account-type-values", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {

			console.log(fAJAX.responseText);
			
			var selectList = document.getElementById("account_category");
			selectList.innerHTML = fAJAX.responseText;
			
		}
	};

	
}


// Called when the user selects a template from the select list
function getValuesFromTemplate(theSelect) {
	
	// console.log("use template: " + theSelect.value);
	var formData = new FormData();	
	formData.append('id', theSelect.value);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/get-transaction-template", true);
	fAJAX.send(formData);
	// console.log("ajax sent to " + api);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			// console.log(fAJAX.responseText);
			
			var response = JSON.parse(fAJAX.responseText);
			console.log(response);
			
			setValuesToTemplate(response);
			
		}
	};
}

// Called when the Edit Template page loads with the given id
function getValuesFromTemplate2 (templateId) {
	
	var formData = new FormData();	
	formData.append('id', templateId);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/get-transaction-template", true);
	fAJAX.send(formData);
	// console.log("ajax sent to " + api);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			// console.log(fAJAX.responseText);
			
			var response = JSON.parse(fAJAX.responseText);
			console.log(response);
			
			setValuesToTemplate(response);
			
		}
	};
}


// Called after the values are retrieved from getValuesFromTemplate.
function setValuesToTemplate(template) {
	
	var theForm = document.getElementById("transaction-form");
	
	// Delete any extra entries already in the form
	var entriesContainer = document.getElementById("transaction-entries");
	if (entriesContainer.children.length > 2) {
		for (var j=entriesContainer.children.length; j>2; j--) {
			deleteEntry(j);
		}
	}
	
	// Set the transaction data
	theForm.notes.value = template["transaction"]["notes"];
	
	// Set the entries data
	if (template["entries"].length > 2) {
		for (var i=0; i<template["entries"].length - 2; i++) {
			addEntry();
		}
	}
	
	for (var i=0; i<template["entries"].length; i++) {
		
		var selectList = document.getElementsByName("account-"+template["entries"][i]["entry_num"])[0];
		selectList.value = template["entries"][i]["account"];

		var debit = document.getElementsByName("debit-"+template["entries"][i]["entry_num"])[0];
		debit.value = template["entries"][i]["debit"];

		var credit = document.getElementsByName("credit-"+template["entries"][i]["entry_num"])[0];
		credit.value = template["entries"][i]["credit"];
		
	}
	
}


// Toggles the row of entries in the Transactions table
function showThisRow (btn) {
	// console.log(btn.parentElement.parentElement);
	
	var parentRow = btn.parentElement.parentElement;
	
	parentRow.classList.toggle("active");
	showSiblingRow(parentRow);
	
}

function showSiblingRow (row) {
	
	var sib = row.nextSibling;
	
	if (sib.classList.contains("details")) {
		sib.classList.toggle("active");
		showSiblingRow(sib);
	}
	
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

/* AJAX CODE */
/*
var formData = new FormData();	
formData.append('key', value);
// repeat for each key/value needed

var fAJAX = create_ajax();
fAJAX.open("POST", URL, true);
fAJAX.send(formData);
// console.log("ajax sent to " + api);

fAJAX.onreadystatechange = function (e) {
	if (fAJAX.readyState == 4) {
		// console.log(fAJAX.responseText);
		
		var response = JSON.parse(fAJAX.responseText);
				
		// console.log(response.response);
		
	}
};
*/