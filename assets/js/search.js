// JavaScript Document

// Set field to update page on change
var searchField = document.getElementById("search-field");
searchField.addEventListener("keyup", filterResults);



function filterResults (e) {
	
	// console.log(e.target.value);
	var searchString = e.target.value;
	
	// Get all the table rows (this doesn't work outside of the function for some reason)
	var rows = document.querySelectorAll("tr");
	
	// Highlight every other row
	var alt = false;
	
	// Start at 1 so we skip the header row
	for (var i=1; i<rows.length; i++) {
		
		var filtered = true; // Assume we're going to filter the row
		if ((rows[i].cells[0].innerHTML.toLowerCase().includes(searchString)) ||
		    (rows[i].cells[1].innerHTML.toLowerCase().includes(searchString)) ||
			(rows[i].cells[2].innerHTML.toLowerCase().includes(searchString)) ||
			(rows[i].cells[3].innerHTML.toLowerCase().includes(searchString))) {
				filtered = false;  // We found a match.  Don't filter it.
			}
		
		// Apply filter and alt classes
		if (filtered == true) {
			rows[i].classList.add("filtered");
			rows[i].classList.remove("alt");
		} else {
			rows[i].classList.remove("filtered");
			if (alt == true) {
				rows[i].classList.add("alt");
			} else {
				rows[i].classList.remove("alt");
			}
			alt = !alt;
		}
		
	}
	
}