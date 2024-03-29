// ECMAScript 5
"use strict";

// Global Variables
var url = window.location.href;
var body = document.body.style;
var icon = document.getElementById("menu-icon");
var winWidth = window.innerWidth;

/**
 * Funtion to toggle dark mode and light mode
 * https://www.youtube.com/watch?v=wodWDIdV9BY
 */

var webAppearence = localStorage.getItem("webAppearence");

function darkMode() {
	// Remove class .light-mode
	document.body.classList.remove("light-mode");
	// Add class .dark-mode to the body
	document.body.classList.add("dark-mode");
	// Update localStorage
	localStorage.setItem('webAppearence', 'darkMode');
}

function lightMode() {
	// Remove class .dark-mode
	document.body.classList.remove("dark-mode");
	// Add class .light-mode to the body
	document.body.classList.add("light-mode");
	// Update localStorage
	localStorage.setItem('webAppearence', 'lightMode');
}
 
/**
 * Functions that run automatically
 */

window.addEventListener("load", onLoad());

function onLoad()
{
	replaceMultipleBrokenImgs(); //replace broken image url links

	// Check for darkMode or lightMode
	if (webAppearence == 'lightMode') {
		document.body.classList.add("light-mode");
	} else if (webAppearence == 'darkMode') {
		document.body.classList.add("dark-mode");
	}
}

window.addEventListener("resize", () => 
{
	var body = document.body.style;
	var icon = document.getElementById("menu-icon");
	var navbar = document.querySelector("#navbar").style;
	var bkg = document.querySelector("#navbar-background").style;
	
	bkg.display = "none";
	body.overflow = "auto";

	if (window.innerWidth > 800) 
	{
		navbar.visibility = "visible";
		navbar.transform = "translateX(0px)";
	}
	else 
	{
		navbar.visibility = "hidden";
		navbar.transform = "translateX(-110vw)";
		icon.src = "/static/icon/menu.svg";
	}
})

function changeHeaderIcon()
{
	if (icon.src == "/static/icon/close.svg")
	{
		icon.src = "/static/icon/menu.svg";
		return
	} 
	icon.src = "/static/icon/close.svg"
}

function toggleNavbar() 
{
	var navbar = document.querySelector("#navbar").style;
	var bkg = document.querySelector("#navbar-background").style;

	if (navbar.visibility == "visible")
	{
		navbar.visibility = "hidden";
		navbar.transform = "translateX(-110vw)";
		bkg.display = "none";
		icon.src = "/static/icon/menu.svg";
		body.overflow = "auto";
	}
	else
	{
		navbar.visibility = "visible";
		navbar.transform = "translatex(0)";
		bkg.display = "block";
		icon.src = "/static/icon/close.svg";
		body.overflow = "hidden";
	}
}

/**
 * Function to replace broken img url link
 * with random wuwana square logo
 */

// Replace only one broken url link
function replaceBrokenImg()
{
	var range = [1,2,3,4,5,6,7,8];
	var variant = range[Math.floor(Math.random() * range.length)];
	var logo = '/static/logo/square' + variant + '.svg';
	var img = this;

	img.src = logo;
}

// Replace all visible broken url links
function replaceMultipleBrokenImgs() 
{
	var imgs = document.getElementsByTagName("img");
	
	for (var i = 0; i < imgs.length; i++ ) {
		imgs[i].addEventListener("error", replaceBrokenImg)
	}
}

/**
 * Functions for buttons
 */

// Back to top button
// function backToTop()
// {
// 	var y = window.pageYOffset;
// 	var toTop = document.getElementById("toTop").style;

// 	if (y > 1000)
// 	{
// 		toTop.opacity = 1;
//  		toTop.visibility = "visible";
// 	} 
// 	else 
// 	{
// 		toTop.opacity = 0;
// 	 	toTop.visibility = "hidden";
// 	}
// }

// Go back to previous page
function goBack()
{
	var referrer = 	document.referrer.includes("wuwana") || document.referrer.includes(":8000");

	if (!referrer) {
		window.location = '/';
		return 
	}
	window.history.back();
}

/**
 * NO IN USE
 */

function sendEmail()
{
	var email = document.getElementById("email").value;
	var form = new FormData();
	var xhr = new XMLHttpRequest();

	form.append("email", email);

	xhr.open("post", "/ajax/email/send-code.php");
	xhr.send(form);
}

function setDefault() {
	var navbar = document.querySelector(".navbar-box").style;
	var bkg = document.querySelector(".navbar-background").style;
	var filter = document.getElementById("filter").style;

	if (winWidth > 800) // Desktop
	{
		navbar.visibility = "visible";
		navbar.transform = "translateX(0px)"
		filter.visibility = "visible";
	} 
	else // Table and mobile
	{
		bkg.display = "none";
		navbar.visibility = "hidden";
		navbar.transform = "translateX(-110vw)";
		filter.visibility = "hidden";
		icon.src = "/static/icon/menu.svg";
		body.overflow = "auto";
	}
}

/**
 * Functions for Search
 */

//  var search = document.getElementById("search");
//  var searchInput = document.getElementById("user-search");
//  var searchSuggestion = document.getElementById("search-suggestion");
//  var searchIcon = document.querySelectorAll("search-icon");
 
//  searchInput.onkeyup = (e) => {
// 	 var userData = e.target.value; //user entered data
// 	 var emptyArray = [];
	 
// 	 if (userData) {
// 		 searchSuggestion.style.display = "block"; // Show suggestion box
// 		 showSuggestions(emptyArray);
// 	 }
// 	 else 
// 	 {
// 		 searchSuggestion.style.display = "none";
// 	 }
//  }
 
//  function showSuggestions(list){
// 	 var listData;
// 	 var userValue;
 
// 	 if(!list.length)
// 	 {
// 		 userValue = searchInput.value;
// 		 listData = '<a href="/?search=' + userValue + '"><li>'+ userValue +'</li></a><hr>';
// 	 }
// 	 else
// 	 {
// 		 listData = list.join('');
// 	 }
// 	 searchSuggestion.innerHTML = listData;
//  }
 
//  Search Mobile
//  function searchMobile() {
// 	 if (window.innerWidth < 500) {
// 		 search.classList.add("search-fixed");
// 		 body.overflow = "hidden";
// 		 body.position = "fixed";
// 	 }
//  }
 
//  function searchMobileClear() {
// 	 searchInput.value = ""; // clear input value
// 	 searchSuggestion.style.display = "none";
// 	 search.classList.remove("search-fixed");
// 	 body.overflow = "auto";
// 	 body.position = "relative";
//  }