/**
 * $ModDesc
 * 
 * @version	$Id: helper.php $Revision
 * @package	modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) May 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 */ 
// JavaScript Document
window.addEvent('load', function(){

 var controls=['group','enable_caption'];	
 
 if(  $defined($$('.paramlist tr')) && $$('.paramlist tr').length > 0 ) {  
	var trs = $ES('.paramlist tr');
	 trs.each( function(tr, index){
		var tmp = tr.getElement('td.paramlist_value .lof-group')
		if( tmp && tmp.getProperty('title') ){
			tr.addClass('group-'+tmp.getProperty('title')).addClass('icon-'+tmp.getProperty('title'));
			for( j=index+1; j < trs.length; j++ ){
				if( $defined(trs[j].getElement('td.paramlist_value .lof-end-group')) ) {
					trs[j].remove();
					break;
				}
				trs[j].addClass('group-'+tmp.getProperty('title')).addClass('lof-group-tr');
			}
			var title = tmp.getProperty('title');
			tmp.enable= true;
		}
	 });
	 function update( tmp, hide ){
		 	if( hide ){
				tmp.enable = true;
			}
		 	var title = tmp.value;
			if(  tmp.enable==false  && $defined(tmp.enable) ) {
				$ES('.admintable tr.group-'+title ).setStyle('display','');
				tmp.enable=true;

			} else if(title && title !=-1) {
				$ES('.admintable tr.group-'+title ).setStyle('display','none');
				tmp.enable=false;
			}
			setTimeout( function(){
				$E('.jpane-slider ').setStyle( 'height', $E('.paramlist').offsetHeight );
			}, 300 );
	 }
	 

	controls.each( function(_group){ 
		$ES('#params'+_group).addEvent('change',function(){
			var tmdp = this;
			tmdp.enable = false;
				update( this  );
			var selected = this;
			$ES('#params'+_group +' option').each( function(tmp, index){
					if(tmp.value !=selected.value ) {
						update( tmp, true );
					}
			} );
		});
		 $ES('#params'+_group+' option').each( function(tmp, index){
				if(!tmp.selected) {
					update( tmp );
				}

		} );
		
	} );
} else {
	var controls=['group','enable_caption'];
	controls.each( function(_group){ 
		$$('#params'+_group).addEvent('change',function(){
			 $$('.lof-group').hide();	
			 $$('.lof-'+this.value).show();
			 (function(){
				 var height = ($$('#menu-pane .jpane-slider')[0].getElement('.panelform-legacy').getHeight() );
				 $$('#menu-pane .jpane-slider')[0].setStyle('height', height ) ;
			 }).delay(300);
		});
		 $$('#params'+_group+' option').each(function(item){
			if( item.selected ){
			 $$('.lof-group').hide();	
				(function(){  $$('.lof-'+item.value).show(); }).delay(100);
				 (function(){
				 var height = ($$('#menu-pane .jpane-slider')[0].getElement('.panelform-legacy').getHeight() );
				 $$('#menu-pane .jpane-slider')[0].setStyle('height', height ) ;
				 }).delay(300);
				return ;
			}
		});
	} );
}
} );
