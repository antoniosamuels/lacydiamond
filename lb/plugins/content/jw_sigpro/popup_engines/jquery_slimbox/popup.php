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
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">google.load("jquery", "1.3.2");</script>
<script type="text/javascript" src="'.$popupPath.'/js/slimbox2.js"></script>
<style type="text/css" media="all">
	@import "'.$popupPath.'/css/slimbox2.css";
</style>
';
