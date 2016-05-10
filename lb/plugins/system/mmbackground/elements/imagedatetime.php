<?php
/**
 * @version     $Id: imagedatetime.php 349 2010-02-07 08:57:38Z martin $
 * @package     Joomla
 * @subpackage  System - mmBackground
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmbackground/LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Renders a image vs time selector
 *
 * @package     Joomla
 * @subpackage  System - mmBackground
 * @since       1.5
 */
class JElementImageDateTime extends JElement
{
    /**
    * Element name
    * @access   protected
    * @var      string
    */
    var $_name = 'imagedatetime';

    function fetchElement( $name, $value, &$node, $elementName )
    {
        $img            = ( isset( $value[0] ) ) ? $value[0] : '';
        $datetime_from  = ( isset( $value[1] ) ) ? $value[1] : '';
        $datetime_to    = ( isset( $value[2] ) ) ? $value[2] : '';

        JHTML::_('behavior.calendar'); //load the calendar behavior

        $format         = ( $node->attributes('format') ? $node->attributes('format') : '%Y-%m-%d %H:%M:%S' );
        $class          = $node->attributes('class') ? $node->attributes('class') : 'inputbox mmBackground-datetime';
        $id             = $elementName.$name.'date_from';
        $calendar_from    = JHTML::_('calendar', $datetime_from, $elementName.'['.$name.'][date_from]', $id, $format, array('class' => $class));

        $id             = $elementName.$name.'date_to';
        $calendar_to  = JHTML::_('calendar', $datetime_to, $elementName.'['.$name.'][date_to]', $id, $format, array('class' => $class));

        $return = <<<EOF
        <div class="calender-wrapper">
        <input type="text" name="{$elementName}[{$name}][img]" value="{$img}""" class="inputbox" /> <span>/</span>
            <label>From: </label> {$calendar_from}
            <label>To: </label> {$calendar_to}</div>
EOF;
//        $return = <<<EOF
//        <input type="text" name="{$elementName}[{$name}][img]" value="{$img}""" class="inputbox" />
//        <div style="padding:3px 0px;">
//            <label>From: </label> {$hour_from}:{$minute_from}
//            <label>To: </label> {$hour_to}:{$minute_to}
//        </div>
//EOF;
        return $return;
    }
}
