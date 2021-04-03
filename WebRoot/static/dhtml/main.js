// Global Variables
let url = window.location.href;
let body = document.body.style;
let icon = document.getElementById("menu-icon");
let winWidth = window.innerWidth;

/**
 * Functions that run automatically
 */

window.addEventListener("load", onLoad());

function onLoad()
{
	replaceMultipleBrokenImgs(); //replace broken image url links
}

window.addEventListener("resize", () => 
{
	let navbar = document.querySelector(".navbar-box").style;
	let bkg = document.querySelector(".navbar-background").style;
	let filter = document.getElementById("filter").style;

	console.log('rezising');
	bkg.display = "none";
	body.overflow = "auto";
	searchMobileClear(); //clear all search

	if (window.innerWidth > 800) 
	{
		navbar.visibility = "visible";
		navbar.transform = "translateX(0px)";
	}
	else if (window.innerWidth < 800 && window.innerWidth > 500) 
	{
		navbar.visibility = "hidden";
		icon.src = "/static/icon/menu.svg";
	}
	else if (window.innerWidth < 500) 
	{
		navbar.visibility = "hidden";
		icon.src = "/static/icon/menu.svg";
	}

	//In the homepage, change filter window to default
	if (window.location.pathname == '/') { 
		if (window.innerWidth > 800) {
			filter.visibility = "visible";
		} else {
			filter.visibility = "hidden";
		}
	}
})

window.addEventListener("scroll", function() {
	backToTop(); //Back to top button
});

function changeHeaderIcon()
{
	if (icon.src == "/static/icon/close.svg") {
		icon.src = "/static/icon/menu.svg";
	} else {
		icon.src = "/static/icon/close.svg"
	}
}

function toggleNavbar() 
{
	let navbar = document.querySelector(".navbar-box").style;
	let bkg = document.querySelector(".navbar-background").style;

	if (url.includes('/admin'))
	{
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
	else 
	{
		let filter = document.getElementById("filter").style;
		
		if (filter.visibility == "visible")
		{
			icon.src = "/static/icon/menu.svg";
			filter.visibility = "hidden";
			body.overflow = "auto";
		}
		else if (navbar.visibility == "visible")
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
}

/**
 * Functions for Search
 */

let search = document.getElementById("search");
let searchInput = document.getElementById("user-search");
let searchSuggestion = document.getElementById("search-suggestion");
let searchIcon = document.querySelectorAll("search-icon");

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
		body.overflow = "hidden";
		body.position = "fixed";
	}
}

function searchMobileClear() {
	searchInput.value = ""; // clear input value
	searchSuggestion.style.display = "none";
	search.classList.remove("search-fixed");
	body.overflow = "auto";
	body.position = "relative";
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
 * Functions for buttons
 */

// Back to top button
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

// Go back to previous page
function goBack()
{
	let referrer = 	document.referrer.includes("wuwana") || document.referrer.includes(":8000");

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
	let navbar = document.querySelector(".navbar-box").style;
	let bkg = document.querySelector(".navbar-background").style;
	let filter = document.getElementById("filter").style;

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