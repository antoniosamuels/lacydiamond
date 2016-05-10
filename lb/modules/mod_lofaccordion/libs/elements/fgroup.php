<?php 
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	mod_lofflashcontent
 * @copyright	Copyright (C) JAN 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @license		GNU General Public License version 2
 */
defined('_JEXEC') or die( 'Restricted access' );
/**
 * Get a collection of categories
 */
class JElementFgroup extends JElement {
	
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'fgroup';
	
	/**
	 * fetch Element 
	 */
	function fetchElement($name, $value, &$node, $control_name){
		$mediaPath = JURI::root(). str_replace(DS, '/', str_replace(JPATH_ROOT, '',dirname(dirname(dirname(__FILE__))))).'/assets/';
		JHTML::stylesheet(  'form.css', $mediaPath );	
		
		
		$attributes = $node->attributes();
		$class = isset($attributes['group']) && trim($attributes['group']) == 'end' ? 'lof-end-group' : 'lof-group'; 
		$title =  isset($attributes['title']) ?  JText::_($attributes['title']):'Group';
		$title =  isset($attributes['title']) ?  JText::_($attributes['title']):'';
	
		
			$version = new 	JVersion();
		
		if( $version->RELEASE != '1.6' ){				
			$string = '<div  class="'.$class.'">'.$title.'</div>';
			if(!defined('LOF_ADDED_TIME')){
				$string .= '<input type="hidden" class="text_area" value="'.time().'" id="paramsmain_lof_added_time" name="params[lof_added_time]">';
				define('LOF_ADDED_TIME',1);	
			}
		} else {
			$for = "";
			if( $class == 'lof-group') {
				$string = '<div  class="'.$class.' lof-'.$for.'" style="clear:both; display:block" title="'.$for.'"><div class="lof-title" style="clear:both">'.$title.'</div>';
			} else if( $class== 'lof-end-group' ) {
				$string = '</div>';
			}
		}
		return $string;
	}
}

?>