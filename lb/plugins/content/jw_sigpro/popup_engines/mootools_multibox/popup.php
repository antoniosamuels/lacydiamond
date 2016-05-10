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

$relTag = "multibox";
$popupIncludes = '
'.JHTML::_('behavior.mootools').'
<script type="text/javascript" src="'.$popupPath.'/overlay.js"></script>
<script type="text/javascript" src="'.$popupPath.'/multibox.js"></script>
<script type="text/javascript">
	var box = {};
	window.addEvent(\'domready\', function(){
		box = new MultiBox(\'sig-link\');
	});
</script>
<link href="'.$popupPath.'/multibox.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 6]>
<style type="text/css">
	.MultiBoxClose, .MultiBoxPrevious, .MultiBoxNext, .MultiBoxNextDisabled, .MultiBoxPreviousDisabled {behavior:url('.$popupPath.'/iepngfix.htc);}
	.MultiBoxTitle {margin:0 24px; padding:8px;}
</style>
<![endif]-->
';
