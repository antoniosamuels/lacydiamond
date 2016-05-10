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
defined('_JEXEC') or die('Restricted Access');

// Import joomla base library
jimport('joomla.base.object');
jimport('joomla.plugin.helper');

class QAccordion extends JObject {
    
  public $id = 0; 
  private $_params = null;
  private $_articles = null;
  
  public function __construct() {
    // Require article router helper file
    require_once(JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
  }
  
  public static function getInstance($params) {
      
      static $instance;
      
      if(!isset($instance)) {
        $instance = new QAccordion();
      }
      
      // Update the id
      $instance->id++;
      
      // Update the params
      $instance->setParams($params);
      
      return $instance;
  }
  
  public function setParams($params) {
    $this->_params = $params;
  }
  
  public function getArticles() {
      
    // Get the database object
    $db =& JFactory::getDBO();
    
    // Create the query
    $query = $this->_buildQuery();
    
    // Set the query
    $db->setQuery($query, 0, (int)$this->_params->get('countItem', 5));
    
    // Get the data
    $articles = $db->loadObjectList();
    
    // Foreach article get SEF link
    foreach($articles as $key => $item) {
      $articles[$key]->href = ContentHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->sectionid);
      $articles[$key]->text = JHTML::_('content.prepare', $item->text);
    }
    
    $this->_articles = $articles;
    
    return $this->_articles;
  }
  
  public function addScript() {
    // Load the mootools library if it hasn't already
    JHTML::_('behavior.mootools');
    
    // Get the document object
    $document =& JFactory::getDocument();
    
    // Create the decleration
    $opt = array();
    
    // Get hover parameter
    $hover = $this->_params->get('hover', 0);
    
    // Determine if we are adding a roll over event
    if( $hover ){
      $rollover = "$$('#qaccordion". (int)$this->id ." .acc-header').addEvent('mouseenter', function() { this.fireEvent('click'); });";
    } else {
      $rollover = '';
    }
    
    // Setup some accordion options
    $opt['display'] = (int)$this->_params->get('display', 0);
    $opt['opacity'] = $this->_params->get('opacity', 1) ? '\\true' : '\\false';
    $opt['alwaysHide'] = $this->_params->get('alwaysHide', 0) ? '\\true' : '\\false';
    
    $opt['onActive'] = '\\function(toggle, element){toggle.setProperty("class", "acc-header-active");}';
    $opt['onBackground'] = '\\function(toggle, element){toggle.setProperty("class", "acc-header");}';
    
    $options = JHTMLBehavior::_getJSObject($opt);
    
    $script = 'window.addEvent( window.ie ? "load" : "domready", function() {';
    $script .= $rollover;
    $script .= 'new Fx.Accordion(".acc-header", ".acc-content", '. $options .');';
    $script .= '});';
    
    $document->addScriptDeclaration($script);
    
    return true;    
  }
  
  private function _buildQuery() {
      
    // Get the database object
    $db =& JFactory::getDBO();
    
    $date = JFactory::getDate();
    
    $now = $date->toMySQL();
    $nullDate = $db->getNullDate();
    
    // Get user object
    $user =& JFactory::getUser();
    
    // Create query variable
    $query = 'SELECT a.title AS title, '
           . ' CONCAT(a.introtext) AS text,'
           . ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'
           . ' CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(":", b.id, b.alias) ELSE b.id END as catslug,'
           . ' u.id AS sectionid'
           . ' FROM #__content AS a'
           . ' INNER JOIN #__categories AS b ON b.id = a.catid'
           . ' INNER JOIN #__sections AS u ON u.id = a.sectionid'
           . ' WHERE ( '. $this->_buildWhere() .' )'
           . ' AND a.state = 1'
           . ' AND u.published = 1'
           . ' AND b.published = 1'
           . ' AND a.access <= '.(int) $user->get( 'aid' )
           . ' AND b.access <= '.(int) $user->get( 'aid' )
           . ' AND u.access <= '.(int) $user->get( 'aid' )
           . ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
           . ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
           . ' GROUP BY a.id'
           . ' ORDER BY '. $this->_buildOrder();
    // return the query
    return $query;
  }
  
  private function _buildWhere() {
          
    $where = array();
    $catIds = (array)$this->_params->get('categories', array(0));
    
    // Sanitize the cat ids array
    JArrayHelper::toInteger($catIds);
    
    $where[] = 'a.catid IN ('. implode(',', $catIds) .')';
    
    // Implode the where array to string
    $wheres = implode(' AND ', $where);
    
    return $wheres;  
  }
  
  private function _buildOrder() {
      
    switch($this->_params->get('orderBy', 'article')) {
      
      case 'alpha':
        $order = 'a.title ASC';
      break;
      
      case 'hits':
        $order = 'a.hits DESC';
      break;
      
      case 'modified':
        $order = 'a.modified DESC';
      break;
      
      case 'newest':
        $order = 'a.created DESC';
      break;
      
      case 'oldest':
        $order = 'a.created ASC';
      break;
      
      case 'article':
      default:
        $order = 'a.ordering ASC';
      break;
    }
    
    return $order;
  }
  
}

?>