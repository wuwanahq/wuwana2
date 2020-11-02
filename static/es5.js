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

// Show menu
function showMenu()
{
	var div = document.getElementById("menu");
	var img = document.getElementById("TestImg");
	var body = document.body;

	if (getComputedStyle(div).getPropertyValue("display") == "none")
	{
		div.style.display = "flex";
		img.src = "static/icon/close.svg";
		body.style.overflow = "hidden";
	}
	else
	{
		div.style.display = "none";
		img.src = "static/icon/menu.svg";
		body.style.overflow = "auto";
	}
}

// To fix bug of filter menu not appearing after table view

let menu = document.getElementById("menu");

window.addEventListener("resize", () => {
	if (window.innerWidth > 800)
	{
		menu.style.display = "block";
	}
	else 
	{
		menu.style.display = "none";
	}

});

// Hide & unhide

function hide()
{
	var div = document.getElementById("AboutUs");
	var img = document.getElementById ("ToggleAboutUsImg");
	var label = document.getElementById ("ToggleAboutUsLabel");

	if (getComputedStyle(div).getPropertyValue("display") == "none")
	{
		div.style.display = "flex";
		img.src = "static/icon/chevron-up.svg";
		label.innerText = "Ver menos";
	}
	else
	{
		div.style.display = "none";
		img.src = "static/icon/chevron-down.svg";
		label.innerText = "Ver mas";
	}
}

// To fix bug of about us not appearing after table view

let aboutUS = document.getElementById("AboutUs");
let img = document.getElementById ("ToggleAboutUsImg");
let label = document.getElementById ("ToggleAboutUsLabel");

window.addEventListener("resize", () => {
	if (window.innerWidth > 800)
	{
		aboutUS.style.display = "flex";
	}
	else 
	{
		aboutUS.style.display = "none";
		img.src = "static/icon/chevron-down.svg";
		label.innerText = "Ver mas";
	}

});

// Back to top button
let toTop = document.getElementById("toTop");

window.addEventListener("scroll", () => {
	if (window.pageYOffset > 100)
	{
		toTop.style.opacity = 1;
		toTop.style.visibility = "visible";
	}
	else
	{
		toTop.style.opacity = 0;
		toTop.style.visibility = "hidden";
	}
});

