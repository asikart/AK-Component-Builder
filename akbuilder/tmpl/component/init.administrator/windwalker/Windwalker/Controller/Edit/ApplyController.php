<?php

namespace Windwalker\Controller\Edit;

use Windwalker\Controller\Admin\AbstractItemController;
use Windwalker\Model\Exception\ValidateFailException;

/**
 * Class SaveController
 *
 * @since 1.0
 */
class ApplyController extends SaveController
{
	/**
	 * postExecute
	 *
	 * @param null $return
	 *
	 * @return null
	 */
	protected function postExecute($return = null)
	{
		// Set the record data in the session.
		$this->recordId = $this->model->getState()->get($this->getName() . '.id');
		$this->holdEditId($this->context, $this->recordId);
		$this->app->setUserState($this->context . '.data', null);

		// $this->model->checkout($recordId);

		// Redirect back to the edit screen.
		$this->app->redirect(\JRoute::_($this->getRedirectItemUrl($this->recordId, $this->urlVar), false));

		return $return;
	}
}
