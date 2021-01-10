// ECMAScript 5
"use strict";

document.getElementById("R0").addEventListener("change", handleEventChangeFilterAll);
var checkboxes = document.querySelectorAll('dd input[type=checkbox]');

for (var i=1; i < checkboxes.length; ++i)
{ checkboxes[i].addEventListener("change", handleEventChangeFilter); }

function handleEventChangeFilter()
{
	if (getComputedStyle(this).getPropertyValue("display") == "none")
	{ //Mobile
		let changeUrl = function()
		{
				let region_url = ''
				let region_array = document.querySelectorAll('input[name]')
				region_array.forEach((elem) => {
					   if(elem.checked && elem.name != 'region') {
							region_url += elem.name + '=on&'}
			})
			window.location = '?' + region_url.slice(0, -1)
		}

		let submit_button = document.getElementById('apply-filter')

		submit_button.addEventListener('click', changeUrl)
	}
	else
	{
		// Desktop
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