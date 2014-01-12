<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

?>

<h1>{CONTROLLER_NAMES_UCFIRST} View</h1>

<ul>
	<?php foreach ($data->items as $item): ?>
	<li>
		<?php echo $item->title; ?>
	</li>
	<?php endforeach; ?>
</ul>
