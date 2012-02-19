<?php
class xelFinder extends elFinder {

	/**
	 * Constructor
	 *
	 * @param  array  elFinder and roots configurations
	 * @return void
	 * @author Dmitry (dio) Levashov
	 **/
	public function __construct($opts) {
		parent::__construct($opts);
		$this->commands['perm'] = array('target' => true, 'perm' => true, 'umask' => false);
	}

	/**
	* Set perm
	*
	* @param  array  $args  command arguments
	* @return array
	* @author Dmitry (dio) Levashov
	**/
	protected function perm($args) {

		$target = $args['target'];

		if (($volume = $this->volume($target)) != false) {
			if (method_exists($volume, 'savePerm')) {
				if ($volume->commandDisabled('perm')) {
					return array('error' => $this->error(self::ERROR_PERM_DENIED));
				}

				$file = $volume->savePerm($target, $args['perm'], $args['umask']);
				return $file? array('changed' => array($file)) : array('error' => $this->error($volume->error()));
			}
		}
		return array('error' => $this->error(self::ERROR_UNKNOWN_CMD));
	}
}