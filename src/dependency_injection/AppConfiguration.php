<?php

namespace davidlukac\company_registry\dependency_injection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class AppConfiguration
 *
 * @package davidlukac\company_registry\dependency_injection
 */
class AppConfiguration implements ConfigurationInterface
{
    /** @var array $config Processed configuration array. */
    private $config;

    /**
     * AppConfiguration constructor.
     *
     * See constructor of the Container class.
     *
     * @param array $config Processed configuration array.
     *
     * @link davidlukac\company_registry\dependency_injection\Container
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return bool
     */
    public function isInDebugMode()
    {
        return (bool) $this->config['debug'];
    }

    /**
     * String representation of the 'Debug' flag.
     *
     * @return string
     */
    public function isInDebugModeStr()
    {
        return (string) var_export($this->config['debug'], true);
    }

    /**
     * @return string
     */
    public function getPapertrailHost()
    {
        return (string) $this->config['papertrail_host'];
    }

    /**
     * @return int
     */
    public function getPapertrailPort()
    {
        return (int) $this->config['papertrail_port'];
    }

    /**
     * @inheritdoc
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('parameters');
        $rootNode
            ->children()
                ->booleanNode('debug')
                    ->defaultFalse()
                ->end()
                ->scalarNode('papertrail_host')
                    ->defaultValue('papertrailapp.com')
                ->end()
                ->integerNode('papertrail_port')
                    ->defaultValue('1234')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
