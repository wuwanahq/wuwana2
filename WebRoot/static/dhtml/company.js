// ECMAScript 5
"use strict";

/**
 * JS for the company page
 */

window.addEventListener("scroll", () => {
	//https://usefulangle.com/post/113/javascript-detecting-element-visible-during-scroll
	
	var summary = document.querySelector("#mobile-summary").style;
	var position = document.querySelector('#main-info').getBoundingClientRect(); 

	if (position.bottom >= 0)
	{
		summary.transform = "translateY(-100px)"
		summary.opacity = "0";
	}
	else 
	{
		summary.opacity = "1";
		summary.transform = "translateY(0px)"
	}
})

window.addEventListener("resize", () => 
{
	var edit = document.querySelector("#edit");
	var body = document.body.style;

	if (edit)
	{
		edit.style.visibility = "hidden";
		body.overflow = "auto";
	}
})

// Function for the edit panel
function toggleEdit() {
	var edit = document.querySelector("#edit");
	var body = document.body.style;
	
	if (edit.style.visibility == "visible")
	{
		edit.style.visibility = "hidden";
		body.overflow = "auto";
		return;
	}
	edit.style.visibility = "visible";
	body.overflow = "hidden";
}