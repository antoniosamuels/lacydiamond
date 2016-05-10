<?php
/**
 * @version     $Id: mmbackground.php 547 2010-09-17 21:26:21Z martin $
 * @package     Joomla
 * @subpackage  System - mmBackground
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmbackground/LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );
jimport( 'joomla.filesystem.folder' );

class plgSystemMmbackground extends JPlugin
{
    var $constrainRatio = false;
    var $dimensions = array();

    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @param   object      $subject The object to observe
     * @param   array       $config  An array that holds the plugin configuration
     * @since   1.0
     */
    function plgSystemMmbackground(&$subject, $config)  {
        parent::__construct($subject, $config);
    }

    function onAfterDispatch()
    {
        $app =& JFactory::getApplication();
        if ( $app->getName() != 'site' ) return true;

        $document =& JFactory::getDocument();

        $this->constrainRatio = $this->params->get( 'constrain_ratio', 0 );

        // Make sure mootools is loaded
        JHTML::_( 'behavior.mootools' );

        if ( JApplication::getCfg( 'debug' ) && file_exists( JPATH_PLUGINS.DS.'system'.DS.'mmbackground'.DS.'assets'.DS.'js'.DS.'mmbackground.source.js' ) ) JHTML::_( 'script', 'mmbackground.source.js', 'plugins/system/mmbackground/assets/js/' );
        else JHTML::_( 'script', 'mmbackground.min.js', 'plugins/system/mmbackground/assets/js/' );

        if ( JApplication::getCfg( 'debug' ) && file_exists( JPATH_PLUGINS.DS.'system'.DS.'mmbackground'.DS.'assets'.DS.'js'.DS.'mmstage.source.js' ) ) JHTML::_( 'script', 'mmstage.source.js', 'plugins/system/mmbackground/assets/js/' );
        else JHTML::_( 'script', 'mmstage.min.js', 'plugins/system/mmbackground/assets/js/' );

        $jsImages       = '';
        $itemidImage    = $this->params->get( 'image_itemid1', array() );
        $tImage         = $this->params->get( 'image_t1', array() );
        $dtImage        = $this->params->get( 'image_dt1', array() );
        $imageDir       = $this->params->get( 'directory', '' );


        if ( isset( $itemidImage[0] ) && $itemidImage[0] != '' ) { // check if image is set against Itemid

            // we're applying specific backgrounds based on the Itemid
            $jsImages = $this->_getImageOnItemid();

        } elseif ( isset( $tImage[0] ) && $tImage[0] != '' ) { // check if image is set against time

            // we're applying specific backgrounds based on the user' local time (if logged in)
            $jsImages = $this->_getImageOnTime();

        } elseif ( isset( $dtImage[0] ) && $dtImage[0] != '' ) { // check if image is set against date and time

            // we're applying specific backgrounds based on the user' local time (if logged in)
            $jsImages = $this->_getImageOnDateTime();

        } elseif ( $imageDir != '' ) { // Check if a directory is nominated.

            // we are rotating images from that directory
            $images = JFolder::files( JPATH_ROOT.$imageDir, '.gif|.jpg|.png', false, false );
            $jsImages = '';
            $count = 0;
            foreach ( $images as $i => $image ) {
                if ( $count > 0 ) $jsImages .= ', ';
                $imagePath = $this->_getImagePath( $image, $imageDir );

                if ( $this->constrainRatio ) $this->_measureImage( $imageDir.DS.$image );

                $jsImages .= "'".$imagePath."'";
                $count++;
            }

        } else {
            // we're simply rendering a single image to the background
            $image = $this->params->get( 'image', '' );
            $this->params->bind( array('rotate' => false) );
            $jsImages = "'".JURI::root().$image."'";
            if ( $this->constrainRatio ) $this->_measureImage( $image );
        }

        // hack -> get rid of unwanted scroll bars
        // @todo re-enable scroll when window size becomes smaller then the site width ..
        $document->addStyleDeclaration("
            html { overflow: hidden !important; }
        ");
        $overlayImage = $this->params->get( 'overlay_image', '' );
        if ( $overlayImage != '' ) $overlayImage = JURI::root()."plugins/system/mmbackground/assets/images/overlay/".$overlayImage;


        $jsDimensions = '';
        if ( $this->constrainRatio ) {
            $count = 0;
            $jsDimensions = '';
            foreach ($this->dimensions as $img) {
                $count++;
                if ($count > 1) $jsDimensions .= ',';
                $jsDimensions .= "{x: '".$img['x']."',y: '".$img['y']."',ratio: '".$img['ratio']."'}";
            }
        }

        // Add some css to make the wrapper behave as desired
        $document->addStyleDeclaration("
            #mmWrapper { scroll: auto; position: absolute; z-index: 1; top: 0px; left: 0px; overflow: auto; overflow-x: hidden; }
        ");
        // Add script that initialises mmBackground
        $document->addScriptDeclaration("
            var mmBgRotate          = ".$this->params->get( 'rotate', 0 ).";
            var mmBgInterval        = ".$this->params->get( 'interval', 5000 ).";
            var mmBgTransition      = '".$this->params->get( 'transition', 'linear' )."';
            var mmBgEase            = '".$this->params->get( 'ease', '' )."';
            var mmBgDuration        = ".$this->params->get( 'duration', 2000 ).";
            var mmBgImageOpacity    = ".$this->params->get( 'image_opacity', 1 ).";

            var mmBgColor           = '".$this->params->get( 'background_color', '#000000' )."';
            var mmBgOpacity         = ".$this->params->get( 'background_opacity', 1 ).";

            var mmBgOverlayImage    = '".$overlayImage."';
            var mmBgOverlayColor    = '".$this->params->get( 'overlay_color', '' )."';
            var mmBgOverlayOpacity  = ".$this->params->get( 'overlay_opacity', 0.5 ).";

            var mmBgStretch         = ".$this->params->get( 'stretch', 1 ).";
            var mmBgConstrainRatio  = ".$this->params->get( 'constrain_ratio', 0 ).";
            var mmBgAlign           = '".$this->params->get( 'align', 'center' )."';
            var mmBgVerticalAlign   = '".$this->params->get( 'vertical_align', 'middle' )."';
            var mmBgRepeat          = '".$this->params->get( 'repeat', 'no-repeat')."';
            var mmBgPosition        = '".$this->params->get( 'background_position', '50% 0%' )."';

            if (mmBgEase != '' && mmBgTransition != 'linear') var mmBgAniFx = Fx.Transitions[mmBgTransition][mmBgEase];
            else var mmBgAniFx = Fx.Transitions[mmBgTransition];
            if (mmBgEase == '' && mmBgTransition == 'Elastic') var mmBgAniFx = Fx.Transitions[mmBgTransition]['easeOut'];

            var theStage = null;
            window.addEvent('domready', function() {
                // init mmStage
                theStage = new mmStage({
                    element: 'mmStage',
                    onInit: function() {
                        var mmWrapper = new wdgtWrapper(this, {});
                        this.registerWidget('mmWrapper', mmWrapper);
                        var mmBackground = new wdgtBackground(this, {
                            images: [".$jsImages."],
                            dimensions: [".$jsDimensions."],
                            rotate: { active: mmBgRotate, interval: mmBgInterval, transition: mmBgAniFx, duration: mmBgDuration },
                            background: { opacity: mmBgOpacity, color: mmBgColor },
                            image: { opacity: mmBgImageOpacity },
                            overlay: { image: mmBgOverlayImage, opacity: mmBgOverlayOpacity, color: mmBgOverlayColor },
                            stretch: mmBgStretch,
                            constrain_ratio: mmBgConstrainRatio,
                            align: mmBgAlign,
                            vertical_align: mmBgVerticalAlign,
                            bgRepeat: mmBgRepeat,
                            bgPosition: mmBgPosition
                        });
                        this.registerWidget('mmBackground', mmBackground);
                    }
                });
            });
        ");
    }

    function _getImageOnItemid()
    {
        // if regular image is set, use this as fallback image
        $image = $this->params->get( 'image', '' );
        $this->params->bind( array('rotate' => false) );

        $subject = $this->params->_raw;
        $pattern = '/image_itemid[0-9]{1,}/';
        preg_match_all( $pattern, $subject, $matches, PREG_OFFSET_CAPTURE );
        $total = count( $matches[0] );

        // convert array to array indexed on Itemid
        $images = array();
        for ( $i = 1; $i <= $total; $i++ ) {
            $key = "image_itemid".$i;
            $im = $this->params->get( $key, array() );
            if ( isset( $im[0] ) && $im[0] != '' && isset( $im[1] ) && $im[1] != ''  ) { // check if image is specified && an Itemid is set
                $images[$im[1]] = $im[0];
            }
        }

        $menu       = &JSite::getMenu();
        $menuItem   = &$menu->getActive();

        if ( isset ( $menuItem->id ) && array_key_exists( $menuItem->id, $images ) ) {
            $image = $images[$menuItem->id];
        }

        if ( $this->constrainRatio ) $this->_measureImage( $image );

        return "'".$this->_getImagePath( $image )."'";
    }

    function _getImageOnTime()
    {
        global $mainframe;

        // if regular image is set, use this as fallback image
        $image = $this->params->get( 'image', '' );
        $this->params->bind( array('rotate' => false) );

        $offset = $mainframe->getCfg( 'offset' );
        $user =& JFactory::getUser();

        if ( $user->get( 'id' ) != 0 ) {
            $userParams = $user->getParameters();
            $offset     = $userParams->get( 'timezone' );
        }
        $date =& JFactory::getDate( 'now' );
        $date->setOffset( $offset );

        $localTime = $date->toUnix();

        $subject = $this->params->_raw;
        $pattern = '/image_t[0-9]{1,}/';
        preg_match_all( $pattern, $subject, $matches, PREG_OFFSET_CAPTURE );
        $total = count( $matches[0] );

        for ( $i = 1; $i <= $total; $i++ ) {
            $key = "image_t".$i;
            $im = $this->params->get( $key, array() );
            if ( isset( $im[0] ) && $im[0] != '' ) {

                // check if time matches client time
                $timeStart  = mktime( (int) $im[1], (int) $im[2], 0, date('m', $localTime), date('j', $localTime), date('Y', $localTime) );
                $timeEnd    = mktime( (int) $im[3], (int) $im[4], 0, date('m', $localTime), date('j', $localTime), date('Y', $localTime) );
                if ( (int) $im[1] < (int) $im[3]) $timeEnd = mktime( (int) $im[3], (int) $im[4], 0, date('m', $localTime), date('j', $localTime)+1, date('Y', $localTime) );

                $dateStart =& JFactory::getDate( $timeStart );
                //$start = $dateStart->toUnix();
                $dateEnd =& JFactory::getDate( $timeEnd );
                //$end = $dateEnd->toUnix();

                if ( $date->toFormat('%H%M') >= $dateStart->toFormat('%H%M') && $date->toFormat('%H%M') < $dateEnd->toFormat('%H%M') ) {
                //if ( $localTime >= $start && $localTime < $end ) {
                    $image = $im[0];
                }
            }
        }

        if ( $this->constrainRatio ) $this->_measureImage( $image );

        return "'".$this->_getImagePath( $image )."'";
    }

    function _getImageOnDateTime()
    {
        global $mainframe;

        // if regular image is set, use this as fallback image
        $image = $this->params->get( 'image', '' );
        $this->params->bind( array('rotate' => false) );


        $offset = $mainframe->getCfg( 'offset' );
        $user =& JFactory::getUser();

        if ( $user->get( 'id' ) != 0 ) {
            $userParams = $user->getParameters();
            $offset     = $userParams->get( 'timezone' );
        }
        $date =& JFactory::getDate( 'now' );
        $date->setOffset( $offset );

        $localDateTime = $date->toFormat();

        $subject = $this->params->_raw;
        $pattern = '/image_dt[0-9]{1,}/';
        preg_match_all( $pattern, $subject, $matches, PREG_OFFSET_CAPTURE );
        $total = count( $matches[0] );

        for ( $i = 1; $i <= $total; $i++ ) {
            $key = "image_dt".$i;
            $im = $this->params->get( $key, array() );

            if ( isset( $im[0] ) && $im[0] != '' ) {
                if ( $localDateTime >= $im[1] && $localDateTime < $im[2] ) {
                    $image = $im[0];
                }
            }
        }

        if ( $this->constrainRatio ) $this->_measureImage( $image );

        return "'".$this->_getImagePath( $image )."'";
    }

    function _getImagePath( $image, $imageDir = '' )
    {
        $imageDir = str_replace('\\', '/', $imageDir);
        $url = JURI::root();
        if ( substr( $url, strlen( $url )-1, strlen( $url ) ) != '/' ) $url .= '/';
        if ( $imageDir != '') {
            if ( substr( $imageDir, strlen( $imageDir )-1, strlen( $imageDir ) ) != '/' ) $imageDir .= '/';
            if ( substr( $imageDir, 0, 1 ) == '/' ) $imageDir = substr( $imageDir, 1, strlen( $imageDir ) );
            $url .= $imageDir;
        }
        if (substr( $image, 0, 1 ) == '/') $image = substr( $image, 1, strlen( $image ) );
        return $url . $image;
    }

    function _measureImage( $image )
    {
        static $count = 0;

        $size = getimagesize( JPATH_ROOT.DS.$image );
        $info['x'] = $size[0];
        $info['y'] = $size[1];
        $info['ratio'] = $size[0] / $size[1];

        $this->dimensions[] = $info;
        $count++;
    }

    function onAfterRender()
    {
        $app =& JFactory::getApplication();
        if ( $app->getName() != 'site' ) return true;

        $pattern = "/<body[0-9a-zA-Z=\s\"_-]{0,}>/";
        preg_match( $pattern, JResponse::getBody(), $matches );
        $bodyOpen = $matches[0];

        // wrapping body contents with required markup
        JResponse::setBody(str_replace($bodyOpen, $bodyOpen.'<div id="mmStage"><div id="mmWrapper">', JResponse::getBody()));
        JResponse::setBody(str_replace('</body>', '</div></div>'.'</body>', JResponse::getBody()));

        return true;
    }
}
