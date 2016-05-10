<?php
/**
 * @version     $Id: overlay.php 278 2009-12-06 08:10:05Z martin $
 * @package     Joomla
 * @subpackage  System - mmBackground
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmbackground/LICENSE.php
 *  */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.filesystem.folder');

class JElementOverlay extends JElement
{
    var $_name = 'overlay';

    /**
     * Produces pulldown list of available overlay images
     *
     * @param string $name
     * @param integer $value
     * @param ? $node
     * @param string $elementName
     * @return string
     */
    function fetchElement($name, $value, &$node, $elementName)
    {
        $files = JFolder::files( JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'mmbackground'.DS.'assets'.DS.'images'.DS.'overlay', '.gif', false, true );

        $overlays = array();
        $d = new stdClass();
        $d->id = '';
        $d->title = JText::_( '- No Image - ' );
        $overlays[] = $d;

        for ( $x=0; $x < count( $files ); $x++ ) {
            $file = $files[$x];
            $d = new stdClass();
            $d->id = str_replace(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'mmbackground'.DS.'assets'.DS.'images'.DS.'overlay'.DS, "", $file);
            $d->title = str_replace(JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'mmbackground'.DS.'assets'.DS.'images'.DS.'overlay'.DS, "", $file);
            $overlays[] = $d;
        }
        return JHTML::_('select.genericlist',  $overlays, ''.$elementName.'['.$name.']', 'class="inputbox"', 'id', 'title', $value, $elementName.$name );
    }
}
