<?php
/**
 * php document by Asika
 */

defined('_JEXEC') or die;

define('AKBUILDER_PATH', __DIR__);

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Class AKBuilder
 *
 * @since 1.0
 */
class AKBuilder
{
	/**
	 * Property extension.
	 *
	 * @var string
	 */
	public $extension;

	/**
	 * Property ext_name.
	 *
	 * @var string
	 */
	public $ext_name;

	/**
	 * Property isNew.
	 *
	 * @var bool
	 */
	public $isNew = false;

	/**
	 * Property type.
	 *
	 * @var string
	 */
	public $type;

	/**
	 * Property target_path.
	 *
	 * @var
	 */
	public $target_path;

	/**
	 * Property tmpl_path.
	 *
	 * @var string
	 */
	public $tmpl_path;

	/**
	 * Property client.
	 *
	 * @var string
	 */
	public $client;

	/**
	 * Property replace_key.
	 *
	 * @var bool
	 */
	public $replace_key;

	/**
	 * Property addfiles.
	 *
	 * @var array
	 */
	public $addfiles = array();

	/**
	 * Property existsfiles.
	 *
	 * @var array
	 */
	public $existsfiles = array();

	/**
	 * Property convertfiles.
	 *
	 * @var array
	 */
	public $convertfiles = array();

	/**
	 * Property list_name.
	 *
	 * @var string
	 */
	protected $list_name = '';

	/**
	 * Property item_name.
	 *
	 * @var string
	 */
	protected $item_name = '';

	/**
	 * getInstance
	 *
	 * @param string $type
	 * @param string $extension_name
	 * @param string $client
	 * @param array  $option
	 *
	 * @return mixed
	 */
	public static function getInstance($type = 'component', $extension_name = 'com_custom', $client = 'administrator', $option = array())
	{
		static $instance;

		if (!isset($instance[$type][$client]))
		{
			include_once __DIR__ . '/type/' . $type . '.php';
			$class_name = __CLASS__ . ucfirst($type);
			$instance   = new $class_name($type, $extension_name, $client, $option);
		}

		return $instance;
	}

	/**
	 * @param string $type
	 * @param string $extension_name
	 * @param string $client
	 * @param array  $option
	 */
	public function __construct($type = 'cpmponent', $extension_name = 'com_custom', $client = 'administrator', $option = array())
	{
		$this->ext_name  = $extension_name;
		$this->extension = substr($extension_name, 4);
		$this->client    = $client;
		$this->type      = $type;
		$this->tmpl_path = AKBUILDER_PATH . '/tmpl/' . $this->type;
	}

	/**
	 * init
	 *
	 * @param string $name
	 * @param string $client
	 *
	 * @return void
	 */
	public function init($name = 'item.items', $client = 'administrator')
	{

	}

	/**
	 * convertTemplate
	 *
	 * @param string $name
	 *
	 * @return void
	 */
	public function convertTemplate($name = 'sakura.sakuras')
	{
		$files = JFolder::files($this->tmpl_path, '.', true, true);

		$tmpl = array();

		foreach ($files as $k => $v)
		{
			$tmpl[$k]['target']  = $this->replaceName($v, $name, true);
			$tmpl[$k]['content'] = $this->replaceName(JFile::read($v), $name, true);

			JFile::delete($v);
		}

		foreach ($tmpl as $v)
		{
			JFile::write($v['target'], $v['content']);
			$this->convertfiles[] = $v['target'];
		}

		// Delete Folders
		$folders = JFolder::folders($this->tmpl_path, $this->item_name, true, true);
		$folders = array_merge($folders, JFolder::folders($this->tmpl_path, $this->list_name, true, true));

		foreach ($folders as $v)
		{
			JFolder::delete($v);
		}
	}

	/**
	 * addSQL
	 *
	 * @param string $name
	 * @param string $client
	 *
	 * @return void
	 */
	public function addSQL($name = 'item.items', $client = 'administrator')
	{

	}

	/**
	 * addFile
	 *
	 * @param string $file
	 * @param string $name
	 * @param string $client
	 *
	 * @return bool
	 */
	public function addFile($file = 'controller.php', $name = 'item.items', $client = 'administrator')
	{
		$file_path = JPath::clean($this->tmpl_path . '/' . $file);

		if (!JFile::exists($file_path))
		{
			return false;
		}

		$content     = $this->replaceName(JFile::read($file_path, '.', true, true), $name);
		$target_path = $this->replaceName(JPath::clean($this->target_path . '/' . $file), $name);

		if (!JFile::exists($target_path))
		{
			JFile::write($target_path, $content);
			$this->addfiles[] = $target_path;
		}
		else
		{
			$this->existsfiles[] = $target_path;
		}
	}

	/**
	 * addFiles
	 *
	 * @param string $path
	 * @param string $name
	 * @param string $client
	 *
	 * @return void
	 */
	public function addFiles($path = 'controllers', $name = 'item.items', $client = 'administrator')
	{
		$path  = $path ? $this->tmpl_path . '/' . trim($path) : $this->tmpl_path;
		$files = JFolder::files($path, '.', true, true);

		$tmpl = array();

		foreach ($files as $k => $v)
		{
			$target_path         = str_replace(JPath::clean($this->tmpl_path), JPath::clean($this->target_path), JPath::clean($v));
			$tmpl[$k]['target']  = $this->replaceName($target_path, $name);
			$tmpl[$k]['content'] = $this->replaceName(JFile::read($v), $name);
		}

		foreach ($tmpl as $v)
		{
			if (!JFile::exists($v['target']))
			{
				JFile::write($v['target'], $v['content']);
				$this->addfiles[] = $v['target'];
			}
			else
			{
				$this->existsfiles[] = $v['target'];
			}
		}
	}

	/**
	 * replaceName
	 *
	 * @param string $content
	 * @param string $name
	 * @param bool   $flip
	 *
	 * @return string
	 */
	public function replaceName($content = '', $name = 'item.items', $flip = false)
	{
		// handles name item and name list
		if (!$this->replace_key)
		{
			$this->_buildReplaceKey($name);
		}

		$r = $this->replace_key;

		if ($flip)
		{
			$r = array_flip($r);
		}

		return strtr($content, $r);
	}

	/**
	 * _buildReplaceKey
	 *
	 * @param string $name
	 *
	 * @return void
	 */
	public function _buildReplaceKey($name = 'item.items')
	{
		// handles name item and name list
		$name            = explode('.', $name);
		$this->item_name = $name[0];
		$this->list_name = isset($name[1]) ? $name[1] : $name[0] . 's';
	}
}
