<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div id="mmToppanel" class="mmtoppanel<?php echo $this->params->get( 'panelclass_sfx', '' ); ?> tab" style="margin-top: -1000px; position: absolute;">
    <div id="mmToppanel-inner">
        <div id="mmToppanel-wrapper">
            <div id="mmToppanel-content">
                <?php if ( !empty( $mmToppanelModule ) ): ?>
                <ul>
                    <li class="module <?php echo $mmToppanelModule->module; ?>">
                    <?php if ($mmToppanelModule->showtitle): ?>
                        <h3><?php echo $mmToppanelModule->title; ?></h3>
                    <?php endif; ?>

                    <?php echo JModuleHelper::renderModule( $mmToppanelModule ); ?>

                    <div style="clear: both; height: 1px; overflow: hidden;"></div>
                    </li>
                </ul>
                <?php endif; ?>
                <div style="clear: both; height: 1px; overflow: hidden;"></div>
            </div>
            <div style="clear: both; height: 1px; overflow: hidden;"></div>
        </div>
    </div>
    <div id="mmToppanel-handle-bar">
        <div id="mmToppanel-handle" class="align-<?php echo $this->params->get( 'handle_orientation', 'right' ); ?>">
            <a href="javascript: void(0);" id="mmToppanel-handle-a" class="expanded">
                <span class="expanded"><?php echo strip_tags($this->params->get( 'text_up', '' )); ?></span>
                <span class="collapsed"><?php echo strip_tags($this->params->get( 'text_down', '' )); ?></span>
            </a>
        </div>
    </div>
</div>