<?php

namespace davidlukac\company_registry\dependency_injection;

use davidlukac\company_registry\utils\PapertrailLogger;
use Monolog\Logger;
use Silex\Provider\MonologServiceProvider;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

/**
 * Class Container
 *
 * @package davidlukac\company_registry\dependency_injection
 */
class Container
{

    private $appWebRootDir;
    private $appConfigDir;

    /** @var ContainerBuilder */
    private $container;

    /** @var \davidlukac\company_registry\dependency_injection\AppConfiguration */
    private $config;

    /** @var \Psr\Log\LoggerInterface Application logger. */
    private $logger;

    /** @var PapertrailLogger */
    private $loggerWrapper;

    private $application;

    /**
     * Container constructor.
     *
     * @param string $appWebRootDir
     * @param \Pimple\Container $application
     */
    public function __construct($appWebRootDir, \Pimple\Container $application)
    {
        $this->appWebRootDir = $appWebRootDir;
        $this->application = $application;
        $this->appConfigDir = $appWebRootDir . '/../app/config';
        $this->container = new ContainerBuilder();

        $config = (new Parser())->parse(file_get_contents($this->appConfigDir . '/parameters.yml'));

        $processor = new Processor();
        $configuration = new AppConfiguration([]);
        $processedConfig = $processor->processConfiguration($configuration, $config);

        $this->config = new AppConfiguration($processedConfig);
        $this->logger = $this->initializeLogger();

        // Initialise the application.
        $this->application['debug'] = $this->getConfiguration()->isInDebugMode();

        $monologConfig = [];
        if ($this->application['debug']) {
            $monologConfig['monolog.logfile'] = $this->appWebRootDir . '/../log/development.log';
        }
        $this->application->register(new MonologServiceProvider(), $monologConfig);

        $syslogHandler = $this->loggerWrapper->getSyslogHandler();
        $this->application->extend('monolog', function ($monolog) use ($syslogHandler) {
            /** @var Logger $monolog */
            $monolog->pushHandler($syslogHandler);
            return $monolog;
        });

        $this->getLogger()->info("Debug mode: '{$this->getConfiguration()->isInDebugModeStr()}'.");
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

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Create, setup and return instance of configured logger.
     *
     * @return \Psr\Log\LoggerInterface
     */
    private function initializeLogger()
    {
        // Set the format.
        $outputFormat = "%channel%.%level_name%: %message%";

        $this->loggerWrapper = new PapertrailLogger(
            'company_registry',
            $this->getConfiguration()->getPapertrailHost(),
            $this->getConfiguration()->getPapertrailPort(),
            $outputFormat
        );

        $this->loggerWrapper->getLogger()->debug("Application logger initialized.");
        return $this->loggerWrapper->getLogger();
    }
}
