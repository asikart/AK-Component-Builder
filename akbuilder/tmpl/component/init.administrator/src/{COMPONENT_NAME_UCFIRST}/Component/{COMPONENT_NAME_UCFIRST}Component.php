<?php

namespace {COMPONENT_NAME_UCFIRST}\Component;

use Windwalker\Component\Component;
use Windwalker\Debugger\Debugger;
use Windwalker\Helper\LanguageHelper;
use Windwalker\Helper\ProfilerHelper;

/**
 * Class {COMPONENT_NAME_UCFIRST}Component
 *
 * @since 1.0
 */
abstract class {COMPONENT_NAME_UCFIRST}Component extends Component
{
	/**
	 * Property name.
	 *
	 * @var string
	 */
	protected $name = '{COMPONENT_NAME_UCFIRST}';

	/**
	 * prepare
	 *
	 * @return  void
	 */
	protected function prepare()
	{
		// Legacy debug
		define('AKDEBUG', true);

		if (JDEBUG)
		{
			Debugger::registerWhoops();
		}

		// Load language
		$lang = $this->container->get('language');

		LanguageHelper::loadAll($lang->getTag(), $this->option);

		parent::prepare();
	}

	/**
	 * postExecute
	 *
	 * @param mixed $result
	 *
	 * @return  mixed
	 */
	protected function postExecute($result)
	{
		// Debug profiler
		if (JDEBUG)
		{
			$result .= "<hr />" . ProfilerHelper::render('Windwalker', true);
		}

		return parent::postExecute($result);
	}
}
