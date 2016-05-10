<?php
/**
 * @version     $Id: ie6.css.php 571 2010-10-11 19:41:23Z martin $
 * @package     Joomla
 * @subpackage  mmTopPanel
 * @author      Martin Gray <author [at] mmPlugins.com>
 * @copyright   Copyright (C) 2009-2010 mmPlugins | All rights reserved
 * @license     GNU/GPL v.2
 * @see         /plugins/system/mmtoppanel/LICENSE.php
 */

$base = $_GET['base'];
$skin = $_GET['skin'];
?>
#mmToppanel {
    display: inline-block; /* IE hack to get tab connecting with panel */
}
li.module.mod_login .inputbox {
    height: 21px;
    width: 154px;
}

li.module.mod_login .inputbox {
    height: 21px;
    width: 154px;
}

    #mmToppanel.tab #mmToppanel-handle a {
        background:none;
        filter: progid:dximagetransform.microsoft.alphaimageloader(src='<?php echo $base; ?>plugins/system/mmtoppanel/skins/<?php echo $skin; ?>/images/handle-left.png', sizingmethod='crop');
    }
        #mmToppanel-handle a span {
            /*
            background:none;
            filter: progid:dximagetransform.microsoft.alphaimageloader(src='<?php echo $base; ?>plugins/system/mmtoppanel/skins/<?php echo $skin; ?>/images/handle-right.png', sizingmethod='crop');*/
        }
        #mmToppanel.tab #mmToppanel-handle-bar.expanded #mmToppanel-handle a span {
            /*
            background:none;
            filter: progid:dximagetransform.microsoft.alphaimageloader(src='<?php echo $base; ?>plugins/system/mmtoppanel/skins/<?php echo $skin; ?>/images/handle-right-up.png', sizingmethod='crop');*/
        }

