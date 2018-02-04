<?php

/**
 * This file is part of the miBadger package.
 *
 * @author Michael Webbers <michael@webbers.io>
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 */

namespace miBadger\Mvc;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use org\bovigo\vfs\vfsStreamWrapper;
use PHPUnit\Framework\TestCase;

/**
 * The view test.
 *
 * @since 1.0.0
 */
class ViewTest extends TestCase
{
	public function setUp()
	{
		vfsStreamWrapper::register();
		vfsStreamWrapper::setRoot(new vfsStreamDirectory('test'));
		vfsStreamWrapper::getRoot()->addChild(new vfsStreamFile('file.txt'));

		file_put_contents(vfsStream::url('test/file.txt'), '<?php echo $name; ?>');
	}

	public function testGet()
	{
		$this->assertEquals('value', View::get(vfsStream::url('test/file.txt'), ['name' => 'value']));
	}

	/**
	 * @expectedException \PHPUnit\Framework\Error\Warning
	 * @expectedExceptionMessage vfs://test/fake.txt
	 * @expectedExceptionCode 2
	 */
	public function testGetException()
	{
		View::get(vfsStream::url('test/fake.txt'));
	}
}
