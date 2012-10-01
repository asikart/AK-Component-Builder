<?php
/**
 * @version     1.0.0
 * @package     com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */


// no direct access
defined('_JEXEC') or die;

$item = $this->link_items ;

?>
<div class="items-more">

<h3><?php echo JText::_('COM_{COMPONENT_NAME_UC}_MORE_LINKS'); ?></h3>
<ol>
<?php
	foreach ($this->link_items as &$item) :
?>
	<li>
		<a href="<?php echo $item->a_link; ?>">
			<?php echo $item->a_title; ?></a>
	</li>
<?php endforeach; ?>
</ol>
</div>