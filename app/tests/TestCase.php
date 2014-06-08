<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    protected $app_config = 'testing';

    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = TRUE;

        $testEnvironment = $this->app_config;

        return require __DIR__ . '/../../bootstrap/start.php';
    }

}
