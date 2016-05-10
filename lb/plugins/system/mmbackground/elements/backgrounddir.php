<?php
/**
 * @version     $Id: backgrounddir.php 278 2009-12-06 08:10:05Z martin $
 * @package     Joomla
 * @subpackage  System - mmBackground
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmbackground/LICENSE.php
 *  */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.filesystem.folder' );

class JElementBackgrounddir extends JElement
{
    var $_name = 'backgrounddir';

    /**
     * Produces pulldown list of image directories
     *
     * @param string $name
     * @param integer $value
     * @param ? $node
     * @param string $elementName
     * @return string
     */
    function fetchElement($name, $value, &$node, $elementName)
    {
        $dirs = JFolder::folders( JPATH_ROOT.DS.'images', null, true, true );
        $imageDirs = array();

        $d = new stdClass();
        $d->id = '';
        $d->title = JText::_( '- Select Directory -' );
        $imageDirs[] = $d;

        for ( $x=0; $x < count( $dirs ); $x++ ) {
            $dir = $dirs[$x];
            $d = new stdClass();
            $d->id = str_replace(JPATH_ROOT, "", $dir);
            $d->title = str_replace(JPATH_ROOT, "", $dir);
            $imageDirs[] = $d;
        }
        return JHTML::_('select.genericlist',  $imageDirs, ''.$elementName.'['.$name.']', 'class="inputbox"', 'id', 'title', $value, $elementName.$name );
    }
}
