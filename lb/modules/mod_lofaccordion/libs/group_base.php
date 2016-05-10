<?php
 // No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
 * $ModDesc
 * 
 * @version	$Id: group_base.php $Revision
 * @package	modules
 * @subpackage	$Subpackage
 * @copyright	Copyright (C) June 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website 	htt://landofcoder.com
 * @license	GNU General Public License version 2
 */
if( !class_exists('LofGroupSimpleBase') ){ 
		/**
		 * LofGroupBase Class  
		 */
	    class LofGroupSimpleBase{
		
		/**
		 * @var string $_name is name of group;
		 *
		 * @access private;
		 */
		private $__name = 'Simple Group Base';
		
		/**
		 * @var string $__currentPath;
		 *
		 * @access private;
		 */
		private $__currentPath = '';
		
		/**
		 * @var boolean $__returnImagePath
		 *
		 * @access private
		 */
		protected $__returnImagePath = false;
		
		/**
		 * @var array $_tags
		 *
		 * @access protected
		 */
		protected $_tags = array( 'img' => '<img src="%s" title="%s" alt="%s"/>', 
								  'a'   =>  '<a href="%s" title="%s">%s</a>' );
		/**
		 * getter of current path variable
		 */
		public function setCurrentPath( $path ){
			$this->__currentPath = $path;
		}
		public function setReturnImagePath( $bool=true ){
			$this->__returnImagePath = $bool;	
		}
		
		/**
		 * getter of current path variable
		 */
		public function getCurrentPath(){
			return $this->__currentPath;
		}
		
		/**
		 * getter of name variable
		 */
		public function getName(){
			return $this->__name;	
		}
				
		/**
		 * get parameters from configuration string.
		 *
		 * @param string $string;
		 * @return array.
		 */
		 public function parseParams( $string ) {
			$string = html_entity_decode($string, ENT_QUOTES);
			$regex = "/\s*([^=\s]+)\s*=\s*('([^']*)'|\"([^\"]*)\"|([^\s]*))/";
			 $params = null;
			 if(preg_match_all($regex, $string, $matches) ){
					for ($i=0;$i<count($matches[1]);$i++){ 
					  $key 	 = $matches[1][$i];
					  $value = $matches[3][$i]?$matches[3][$i]:($matches[4][$i]?$matches[4][$i]:$matches[5][$i]);
					  $params[$key] = $value;
					}
			  }
			  return $params;
		}
		
		/**
		 * get parameters from configuration string.
		 *
		 * @param string $string;
		 * @return array.
		 */
		public function getTitle( $row ){
			$data = self::parserCustomTag(  $row->introtext );
			if( isset($data[1][0]) ){
				$tmp = self::parseParams( $data[1][0] );
				
				$txt = (isset($tmp['icon'])?sprintf( $this->_tags['img'],$tmp['icon'], $row->title, $row->title ):'')
											.'<span class="lof-title">'.$row->title."</span>";
				return  $txt.(isset($tmp['desc']) ? ' <span class="lof-subdesc">'. $tmp['desc'].'</span>':'');
			}
			return '<span class="lof-title">'.$row->title."</span>";
		}
		/**
		 * parser a custom tag in the content of article to get the image setting.
		 * 
		 * @param string $text
		 * @return array if maching.
		 */
		public function parserCustomTag( $text ){ 
			if( preg_match("#{loftag(.*)}#s", $text, $matches, PREG_OFFSET_CAPTURE) ){ 
				return $matches;
			}	
			return null;
		}
		
		/**
		 * Abstract function get a item by id
		 */
		public function getItemById( $itemId ){ return array();}
		
		/**
		 * Abstract function : get list item by name of group
		 */
		public function getListByGroup( $name, $published=true ){ return array(); }
		
		/**
		 * Abstract function get list item by category id
		 */
		public function getListByCategoryId( $groupId, $published=true ){ return array(); }
		
		/**
		 *  Abstract function get list item by parameter
		 */
		public function getListByParameters( $params ){ return array(); }
	
	}
}
?>
