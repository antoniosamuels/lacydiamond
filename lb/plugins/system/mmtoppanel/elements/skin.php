<?php
/**
 * @version     $Id: skin.php 571 2010-10-11 19:41:23Z martin $
 * @package     Joomla
 * @subpackage  system - mmTopPanel Free
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009-2010 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmtoppanel/LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.filesystem.folder');

class JElementSkin extends JElement
{
    var $_name = 'skin';

    /**
     * Produces pulldown list of available skins
     *
     * @param string $name
     * @param integer $value
     * @param ? $node
     * @param string $elementName
     * @return string
     */
    function fetchElement($name, $value, &$node, $elementName)
    {
        $dirs = JFolder::folders( JPATH_ROOT.DS.'plugins'.DS.'system'.DS.'mmtoppanel'.DS.'skins', null, false );

        for ( $x=0; $x < count( $dirs ); $x++ ) {
            $dir = $dirs[$x];
            $skin = new stdClass();
            $skin->id = $dir;
            $skin->title = $dir;
            $skins[] = $skin;
        }

        return JHTML::_('select.genericlist',  $skins, ''.$elementName.'['.$name.']', 'class="inputbox"', 'id', 'title', $value, $elementName.$name );
    }
}
