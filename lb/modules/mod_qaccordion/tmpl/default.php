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
defined("_JEXEC") or die("Restricted Access");  ?>

<div id="qaccordion<?php echo $accordion->id; ?>" class="qaccordion">
   <?php foreach( $articles as $art ): ?>
  	 <h3 class="acc-header"><?php echo htmlspecialchars($art->title, ENT_QUOTES); ?></h3>
  	 <div class="acc-content">
      <?php echo $art->text; ?>
      <?php if($params->get('readMore', 0)) : ?>
        <a class="readon" href="<?php echo $art->href; ?>" title="<?php echo htmlspecialchars($art->title, ENT_QUOTES); ?>"><?php echo JText::_('READMORE'); ?></a>
      <?php endif; ?>
     </div>
   <?php endforeach; ?>
</div>