// ECMAScript 5
"use strict";

/**
 * Functions that run automatically
 */

window.addEventListener("load", onLoad());
function onLoad()
{
	replaceMultipleBrokenImgs(); //replace broken image url links
}

window.addEventListener("resize", function() {
	console.log('rezising');
});


window.addEventListener("scroll", function() {
	backToTop(); //Back to top button
});

function sendEmail()
{
	var email = document.getElementById("email").value;
	var form = new FormData();
	var xhr = new XMLHttpRequest();

	form.append("email", email);

	xhr.open("post", "/ajax/email/send-code.php");
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

	if (referrer.includes("wuwana") || referrer.includes(":8000") == true)
	{
		window.history.back();
	} 
	else
	{
		window.location = '/';
	}
}

// To reset elements to default
window.addEventListener("resize", () => 
{
	bkg.style.display = "none";
	body.style.overflow = "auto";
	searchMobileClear(); //clear all search

	if (window.innerWidth > 800) 
	{
		navbar.style.visibility = "visible";
		navbar.style.transform = "translateX(0px)";
	}
	else if (window.innerWidth < 800 && window.innerWidth > 500) 
	{
		navbar.style.visibility = "hidden";
		icon.src = "/static/icon/menu.svg";
	}
	else if (window.innerWidth < 500) 
	{
		navbar.style.visibility = "hidden";
		icon.src = "/static/icon/menu.svg";
	}

	//In the homepage, change filter window to default
	if (window.location.pathname == '/') { 
		if (window.innerWidth > 800) {
			filter.style.visibility = "visible";
		} else {
			filter.style.visibility = "hidden";
		}
	}
})

// For the search
const search = document.getElementById("search");
const searchInput = document.getElementById("user-search");
const searchSuggestion = document.getElementById("search-suggestion");
const searchIcon = document.querySelectorAll("search-icon");

searchInput.onkeyup = (e) => {
	let userData = e.target.value; //user entered data
	let emptyArray = [];
	
	if (userData) {
		searchSuggestion.style.display = "block"; // Show suggestion box
		showSuggestions(emptyArray);
	}
	else 
	{
		searchSuggestion.style.display = "none";
	}
}

function showSuggestions(list){
    let listData;
	let userValue;

    if(!list.length)
	{
        userValue = searchInput.value;
        listData = '<a href="/?search=' + userValue + '"><li>'+ userValue +'</li></a><hr>';
    }
	else
	{
        listData = list.join('');
    }
    searchSuggestion.innerHTML = listData;
}

// Search Mobile
function searchMobile() {
	if (window.innerWidth < 500) {
		search.classList.add("search-fixed");
		body.style.overflow = "hidden";
		body.style.position = "fixed";
	}
}

function searchMobileClear() {
	searchInput.value = ""; // clear input value
	searchSuggestion.style.display = "none";
	search.classList.remove("search-fixed");
	body.style.overflow = "auto";
	body.style.position = "relative";
}

/**
 * Function to replace broken img url link
 * with random wuwana square logo
 */

// Replace only one broken url link
function replaceBrokenImg()
{
	let range = [1,2,3,4,5,6,7,8];
	let variant = range[Math.floor(Math.random() * range.length)];
	let logo = '/static/logo/square' + variant + '.svg';
	let img = this;

	img.src = logo;
}

// Replace all visible broken url links
function replaceMultipleBrokenImgs() 
{
	let imgs = document.getElementsByTagName("img");
	
	for (let i = 0; i < imgs.length; i++ ) {
		imgs[i].addEventListener("error", replaceBrokenImg)
	}
}

/**
 * Function to go back to top
 */

function backToTop()
{
	let y = window.pageYOffset;
	let toTop = document.getElementById("toTop").style;

	if (y > 1000)
	{
		toTop.opacity = 1;
 		toTop.visibility = "visible";
	} 
	else 
	{
		toTop.opacity = 0;
	 	toTop.visibility = "hidden";
	}
}




// var lastScrollTop = 0;
// window.addEventListener("scroll", function(){
	
// 	var st = window.pageYOffset || document.documentElement.scrollTop;
// 	var toTop = document.getElementById("toTop").style;

// 	if (st > lastScrollTop){
// 		toTop.opacity = 0;
// 		toTop.visibility = "hidden";
// 	}
// 	else if (st < lastScrollTop && window.pageYOffset > 500)
// 	{
// 		toTop.opacity = 1;
// 		toTop.visibility = "visible";
// 	}
// 	else
// 	{
// 		toTop.opacity = 0;
// 		toTop.visibility = "hidden";
// 	}
// console.log('working');
//    lastScrollTop = st <= 0 ? 0 : st; // For Mobile or negative scrolling
// }, false);