<?php

/**
 * This file is part of the miBadger package.
 *
 * @author Michael Webbers <michael@webbers.io>
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 */

namespace miBadger\Mvc;

use miBadger\Singleton\SingletonTrait;

/**
 * The view class of the MVC pattern.
 *
 * @see http://en.wikipedia.org/wiki/Model-view-controller
 * @since 1.0.0
 */
class View
{
	use SingletonTrait;

	const DIRECTORY_SEPARATOR = \DIRECTORY_SEPARATOR;

	/** @var string|null the base path. */
	private $basePath;

	/**
	 * Construct a object.
	 */
	protected function __construct()
	{
		$this->basePath = null;
	}

	/**
	 * Returns the base path.
	 *
	 * @return string|null the base path.
	 */
	public static function getBasePath()
	{
		return static::getInstance()->basePath;
	}

	/**
	 * Set the base path.
	 *
	 * @param string|null $basePath = null
	 */
	public static function setBasePath($basePath = null)
	{
		static::getInstance()->basePath = $basePath;
	}

	/**
	 * Returns the view at the given path with the given data.
	 *
	 * @param string $path
	 * @param string[] $data = []
	 * @return string a string representation of the view.
	 */
	public static function get($path, $data = [])
	{
		ob_start();

		extract($data);

		try {
			$basePath = static::getInstance()->basePath;

			if ($basePath !== null) {
				if (mb_substr($path, 0, 1) === static::DIRECTORY_SEPARATOR) {
					$path = mb_substr($path, 1);
				}

				if (mb_substr($basePath, -1) === static::DIRECTORY_SEPARATOR) {
					$basePath = mb_substr($basePath, 0, -1);
				}

				$path = $basePath . static::DIRECTORY_SEPARATOR . $path;
			}

			include $path;
		} catch (\Exception $e) {
			ob_get_clean();
			throw $e;
		}

		return ob_get_clean();
	}
}
