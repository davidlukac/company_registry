<?php

namespace davidlukac\company_registry\dependency_injection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Container
 *
 * @package davidlukac\company_registry\dependency_injection
 */
class Container
{

    private $applicationRootDir;
    private $appConfigDir;

    /** @var ContainerBuilder */
    private $container;

    /** @var \davidlukac\company_registry\dependency_injection\AppConfiguration */
    private $config;

    /**
     * Container constructor.
     *
     * @param string $applicationRootDir
     */
    public function __construct($applicationRootDir)
    {
        $this->applicationRootDir = $applicationRootDir;
        $this->appConfigDir = $applicationRootDir . '/../app/config';
        $this->container = new ContainerBuilder();

        $config = Yaml::parse(file_get_contents($this->appConfigDir . '/parameters.yml'));
        $processor = new Processor();
        $configuration = new AppConfiguration([]);
        $processedConfig = $processor->processConfiguration($configuration, $config);

        $this->config = new AppConfiguration($processedConfig);
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return \davidlukac\company_registry\dependency_injection\AppConfiguration
     */
    public function getConfiguration()
    {
        return $this->config;
    }
}
