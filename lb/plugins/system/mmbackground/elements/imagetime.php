<?php
/**
 * @version     $Id: imagetime.php 278 2009-12-06 08:10:05Z martin $
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
class JElementImageTime extends JElement
{
    /**
    * Element name
    * @access   protected
    * @var      string
    */
    var $_name = 'imagetime';

    function fetchElement( $name, $value, &$node, $elementName )
    {
        $hours = array();
        for ( $i = 0; $i <= 23; $i++) {
            $h = new stdClass();
            $h->id = sprintf("%02d", $i);
            $h->title = sprintf("%02d", $i);
            $hours[] = $h;
        }
        $minutes = array();
        for ( $i = 0; $i <= 59; $i++) {
            $m = new stdClass();
            $m->id = sprintf("%02d", $i);
            $m->title = sprintf("%02d", $i);
            $minutes[] = $m;
        }
        $img = ( isset( $value[0] ) ) ? $value[0] : '';

        $h = ( isset( $value[1] ) ) ? $value[1] : '';
        $hour_from = JHTML::_('select.genericlist',  $hours, ''.$elementName.'['.$name.'][h_from]', 'class="inputbox"', 'id', 'title', $h, $elementName.$name );

        $m = ( isset( $value[2] ) ) ? $value[2] : '';
        $minute_from = JHTML::_('select.genericlist',  $minutes, ''.$elementName.'['.$name.'][m_from]', 'class="inputbox"', 'id', 'title', $m, $elementName.$name );

        $h = ( isset( $value[3] ) ) ? $value[3] : '';
        $hour_to = JHTML::_('select.genericlist',  $hours, ''.$elementName.'['.$name.'][h_to]', 'class="inputbox"', 'id', 'title', $h, $elementName.$name );

        $m = ( isset( $value[4] ) ) ? $value[4] : '';
        $minute_to = JHTML::_('select.genericlist',  $minutes, ''.$elementName.'['.$name.'][m_to]', 'class="inputbox"', 'id', 'title', $m, $elementName.$name );

        $return = <<<EOF
        <input type="text" name="{$elementName}[{$name}][img]" value="{$img}""" class="inputbox" /> /
            {$hour_from}:{$minute_from} - {$hour_to}:{$minute_to}
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
