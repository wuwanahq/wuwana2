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

// Navbar and Filter on mobile
const url = window.location.href;
const body = document.body;
const icon = document.getElementById("menu-icon");
const navbar = document.querySelector(".navbar-box");
const bkg = document.querySelector(".navbar-background");
const filter = document.getElementById("filter");

// Show filter on mobile
function showFilter()
{
	icon.src = "/static/icon/close.svg";
	filter.style.visibility = "visible";
	body.style.overflow = "hidden";
}

// Show menu on mobile
function showNavbar()
{
	if (url.includes('/admin'))
	{
		if (navbar.style.visibility == "visible")
		{
			navbar.style.visibility = "hidden";
			navbar.style.transform = "translateX(-110vw)";
			bkg.style.display = "none";
			icon.src = "/static/icon/menu.svg";
			body.style.overflow = "auto";
		}
		else
		{
			navbar.style.visibility = "visible";
			navbar.style.transform = "translatex(0)";
			bkg.style.display = "block";
			icon.src = "/static/icon/close.svg";
			body.style.overflow = "hidden";
		}
	}
	else 
	{
		if (filter.style.visibility == "visible")
		{
			icon.src = "/static/icon/menu.svg";
			filter.style.visibility = "hidden";
			body.style.overflow = "auto";
		}
		else if (navbar.style.visibility == "visible")
		{
			navbar.style.visibility = "hidden";
			navbar.style.transform = "translateX(-110vw)";
			bkg.style.display = "none";
			icon.src = "/static/icon/menu.svg";
			body.style.overflow = "auto";
		}
		else
		{
			navbar.style.visibility = "visible";
			navbar.style.transform = "translatex(0)";
			bkg.style.display = "block";
			icon.src = "/static/icon/close.svg";
			body.style.overflow = "hidden";
		}
	}
}

// Go back to previous page

function goBack() {
	const referrer = document.referrer;

	if (referrer.includes("wuwana") || referrer.includes("localhost") == true)
	{
		window.history.back();
	} 
	else
	{
		window.location = '/';
	}
}

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

// To reset elements to default
window.addEventListener("resize", () => 
{
	const logo = document.getElementById("logo");
	bkg.style.display = "none";
	body.style.overflow = "auto";

	if (window.innerWidth > 800) 
	{
		console.log("desktop");
		navbar.style.visibility = "visible";
		navbar.style.transform = "translateX(0px)";
		logo.src = "/static/logo/website.svg";
	}
	else if (window.innerWidth < 800 && window.innerWidth > 500) 
	{
		console.log("tablet");
		navbar.style.visibility = "hidden";
		icon.src = "/static/icon/menu.svg";
		logo.src = "/static/logo/website.svg";
	}
	else if (window.innerWidth < 500) 
	{
		console.log("mobile");
		navbar.style.visibility = "hidden";
		icon.src = "/static/icon/menu.svg";
		logo.src = "/static/logo/w-logo.svg";
	}

	if (url.includes('/admin/') == false) {
		if (window.innerWidth > 800) {
			filter.style.visibility = "visible";
		} else {
			filter.style.visibility = "hidden";
		}
	}
})

window.addEventListener("load", () =>
{
	if (window.innerWidth > 500) 
	{
		logo.src = "/static/logo/website.svg";
	}
	else if (window.innerWidth < 500) 
	{
		logo.src = "/static/logo/w-logo.svg";
	}
})