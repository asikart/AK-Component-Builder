<?php
/**
 * @package		Asikart Joomla! Module {EXTENSION_NAME_UCFIRST}
 * @subpackage	mod_{EXTENSION_NAME}
 * @copyright	Copyright (C) 2012 Asikart.com, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="{EXTENSION_NAME}-module-wrap<?php echo $moduleclass_sfx; ?>">
	<div class="{EXTENSION_NAME}-module-wrap-inner">
		
		<ul class="{EXTENSION_NAME}-module-list nav nav-tabs nav-stacked">
		<?php foreach( $items as $item ): ?>
			<li class="{EXTENSION_NAME}-module-list-item">
				<?php echo JHtml::_('link', $item->link, "{$item->a_created} - {$item->a_title}"); ?>
			</li>
		<?php endforeach; ?>
		</ul>
		
	</div>
</div>