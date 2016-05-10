<?php
/**
 * @version     $Id: module.php 571 2010-10-11 19:41:23Z martin $
 * @package     Joomla
 * @subpackage  system - mmTopPanel Free
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009-2010 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmtoppanel/LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class JElementModule extends JElement
{
    /**
     * Element name
     *
     * @access   protected
     * @var      string
     */
    var $_name = 'Module';

    function fetchElement( $name, $value, &$node, $control_name )
    {
        $db =& JFactory::getDBO();
        $sql = 'SELECT m.id, m.title, m.position, m.published FROM #__modules m
                WHERE client_id = 0
                ORDER BY m.position, m.ordering ASC
                ';
        $db->setQuery( $sql );
        $modules = $db->loadObjectList();

        $latestPosition = '';
        $options        = array();
        $open           = false;

        $first = new stdClass();
        $first->value = null;
        $first->text = 'Select ...';
        $options[0] = $first;

        for ( $i = 0; $i < count( $modules ); $i++ ) {
            $module =& $modules[$i];

            if ( $module->position != $latestPosition ) {

                if ( $latestPosition != '' ) {
                    $options[] = JHTML::_( 'select.option',  '</OPTGROUP>' );
                    $open = false;
                }
                $latestPosition = $module->position;
                $options[] = JHTML::_( 'select.option',  '<OPTGROUP>', $module->position );
                $open = true;
            }

            $titleAddition = ( $module->published ) ? ' [x]' : ' [-]';
            $options[] = JHTML::_( 'select.option',  $module->id, $module->title.$titleAddition );
        }
        if ( $open == true ) {
            $options[] = JHTML::_('select.option',  '</OPTGROUP>' );
        }

        $ctrl   = $control_name .'['. $name .']';
        //$attribs    = 'multiple="multiple"';
        $ctrl       .= '[]';

        return JHTML::_('select.genericlist', $options, $ctrl, '', 'value', 'text', $value, $control_name.$name );
    }
}
