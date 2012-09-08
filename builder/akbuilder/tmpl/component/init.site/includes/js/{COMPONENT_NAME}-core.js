/*!
 * com_{COMPONENT_NAME} v1.0.0
 *
 * Copyright 2012 Asikart.com
 * Licensed under the Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Generator: AKHelper
 * Author: Asika
 */


/* Fix Bluestork and Joomla! Conflict */
window.addEvent( 'domready', function(){
	var modal = $$('.adminform .modal') ;
	setTimeout(function(){ modal.removeClass('modal'); }, 500 );

} );