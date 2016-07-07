/*--------------------------------------------------
DOCUMENT READY FUNCTIONS
--------------------------------------------------*/

jQuery(document).ready(function($) {

});

/*--------------------------------------------------
WINDOW RESIZE FUNCTIONS
--------------------------------------------------*/

jQuery(window).resize(function() {

});

/*--------------------------------------------------
WINDOW LOAD FUNCTIONS
--------------------------------------------------*/

jQuery(window).load(function() {
	jQuery('body').animate( {
		opacity: '1'
	}, 300);
});

/*--------------------------------------------------
REUSABLE FUNCTIONS
--------------------------------------------------*/

function ie8SafePreventEvent(e) {
	if (e.preventDefault) {
		e.preventDefault()
	} else {
		e.stop()
	};
	e.returnValue = false;
	e.stopPropagation();
}

function isEmpty( el ) {
	return !jQuery.trim(el.html());
}
