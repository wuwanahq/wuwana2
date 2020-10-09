// ECMAScript 5
"use strict";

document.getElementById("C0").addEventListener("change", handleEventChangeFilterAll);
document.getElementById("R0").addEventListener("change", handleEventChangeFilterAll);

for (var i=1; i < 50; ++i)
{
	var checkbox1 = document.getElementById("C" + i);
	var checkbox2 = document.getElementById("R" + i);

	if (checkbox1 != null)
	{ checkbox1.addEventListener("change", handleEventChangeFilter); }

	if (checkbox2 != null)
	{ checkbox2.addEventListener("change", handleEventChangeFilter); }
}

function handleEventChangeFilter()
{
	if (getComputedStyle(this).getPropertyValue("display") == "none")
	{
		// Mobile
		var checkbox = document.getElementById(this.id.substr(0,1) + "0");
		checkbox.disabled = false;
		checkbox.checked = false;
	}
	else
	{
		// Desktop
		this.form.submit();
	}
}

function handleEventChangeFilterAll()
{
	var prefix = this.id.substr(0,1);

	for (var i=1; i < 50; ++i)
	{
		var checkbox = document.getElementById(prefix + i);

		if (checkbox != null)
		{ checkbox.checked = false; }
	}

	// Desktop only
	if (getComputedStyle(this).getPropertyValue("display") != "none")
	{ this.form.submit(); }
}