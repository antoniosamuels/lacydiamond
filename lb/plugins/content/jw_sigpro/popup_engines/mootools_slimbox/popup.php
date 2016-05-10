<?php
/*
// JoomlaWorks "Simple Image Gallery PRO" Plugin for Joomla! 1.5.x - Version 2.0.5
// Copyright (c) 2006 - 2010 JoomlaWorks Ltd.
// This code cannot be redistributed without permission from JoomlaWorks
// More info at http://www.joomlaworks.gr
// Designed and developed by JoomlaWorks
// ***Last update: February 18th, 2010***
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$relTag = "lightbox";
$popupIncludes = '
'.JHTML::_('behavior.mootools').'
<script type="text/javascript" src="'.$popupPath.'/js/slimbox.js"></script>
<link href="'.$popupPath.'/css/slimbox.css" rel="stylesheet" type="text/css" />
';
