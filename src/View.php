<?php

/**
 * This file is part of the miBadger package.
 *
 * @author Michael Webbers <michael@webbers.io>
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 */

namespace miBadger\Mvc;

/**
 * The view class of the MVC pattern.
 *
 * @see http://en.wikipedia.org/wiki/Model-view-controller
 * @since 1.0.0
 */
class View
{
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
			include $path;
		} catch (\Exception $e) {
			ob_get_clean();
			throw $e;
		}

		return ob_get_clean();
	}
}
