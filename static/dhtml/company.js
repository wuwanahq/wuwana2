/**
 * Function to show/hide the company mobile summary
 * https://usefulangle.com/post/118/javascript-intersection-observer
 */

const panel = document.getElementById("company-panel");
const summary = document.getElementById("mobile-summary");

// root is the browser viewport / screen
var observer = new IntersectionObserver(function(entries) {
	// since there is a single target to be observed, there will be only one entry
	if(entries[0]['isIntersecting'] === true) {
		if(entries[0]['intersectionRatio'] > 0.01){
			summary.style.opacity = "0";
		}
		else if(entries[0]['intersectionRatio'] < 0.3)
			summary.style.opacity = "1";
	}
	else {
		summary.style.opacity = "1";
	}
}, { threshold: [0, 0.01, 1] });

observer.observe(panel);
