<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../bootstrap/start.php';
	}

	public function setUp()
	{
		(new PdoExec)->execute('create database if not exists base_api_test_db');

		parent::setUp();
	}
}
