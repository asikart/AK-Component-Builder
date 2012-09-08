/* Fix Bluestork and Bootstrap Conflict */
window.addEvent( 'domready', function(){
	// toolbar
	var div = $$('#toolbar')[0] ;
	var ul = $$('#toolbar ul');
	var li = $$('#toolbar li');
	var span = $$('.toolbar-list .button span');
	var a = $$('.toolbar-list .button a');
	
	div.addClass('btn-toolbar');
	ul.addClass('btn-group');
	span.set('class', '');
	li.addClass('btn');
	
	$$('#toolbar-apply').addClass('btn-info');
	$$('#toolbar-save').addClass('btn-primary');
	$$('#toolbar-cancel').addClass('btn-danger');
	
	// model button
	$$('div.button2-left a').addClass('btn');
	
	// access
	$$('.group-rules td span').set('class', '');
} );