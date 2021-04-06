/**
 * JS for the company page
 */

window.addEventListener("scroll", () => {
	//https://usefulangle.com/post/113/javascript-detecting-element-visible-during-scroll
	
	var summary = document.querySelector("#mobile-summary").style;
	var position = document.querySelector('.column-left').getBoundingClientRect(); 

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

// Function for the edit panel
function companyEdit() {
	var panel = document.querySelector("#company-panel").style;
	var edit = document.querySelector("#edit").style;

	if (panel.display == "flex") {
		panel.display = "none";
		edit.display = "flex";
		return
	}
	panel.display = "flex";
	edit.display = "none";
}