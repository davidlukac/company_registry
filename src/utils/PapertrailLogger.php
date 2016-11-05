<?php

namespace davidlukac\company_registry\utils;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Logger;

/**
 * Class PapertrailLogger
 *
 * @package davidlukac\company_registry\utils
 */
class PapertrailLogger
{

    /** @var string Name of the logger. */
    private $name;
    /** @var string Papertrail endpoint hostname. */
    private $host;
    /** @var int Papertrail endpoint port. */
    private $port;
    /** @var string Logger output format. */
    private $format;

    /** @var \Psr\Log\LoggerInterface  */
    private $logger;
    /** @var \Monolog\Handler\SyslogUdpHandler */
    private $syslogHandler;

    /**
     * PapertrailLogger constructor.
     *
     * @param $name string Name of the logger.
     * @param $host string Papertrail endpoint hostname
     * @param $port int Papertrail endpoint port.
     * @param $format string Logger output format.
     */
    public function __construct($name, $host, $port, $format)
    {
        $this->name = $name;
        $this->host = $host;
        $this->port = $port;
        $this->format = $format;

        // Set the format.
        $formatter = new LineFormatter($this->format);

        // Setup the logger.
        $logger = new Logger($this->name);
        $syslogHandler = new SyslogUdpHandler($this->host, $this->port);
        $syslogHandler->setFormatter($formatter);
        $logger->pushHandler($syslogHandler);

        $logger->debug("Application logger initialized.");

        $this->logger = $logger;
        $this->syslogHandler = $syslogHandler;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return \Monolog\Handler\SyslogUdpHandler
     */
    public function getSyslogHandler()
    {
        return $this->syslogHandler;
    }
}
