<?php
/**
 * @version     $Id: mmspacer.php 279 2009-12-06 09:10:48Z martin $
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
 * Renders a spacer with title
 *
 * @package     Joomla
 * @subpackage  System - mmBackground
 * @since       1.5
 */
class JElementMmspacer extends JElement
{
    /**
     * Element name
     * @access   protected
     * @var      string
     */
    var $_name = 'mmspacer';

    function fetchElement( $name, $value, &$node, $elementName )
    {
        $return = <<<EOF
        <hr />
EOF;
        return $return;
    }
}
