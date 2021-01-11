// ECMAScript 5
"use strict";

function askEmail()
{
	var email = document.getElementById("email").value;
	var form = new FormData();
	var xhr = new XMLHttpRequest();

	form.append("email", email);

	xhr.open("post", "/ajax/email/index.php");
	xhr.send(form);
}

// Show language popup on mobile
function showLang()
{
	var divLang = document.getElementById("popup-lang");
	var body = document.body;

	if (getComputedStyle(divLang).getPropertyValue("display") == "none")
	{
		divLang.style.display = "flex";
	}
	else
	{
		divLang.style.display = "none";
	}
}

// Show menu on mobile
function showMenu()
{
	var div = document.getElementById("menu");
	var divLang = document.getElementById("popup-lang");
	var img = document.getElementById("menu-icon");
	var body = document.body;

	if (getComputedStyle(div).getPropertyValue("display") == "none")
	{
		if (divLang.style.display == "flex")
		{
			divLang.style.display = "none";
			div.style.display = "flex";
			img.src = "static/icon/close.svg";
			body.style.overflow = "hidden";
		}
		else
		{
			div.style.display = "flex";
			img.src = "static/icon/close.svg";
			body.style.overflow = "hidden";
		}
	}
	else
	{
		div.style.display = "none";
		img.src = "static/icon/menu.svg";
		body.style.overflow = "auto";
	}
}

// To fix bug of filter menu not appearing after table view

var menu = document.getElementById("menu");

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

// Back to top button
var lastScrollTop = 0;

window.addEventListener("scroll", function(){
	var st = window.pageYOffset || document.documentElement.scrollTop; // Credits: "https://github.com/qeremy/so/blob/master/so.dom.js#L426"
	var toTop = document.getElementById("toTop");

	if (st > lastScrollTop){
		toTop.style.opacity = 0;
		toTop.style.visibility = "hidden";
	}
	else if (st < lastScrollTop && window.pageYOffset > 500)
	{
		toTop.style.opacity = 1;
		toTop.style.visibility = "visible"
	}
	else
	{
		toTop.style.opacity = 0;
		toTop.style.visibility = "hidden";
	}

   lastScrollTop = st <= 0 ? 0 : st; // For Mobile or negative scrolling
}, false);

// --------------- Not in use -------------

// // Hide & unhide

// function hide()
// {
// 	var div = document.getElementById("AboutUs");
// 	var img = document.getElementById ("ToggleAboutUsImg");
// 	var label = document.getElementById ("ToggleAboutUsLabel");

// 	if (getComputedStyle(div).getPropertyValue("display") == "none")
// 	{
// 		div.style.display = "flex";
// 		img.src = "static/icon/chevron-up.svg";
// 		label.innerText = "Ver menos";
// 	}
// 	else
// 	{
// 		div.style.display = "none";
// 		img.src = "static/icon/chevron-down.svg";
// 		label.innerText = "Ver mas";
// 	}
// }

// // To fix bug of about us not appearing after table view

// let aboutUS = document.getElementById("AboutUs");
// let img = document.getElementById ("ToggleAboutUsImg");
// let label = document.getElementById ("ToggleAboutUsLabel");

// window.addEventListener("resize", () => {
// 	if (window.innerWidth > 800)
// 	{
// 		aboutUS.style.display = "flex";
// 	}
// 	else
// 	{
// 		aboutUS.style.display = "none";
// 		img.src = "static/icon/chevron-down.svg";
// 		label.innerText = "Ver mas";
// 	}

// });