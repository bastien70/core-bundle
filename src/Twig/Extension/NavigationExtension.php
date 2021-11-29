<?php

namespace Leapt\CoreBundle\Twig\Extension;

use Leapt\CoreBundle\Navigation\NavigationRegistry;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavigationExtension extends AbstractExtension
{
    public function __construct(private NavigationRegistry $registry)
    {
    }

    /**
     * Get all available functions.
     *
     * @codeCoverageIgnore
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('set_active_paths', [$this, 'setActivePaths']),
            new TwigFunction('add_active_path', [$this, 'addActivePath']),
            new TwigFunction('get_active_paths', [$this, 'getActivePaths']),
            new TwigFunction('is_active_path', [$this, 'isActivePath']),
            new TwigFunction('append_breadcrumb', [$this, 'appendBreadcrumb']),
            new TwigFunction('prepend_breadcrumb', [$this, 'prependBreadcrumb']),
            new TwigFunction('get_breadcrumbs', [$this, 'getBreadCrumbs']),
        ];
    }

    /**
     * Set the paths to be considered as active (navigation-wise).
     *
     * @param array $paths an array of URI paths
     */
    public function setActivePaths(array $paths)
    {
        $this->registry->setActivePaths($paths);
    }

    /**
     * Add a path to be considered as active (navigation-wise).
     *
     * @param array $paths an array of URI paths
     */
    public function addActivePath($path)
    {
        $this->registry->addActivePath($path);
    }

    /**
     * Get the active paths previously set.
     */
    public function getActivePaths(): array
    {
        return $this->registry->getActivePaths();
    }

    /**
     * Checks if the provided path is to be considered as active.
     */
    public function isActivePath(string $path): bool
    {
        return $this->registry->isActivePath($path);
    }

    public function appendBreadcrumb(string $path, string $label): void
    {
        $this->registry->appendBreadcrumb($path, $label);
    }

    public function prependBreadcrumb(string $path, string $label): void
    {
        $this->registry->prependBreadcrumb($path, $label);
    }

    public function getBreadcrumbs(): array
    {
        return $this->registry->getBreadcrumbs();
    }
}
