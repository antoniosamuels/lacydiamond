<?php
/**
 * @version     $Id: accessibility.php 325 2010-01-17 01:13:27Z martin $
 * @package     Joomla
 * @subpackage  System - mmBackground
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmbackground/LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementAccessibility extends JElement
{
    /**
     * Hack to get tooltip icons displayed in the plugin
     * parameter view
     *
     * @access  protected
     * @var     string
     */
    var $_name = 'Accessibility';

    function fetchElement($name, $value, $control_name)
    {
        JHTML::_('stylesheet', 'mmbackground.css', 'plugins/system/mmbackground/assets/css/');

        $document = &JFactory::getDocument();
        $document->addScriptDeclaration("
            window.addEvent('domready', function() {
                $('accessibility-hack').getParent().getParent().setStyle('display', 'none');

                var colLeft= \$ES('#element-box .width-60');
                colLeft.removeClass('width-60');
                colLeft.addClass('width-50');
                var colRight = \$ES('#element-box .width-40');
                colRight.removeClass('width-40');
                colRight.addClass('width-50');
                //alert( \$ES('#element-box .width-40') );

                if ($('toolbar-help')) {
                    var newOnclick = $('toolbar-help').getFirst().getProperty('onclick').replace('help.joomla.org', 'help.mmplugins.com');
                    $('toolbar-help').getFirst().setProperty('onclick', '');
                    $('toolbar-help').getFirst().addEvent('click', function() {
                        eval(newOnclick.replace('index2.php', 'index.php').replace(';1', '').replace('640', '725').replace('.plugins', '.plg_mmbackground'));
                    });
                }
            });
        ");

        return '<div id="accessibility-hack">&nbsp;</div>';
    }

}

