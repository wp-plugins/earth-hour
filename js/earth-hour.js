var eh_state = 0;

function eh_changeMessage() {
	if ( eh_state == 1 ) {
		jQuery("#bnc_earth_hour #inner").hide().html(eh_msg_1).fadeIn();	
		eh_state = 0;
	} else if ( eh_state == 0 ) {
		jQuery("#bnc_earth_hour #inner").hide().html(eh_msg_2).fadeIn();
		eh_state = 1;	
	}
}

jQuery(document).ready( function() {
	setInterval( eh_changeMessage, 15000 );
});