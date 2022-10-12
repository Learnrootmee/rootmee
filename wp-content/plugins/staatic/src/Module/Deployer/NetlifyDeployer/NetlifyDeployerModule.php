<?php

declare(strict_types=1);

namespace Staatic\WordPress\Module\Deployer\NetlifyDeployer;

use Staatic\Vendor\Symfony\Component\DependencyInjection\ServiceLocator;
use Staatic\Framework\ConfigGenerator\NetlifyConfigGenerator;
use Staatic\Framework\DeployStrategy\DeployStrategyInterface;
use Staatic\Framework\PostProcessor\ConfigGeneratorPostProcessor;
use Staatic\Framework\ResourceRepository\ResourceRepositoryInterface;
use Staatic\Framework\ResultRepository\ResultRepositoryInterface;
use Staatic\WordPress\Module\ModuleInterface;
use Staatic\WordPress\Publication\Publication;
use Staatic\WordPress\Service\Settings;

final class NetlifyDeployerModule implements ModuleInterface
{
    const DEPLOYMENT_METHOD_NAME = 'netlify';

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var ServiceLocator
     */
    private $settingLocator;

    /**
     * @var NetlifyDeployStrategyFactory
     */
    private $deployStrategyFactory;

    /**
     * @var ResultRepositoryInterface
     */
    private $resultRepository;

    /**
     * @var ResourceRepositoryInterface
     */
    private $resourceRepository;

    public function __construct(
        Settings $settings,
        ServiceLocator $settingLocator,
        NetlifyDeployStrategyFactory $deployStrategyFactory,
        ResultRepositoryInterface $resultRepository,
        ResourceRepositoryInterface $resourceRepository
    )
    {
        $this->settings = $settings;
        $this->settingLocator = $settingLocator;
        $this->deployStrategyFactory = $deployStrategyFactory;
        $this->resultRepository = $resultRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    public function hooks()
    {
        \add_action('init', [$this, 'registerSettings']);
        \add_action('wp_loaded', [$this, 'enableDeploymentMethod'], 20);
        if (!\is_admin()) {
            return;
        }
        \add_filter('staatic_deployment_methods', [$this, 'registerDeploymentMethod']);
    }

    /**
     * @return void
     */
    public function registerSettings()
    {
        $deployerSettings = [
            $this->settingLocator->get(AccessTokenSetting::class),
            $this->settingLocator->get(SiteIdSetting::class)
        ];
        foreach ($deployerSettings as $setting) {
            $this->settings->addSetting('staatic-deployment', $setting);
        }
    }

    /**
     * @return void
     */
    public function enableDeploymentMethod()
    {
        if (!$this->isSelectedDeploymentMethod()) {
            return;
        }
        \add_filter('staatic_post_processors', [$this, 'overridePostProcessors'], 10, 2);
        \add_filter('staatic_deployment_strategy', [$this, 'createDeploymentStrategy'], 10, 2);
    }

    private function isSelectedDeploymentMethod() : bool
    {
        return \get_option('staatic_deployment_method') === self::DEPLOYMENT_METHOD_NAME;
    }

    /**
     * @param mixed[] $deploymentMethods
     */
    public function registerDeploymentMethod($deploymentMethods) : array
    {
        $deploymentMethods[self::DEPLOYMENT_METHOD_NAME] = \__('Netlify', 'staatic');

        return $deploymentMethods;
    }

    /**
     * @param mixed[] $postProcessors
     * @param Publication $publication
     */
    public function overridePostProcessors($postProcessors, $publication) : array
    {
        $netlifyExtraConfig = \apply_filters('staatic_netlify_config_extra', '', $publication);
        $postProcessors[] = new ConfigGeneratorPostProcessor(
            $this->resultRepository,
            $this->resourceRepository,
            new NetlifyConfigGenerator(
            $this->notFoundPath(
            $publication
        ),
            (string) $netlifyExtraConfig
        )
        );

        return $postProcessors;
    }

    private function notFoundPath(Publication $publication) : string
    {
        $baseUrl = $publication->build()->destinationUrl();
        $notFoundPath = \get_option('staatic_page_not_found_path');
        if ($baseUrl->getPath() && $baseUrl->getPath() !== '/') {
            $notFoundPath = \rtrim($baseUrl->getPath(), '/') . '/' . \ltrim($notFoundPath);
        }

        return $notFoundPath;
    }

    /**
     * @param Publication $publication
     */
    public function createDeploymentStrategy($deploymentStrategy, $publication) : DeployStrategyInterface
    {
        return ($this->deployStrategyFactory)($publication);
    }
}
