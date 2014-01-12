<?php

namespace Windwalker\Model;

/**
 * Class AbstractAdvancedModel
 *
 * @since 1.0
 */
abstract class AbstractAdvancedModel extends Model
{
	/**
	 * Context string for the model type.  This is used to handle uniqueness
	 * when dealing with the getStoreId() method and caching data structures.
	 *
	 * @var    string
	 * @since  12.2
	 */
	protected $context = '';
}
