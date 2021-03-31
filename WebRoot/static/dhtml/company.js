/**
 * Function to show/hide the company mobile summary
 * https://usefulangle.com/post/118/javascript-intersection-observer
 */

const panel = document.getElementById("company-panel");
const edit = document.getElementById("edit");
const summary = document.getElementById("mobile-summary");

// root is the browser viewport / screen
var observer = new IntersectionObserver(function(entries) {
	if(entries[0]['isIntersecting'] === true) {
		summary.style.opacity = "0";
	}
	else {
		summary.style.opacity = "1";
	}
}, { threshold: [0, 0.01, 1] });

observer.observe(panel);
// observer.observe(edit);

// Function for the edit panel
function companyEdit() {
	if (panel.style.display == "flex") {
		panel.style.display = "none";
		edit.style.display = "flex";
		summary.style.display = "none"; //This is me giving up on how to fix this, lol
	} else {
		panel.style.display = "flex";
		edit.style.display = "none";
		summary.style.display = "flex";
	}
}