<?php
/**
 * @version     $Id: accessibility.php 571 2010-10-11 19:41:23Z martin $
 * @package     Joomla
 * @subpackage  system - mmTopPanel Free
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmtoppanel/LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementAccessibility extends JElement
{
    /**
     * Hack to get tooltip icons displayed in the component
     * parameter modal window view
     *
     * @access  protected
     * @var     string
     */
    var $_name = 'Accessibility';

    function fetchElement($name, $value, $control_name)
    {
        JHTML::_('stylesheet', 'mmtoppanel.css', 'plugins/system/mmtoppanel/assets/css/');

        $document = &JFactory::getDocument();
        $document->addScriptDeclaration("
            window.addEvent('domready', function() {
                $('accessibility-hack').getParent().getParent().setStyle('display', 'none');

                $('paramstext_down').setStyle('width', '99%');
                $('paramstext_up').setStyle('width', '99%');
                //$('paramsmodules').setProperty('size', '20');

                if ($('toolbar-help')) {
                    var newOnclick = $('toolbar-help').getFirst().getProperty('onclick').replace('help.joomla.org', 'help.mmplugins.com');
                    $('toolbar-help').getFirst().setProperty('onclick', '');
                    $('toolbar-help').getFirst().addEvent('click', function() {
                        eval(newOnclick.replace('index2.php', 'index.php').replace(';1', '').replace('640', '725').replace('.plugins', '.plg_mmtoppanel'));
                    });
                }
            });
        ");

        return '<div id="accessibility-hack">&nbsp;</div>';
    }

}

