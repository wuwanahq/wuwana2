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