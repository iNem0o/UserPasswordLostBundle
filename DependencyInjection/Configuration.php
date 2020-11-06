<?php

namespace inem0o\UserPasswordLostBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('user_password_lost');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->scalarNode('user_repo_name')->isRequired()->end()
                ->scalarNode('user_email_column_name')->isRequired()->end()
                ->scalarNode('email_from')->isRequired()->end()
                ->scalarNode('route_to_redirect_on_failure')->isRequired()->end()
                ->scalarNode('route_to_redirect_on_success')->isRequired()->end()
                ->booleanNode('display_success_flashbag')->isRequired()->end()
                ->arrayNode('forms')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('constraints')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('field')->isRequired()->end()
                                    ->enumNode('form_name')->isRequired()
                                        ->values(array('form_new_password', 'form_password_request'))
                                    ->end()
                                    ->scalarNode('class')->isRequired()->end()
                                    ->arrayNode('params')->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
