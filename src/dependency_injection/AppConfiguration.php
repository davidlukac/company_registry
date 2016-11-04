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
            ->end()
        ;

        return $treeBuilder;
    }
}
