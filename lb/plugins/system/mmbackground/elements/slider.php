<?php
/**
 * @version     $Id: slider.php 278 2009-12-06 08:10:05Z martin $
 * @package     Joomla
 * @subpackage  System - mmBackground
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmbackground/LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementSlider extends JElement
{
    /**
     * Slider for opacity control
     *
     * @access  protected
     * @var     string
     */
    var $_name = 'Slider';

    function fetchElement($name, $value, $control_name)
    {
        // Fetch atributes
        $steps  = $control_name->attributes('steps');
        $min    = $control_name->attributes('min');
        $max    = $control_name->attributes('max');

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