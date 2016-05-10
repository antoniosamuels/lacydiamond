/**
 * @version     $Id: mmtoppanel.source.js 571 2010-10-11 19:41:23Z martin $
 * @package     Joomla
 * @subpackage  system - mmTopPanel Free
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009-2010 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmtoppanel/LICENSE.php
 * 
 * We could have used Fx.Slide, but with the implementation below we can configure
 * the in and out animations independently ...
 */

window.addEvent('domready', function() {

	// check for markup to avoid obvious errors
	if ($('mmToppanel')) {
	    
	    // get existing top margin
	    var topPadding    = $(document.body).getStyle('paddingTop').toInt();

		// clone panel
		var panelHeight   = $('mmToppanel').getSize().size.y;
		var handleHeight  = $('mmToppanel-handle').getSize().size.y;
		var mmToppanel    = $('mmToppanel');

		mmToppanel.setStyles({
			zIndex: 99999,
			position: 'absolute',
			width: '100%'
		});
		
		// detect height & set appropriate margin
		panelHeight = mmToppanel.getSize().size.y - handleHeight;
		mmToppanel.setStyle('marginTop', -(panelHeight+topPadding));
		
		// correct height
		var mods = $ES('li.module', $('mmToppanel-content'));
		var heighest = 0;
		if (mods.length > 1) {
    		mods.each(function(mod) {
    		    var height = mod.getSize().size.y;
    		    if (height > heighest) heighest = height;
    		});
            mods.each(function(mod) {
                mod.setStyle('height', heighest+'px');
            });
		}
		
		// animate down
		var mmToppanelDown = function() {
			if (mmToppanelEaseIn != '' && mmToppanelTransitionIn != 'linear') var aniFx = Fx.Transitions[mmToppanelTransitionIn][mmToppanelEaseIn];
			else var aniFx = Fx.Transitions[mmToppanelTransitionIn];
			if (mmToppanelEaseIn == '' && mmToppanelTransitionIn == 'Elastic') var aniFx = Fx.Transitions[mmToppanelTransitionIn]['easeOut'];
			var ani = new Fx.Style(mmToppanel, 'margin-top', {
				duration: mmToppanelDurationIn,
				transition: aniFx,
				onComplete: function() { 
			        mmToppanel.setProperty('state', 'expanded'); 
		            if (!$('mmToppanel-handle-bar').hasClass('expanded')) {
		                $('mmToppanel-handle-bar').addClass('expanded')
		            }
			    }
			});
			ani.start(-topPadding);
		}
		
		// animate up 
		var mmToppanelUp = function() {
			if (mmToppanelEaseOut != '' && mmToppanelTransitionOut != 'linear') var aniFx = Fx.Transitions[mmToppanelTransitionOut][mmToppanelEaseOut];
			else var aniFx = Fx.Transitions[mmToppanelTransitionOut];
			if (mmToppanelEaseOut == '' && mmToppanelTransitionOut == 'Elastic') var aniFx = Fx.Transitions[mmToppanelTransitionOut]['easeOut'];
			var ani = new Fx.Style(mmToppanel, 'margin-top', {
				duration: mmToppanelDurationOut,
				transition: aniFx,
				onComplete: function() { 
			        mmToppanel.setProperty('state', 'collapsed');
			        $('mmToppanel-handle-bar').removeClass('expanded')
			    }
			});
		    ani.start(-(panelHeight+topPadding));
		}
		
		// configure events
		if (mmToppanelEventHook == 'mouseenter') {
		    // drop down on mouse enter
		    $('mmToppanel').addEvent('mouseenter', function(evt) {
                var ev = new Event(evt);
                ev.stop();
                if (mmToppanel.getProperty('state') != 'expanded') mmToppanelDown();
		    });
		    var selector = 'mmToppanel-handle-a';
            $(selector).addEvent('click', function(evt) {
                var ev = new Event(evt);
                ev.stop();
                if (mmToppanel.getProperty('state') != 'collapsed') mmToppanelUp();
            });
		} else {
		    // drop down on click; attach event to handle and animate away
            var selector = 'mmToppanel-handle-a';
    		$(selector).addEvent('click', function() {
    			if (mmToppanel.getProperty('state') != 'expanded') mmToppanelDown();
    			else mmToppanelUp();
    		});
		}
	}
});