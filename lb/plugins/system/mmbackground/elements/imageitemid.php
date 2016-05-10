<?php
/**
 * @version     $Id: imageitemid.php 279 2009-12-06 09:10:48Z martin $
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
 * Renders a image vs Itemid selector
 *
 * @package     Joomla
 * @subpackage  System - mmBackground
 * @since       1.5
 */
class JElementImageItemid extends JElement
{
    /**
    * Element name
    * @access   protected
    * @var      string
    */
    var $_name = 'imageitemid';

    function fetchElement( $name, $value, &$node, $elementName )
    {
        $img    = ( isset( $value[0] ) ) ? $value[0] : '';
        $Itemid = ( isset( $value[1] ) ) ? $value[1] : '';
        $return = <<<EOF
        <input type="text" name="{$elementName}[{$name}][img]" value="{$img}" class="inputbox" /> / <input type="text" name="{$elementName}[{$name}][Itemid]" value="{$Itemid}" class="inputbox" size="4" /> (Image / Itemid)
EOF;
        return $return;
    }
}
