<?php
/**
 * @version     $Id: slider.php 571 2010-10-11 19:41:23Z martin $
 * @package     Joomla
 * @subpackage  system - mmTopPanel Free
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009-2010 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmtoppanel/LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementSlider extends JElement
{
    /**
     * Hack to get tooltip icons displayed in the component
     * parameter modal window view
     *
     * @access  protected
     * @var     string
     */
    var $_name = 'Slider';

    function fetchElement($name, $value, $control_name)
    {
        //if (is_null($value)) $value = 0;
        // Fetch atributes
        $steps  = $control_name->attributes('steps');
        $min    = $control_name->attributes('min');
        $max    = $control_name->attributes('max');

        JHTML::_('stylesheet', 'mmtoppanel.css', 'plugins/system/mmtoppanel/assets/css/');

        $document = &JFactory::getDocument();
        $document->addScriptDeclaration('
            window.addEvent("domready", function() {
                var mySlide'.$name.' = new Slider($(\'area-'.$name.'\'), $(\'knob-'.$name.'\'), {
                    steps: '.$steps.',
                    onChange: function(step) {
                        $(\''.$name.'\').value = (('.$max.'/'.$steps.')*step).limit('.$min.', '.$max.').round(2);
                    }
                }).set('.($value * $steps).');
            });
            ');
        return '<input type="text" name="params['.$name.']" id="'.$name.'" value="'.$value.'" /><br /><div id="area-'.$name.'" class="area"><div id="knob-'.$name.'" class="knob"></div></div>';
    }

}