<?php
/**
 * @version     $Id: colorpicker.php 381 2010-03-14 07:44:09Z martin $
 * @package     Joomla
 * @subpackage  System - mmBackground
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmbackground/LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementColorpicker extends JElement
{
    var $_name = 'colorpicker';

    /**
     * Produces color picker control using mooRainbow
     *
     * @param string $name
     * @param integer $value
     * @param ? $node
     * @param string $elementName
     * @return string
     */
    function fetchElement($name, $value, &$node, $elementName)
    {
        if ( JApplication::getCfg( 'debug' ) ) JHTML::_('script', 'mooRainbow.source.js', 'plugins/system/mmbackground/assets/js/');
        else JHTML::_('script', 'mooRainbow.min.js', 'plugins/system/mmbackground/assets/js/');

        JHTML::_('stylesheet', 'mooRainbow.css', 'plugins/system/mmbackground/assets/css/');

        $document =& JFactory::getDocument();
        $document->addScriptDeclaration("
        window.addEvent('load', function() {
            var mooRainbow".$name." = new MooRainbow('rainbow_".$name."', {
                    'id': 'rainbow-".$name."',
                    imgPath: '" .JURI::root()."plugins/system/mmbackground/assets/images/mooRainbow/',
                    wheel: true,
                    'onChange': function(color) {
                        $('rainbow".$name."').value = color.hex;
                        $('rainbow".$name."-picker').setStyle('background-color', color.hex);
                    },
                    'startColor': [".$this->_hexToRgb( $value )."]
                });
        });");

        return '<input type="text" value="'.$value.'" name="params['.$name.']" id="rainbow'.$name.'" class="text_area" style="float: left; width: 114px;" /><span style="display: block; float: left; margin-left: 2px; background-color:'.$value.'" id="rainbow'.$name.'-picker"><img src="'.JURI::root().'plugins/system/mmbackground/assets/images/colorpicker.gif" alt="" id="rainbow_'.$name.'" /></span>';
    }

    function _hexToRgb( $hex )
    {
        $int = hexdec( $hex );
        $arr = array(   "red" => 0xFF & ( $int >> 0x10 ),
                        "green" => 0xFF & ( $int >> 0x8 ),
                        "blue" => 0xFF & $int
                    );
        return implode( ', ', $arr );
    }
}