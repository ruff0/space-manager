<?php

namespace Mosaiqo\Cqrs\Tests;

use Mockery as m;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{

	/**
	 * Tears Down the tests
	 */
	public function tearDown()
	{
		m::close();
	}
}
