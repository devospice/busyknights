// JavaScript Document

function validateRegistrationForm () {
	
	var allOK = true;
	var errorText = "";
	
	var theForm = document.getElementById("registration-form");
	
	if (theForm.message.value != "") {
		// Spambot filled out the honey pot
		return false;
	}
	
	if (theForm.email.value == "") {
		allOK = false;
		theForm.email.classList = "error";
		errorText = errorText + "Please fill in a valid email address.<br>";
	} else {
		theForm.email.classList = "";
	}
	
	if (theForm.password.value == "") {
		allOK = false;
		theForm.password.classList = "error";
		errorText = errorText + "Your password can not be blank.<br>";
	} else {
		theForm.password.classList = "";
	}
	
	if (theForm.company.value == "") {
		allOK = false;
		theForm.company.classList = "error";
		errorText = errorText + "Please enter your company name.<br>";
	} else {
		theForm.company.classList = "";
	}
	
	var pErr = document.getElementById("registration-error");
	if (allOK == true) {
		pErr.innerHTML = "";
	} else {
		pErr.innerHTML = errorText;
	}
	
	return allOK;
	
}

function validateLoginForm () {
	
	var allOK = true;
	var errorText = "";
	
	var theForm = document.getElementById("login-form");
	
	if (theForm.message.value != "") {
		// Spambot filled out the honey pot
		return false;
	}
	
	if (theForm.email.value == "") {
		allOK = false;
		theForm.email.classList = "error";
		errorText = errorText + "Please fill in a valid email address.<br>";
	} else {
		theForm.email.classList = "";
	}
	
	if (theForm.password.value == "") {
		allOK = false;
		theForm.password.classList = "error";
		errorText = errorText + "Please enter your password.<br>";
	} else {
		theForm.password.classList = "";
	}
		
	var pErr = document.getElementById("login-error");
	if (allOK == true) {
		pErr.innerHTML = "";
	} else {
		pErr.innerHTML = errorText;
	}
	
	return allOK;
	
}

// Adds a new entry to the Transactions form
function addEntry() {
	
	var container = document.getElementById("transaction-entries");
	
	// console.log("currently " + container.childElementCount + " entries.");
	
	var lastEntry = container.children[container.children.length-1];
	var newEntry = lastEntry.cloneNode(true);
	
	container.appendChild(newEntry);
	
	resetEntryNums();
	
	// container.innerHTML = container.innerHTML + 
	
}


// Renumbers all the entries in the Transactions form to ensure they are all correct.
function resetEntryNums() {
	
	var container = document.getElementById("transaction-entries");
	var numEntries = container.childElementCount;
	
	for (var i=0; i<numEntries; i++) {
		
		var num = i + 1;
		
		// Set Account label and select list name
		container.children[i].children[0].children[0].htmlFor = "account-" + num;
		container.children[i].children[0].children[1].name = "account-" + num;
		container.children[i].children[0].children[2].setAttribute("onclick", "javascript: openNewAccountOverlay("+num+");");

		// Set debit label and input name
		container.children[i].children[1].children[0].htmlFor = "debit-" + num;
		container.children[i].children[1].children[1].name = "debit-" + num;
	
		// Set credit label and input name
		container.children[i].children[2].children[0].htmlFor = "credit-" + num;
		container.children[i].children[2].children[1].name = "credit-" + num;
		
		// Fix close button
		container.children[i].children[3].className = "close-box entry-" + num;
		container.children[i].children[3].setAttribute("onclick", "javascript: deleteEntry("+num+");");
		
	}
	
}


function deleteEntry (which) {
	
	// Remove the selected node
	var container = document.getElementById("transaction-entries");
	var targetNode = which - 1;
	
	container.removeChild(container.children[targetNode]);
	
	// Renumber the remaining nodes
	resetEntryNums();
	
}


// Adds a new entry to the Subscription Distribution form
function addArtistShare() {
	
	var container = document.getElementById("transaction-entries");
	
	// console.log("currently " + container.childElementCount + " entries.");
	
	var lastEntry = container.children[container.children.length-1];
	var newEntry = lastEntry.cloneNode(true);
	
	container.appendChild(newEntry);
	
	resetArtistShareNums();
	
	// container.innerHTML = container.innerHTML + 
	
}

// Renumbers all the entries in the Subscription Distribution form to ensure they are all correct.
function resetArtistShareNums() {
	
	var container = document.getElementById("transaction-entries");
	var numEntries = container.childElementCount;
	
	for (var i=0; i<numEntries; i++) {
		
		var num = i + 1;
		
		// Set Account label and select list name
		container.children[i].children[0].children[0].htmlFor = "account-" + num;
		container.children[i].children[0].children[1].name = "account-" + num;
		container.children[i].children[0].children[2].setAttribute("onclick", "javascript: openNewAccountOverlay("+num+");");

		// Set number of shares label and input name
		container.children[i].children[1].children[0].htmlFor = "numshares-" + num;
		container.children[i].children[1].children[1].name = "numshares-" + num;
			
		// Fix close button
		container.children[i].children[2].className = "close-box entry-" + num;
		container.children[i].children[2].setAttribute("onclick", "javascript: deleteArtistShare("+num+");");
		
	}
	
}


function deleteArtistShare (which) {
	
	// Remove the selected node
	var container = document.getElementById("transaction-entries");
	var targetNode = which - 1;
	
	container.removeChild(container.children[targetNode]);
	
	// Renumber the remaining nodes
	resetArtistShareNums();
	
}





function updateStartingBalance (theForm) {
	
	
	var newBalance = theForm["starting_balance"].value;
	console.log(newBalance);
	
	var accountId = theForm.id;
	console.log(accountId);
	
	var formData = new FormData();	
	formData.append('id', accountId);
	formData.append('starting_balance', newBalance);
	
	var fAJAX = create_ajax();
	fAJAX.open("POST", "/ajax/update-starting-balances", true);
	fAJAX.send(formData);
	
	fAJAX.onreadystatechange = function (e) {
		if (fAJAX.readyState == 4) {
			
			console.log(fAJAX.responseText);
			// var response = JSON.parse(fAJAX.responseText);
			
			// Refresh page to update table
			// location.reload();
			// console.log(response.response);
			theForm["starting_balance"].classList.add("success");
			setTimeout(function() {
				theForm["starting_balance"].classList.remove("success");
				theForm["starting_balance"].blur();
			}, 100)
			
		}
	};
	
	return false;
	
}


function editPreallocation (id, percent, account) {
	console.log(id, percent, account);
	
	var editForm = document.getElementById("edit-pre-allocation-form");
	editForm[0].value = id;
	editForm.percent.value = percent;
	editForm.account.value = account;
	
	var overlay = document.getElementById("edit-pre-allocation-overlay");
	overlay.classList.add("active");
	
}

var artistCount = 1;

function AddRoyaltyArtist () {
	
	var theForm = document.getElementById("calculate-royalties-form");
	var theTable = document.getElementById("artist-list-table");
	
	var row = theTable.insertRow();
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	
	cell1.innerHTML = "<input type='text' name='artist-"+artistCount+"' value='" + theForm["artist"].value + "' disabled>";
	cell2.innerHTML = "<input type='text' name='tracks-"+artistCount+"' value='" + theForm["number_of_tracks"].value + "' disabled>";
	
	
	cell3.classList.add("delete");
	cell3.innerHTML = "<a href=\"javascript:deleteRoyaltyArtist("+artistCount+");\">/</a>"
	
	
	/* ELEMENTS ARE NOT BEING ADDED TO THE FORM.  ADD MANUALLY */
	
	
	
	// console.log("adding artist", theForm["artist"].value, theForm["number_of_tracks"].value);
	artistCount++;
	
}


function deleteRoyaltyArtist (row) {
	console.log(row);
}