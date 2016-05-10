<?php

/**
 * Qlue Accordion
 *
 * @author Aaron Harding 
 * @package Qlue Accordion
 * @license GNU/GPL
 * @version 1.5.3
 *
 * QLUE Accordion will bring those dull articles to life in an instant. Just specify what category of articles you want to display and leave the rest up to QLUE Accordion. 
 * Your articles will display inside an accordion with smooth sliding effects whenever you want to read the content.
 */

//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

// include the helper file
require_once(dirname(__FILE__).DS.'helper.php');

// Check if the global id has been set
$accordion = QAccordion::getInstance($params);

// Get Module Css
$document = &JFactory::getDocument();

$document->addStyleSheet(JURI::base(true).'/modules/mod_qaccordion/assets/css/style.css');

// Get the articles
$articles = $accordion->getArticles();

$accordion->addScript();

// include the template for display
require(JModuleHelper::getLayoutPath('mod_qaccordion'));

?>