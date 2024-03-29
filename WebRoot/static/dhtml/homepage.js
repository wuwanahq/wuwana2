// ECMAScript 5
"use strict";

document.getElementById("R0").addEventListener("change", handleEventChangeFilterAll);
var checkboxes = document.querySelectorAll('dd input[type=checkbox]');

for (var i=1; i < checkboxes.length; ++i)
{ checkboxes[i].addEventListener("change", handleEventChangeFilter); }

function handleEventChangeFilter()
{
	if (getComputedStyle(this).getPropertyValue("display") == "none")  // Mobile
	{
		var checkbox = document.getElementById("R0");
		checkbox.disabled = false;
		checkbox.checked = false;
	}
	else  // Desktop
	{
		this.form.submit();
	}
}

function handleEventChangeFilterAll()
{
	var checkboxes = document.querySelectorAll('dd input[type=checkbox]');

	for (var i=1; i < checkboxes.length; ++i)
	{ checkboxes[i].checked = false; }

	// Auto submit on desktop only
	if (getComputedStyle(this).getPropertyValue("display") != "none")
	{ this.form.submit(); }
}

/**
 * Function to check whether there are more companies available for viewing.
 * If true, the companies are displayed otherwise the 'view more' element is hidden
 */
function isPossibleToViewMore(companyCount,selectedRegions)
{
	var pageCountElement = document.getElementById("page-count");
	var pageCount = pageCountElement.value;

	if (companyCount > (pageCount * 8)) {
		//view more companies
		viewMoreCompanies(pageCount,selectedRegions);
		pageCount++; //increase value of page count
		pageCountElement.value = pageCount;	//set increased value to pageCountElement
	} else {
		//hide view more button
		document.getElementById("view-more-button").style.display = 'none';
	}
}

/**
 * Function to display more companies
 * Sends AJAX request, which returns a response containing the companies(html)
 * @param pageCount
 * @param selectedRegions
 */
function viewMoreCompanies(pageCount,selectedRegions)
{
	var companyListDiv = document.getElementById("companies-list");	//div element where companies list is contained
	var form = new FormData();
	var xhr = new XMLHttpRequest();

	form.append("pageCount", pageCount);
	form.append("selectedRegions", JSON.stringify(selectedRegions));

	var index = location.search.indexOf("&");

	if(index > 8)
	{ form.append("search", location.search.substring(8, index)) }
	else
	{ form.append("search", location.search.substring(8)); }

	xhr.open("post", "/ajax/pagination.php", true);

	xhr.onload = function () {
		companyListDiv.insertAdjacentHTML("beforeend", xhr.responseText);
	};

	xhr.send(form);
}

window.addEventListener("resize", () => 
{
	var filter = document.querySelector("#filter");
	var body = document.body.style;

	if (filter)
	{
		filter.style.visibility = "hidden";
		body.overflow = "auto";
	}
})

// Show filter
function toggleFilter()
{
	var filter = document.querySelector("#filter");
	var body = document.body.style;

	if (filter.style.visibility == "visible") 
	{
		filter.style.visibility = "hidden";
		body.overflow = "auto";
		return;
	}
	filter.style.visibility = "visible";
	body.overflow = "hidden";
}
