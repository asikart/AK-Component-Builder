/*!
 * com_{COMPONENT_NAME}
 *
 * Copyright 2012 Asikart.com
 * License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 *
 * Generator: AKHelper
 * Author: Asika
 */


/* Fix Bluestork and Joomla! Conflict */
window.addEvent( 'domready', function(){
	var modal = $$('.adminform a.modal', '#toolbar-box a.modal') ;
	setTimeout(function(){ modal.removeClass('modal'); }, 500 );

} );


var {COMPONENT_NAME_UCFIRST} = {
	fixToolbar: function(top, duration){
		
		top = top || 40 ;
		duration = duration || 300 ;
		
		// fix sub nav on scroll	
		jQuery(document).ready(function($) {
			var $win = $(window)
			, $nav = $('.subhead')
			, navTop = $('.subhead').length && $('.subhead').offset().top - 40
			, isFixed = 0
			
			processScroll();
			
			// hack sad times - holdover until rewrite for 2.1
			$nav.on('click', function () {
			  if (!isFixed) setTimeout(function () {  $win.scrollTop($win.scrollTop() - 47) }, 10)
			})
			
			$win.on('scroll', processScroll)
			
			function processScroll() {
			  var i, scrollTop = $win.scrollTop()
			  if (scrollTop >= navTop && !isFixed) {
				  isFixed = 1
				  $nav.addClass('subhead-fixed')
				  $nav.css('left', 0) ;
				  $nav.css('top', 0) ;
				  $nav.animate({top: top}, duration);
			  } else if (scrollTop <= navTop && isFixed) {
				  isFixed = 0
				  $nav.removeClass('subhead-fixed')
			  }
			}
		});
	}
}

