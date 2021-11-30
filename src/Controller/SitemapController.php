<?php

namespace Leapt\CoreBundle\Controller;

use Leapt\CoreBundle\Sitemap\SitemapManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class SitemapController
{
    public function __construct(
        private SitemapManager $sitemapManager,
        private RouterInterface $router,
        private Environment $twig,
        private HttpKernelInterface $httpKernel,
    ) {
    }

    public function defaultAction(Request $request): Response
    {
        $sitemaps = $this->sitemapManager->getSitemaps();

        if (1 < \count($sitemaps)) {
            return new Response($this->twig->render('@LeaptCore/Sitemap/index.xml.twig', ['sitemaps' => $sitemaps]));
        } elseif (1 === \count($sitemaps)) {
            $subRequest = $request->duplicate([], null, [
                '_controller' => 'Leapt\CoreBundle\Controller\SitemapController::sitemapAction',
                'sitemap'     => current($sitemaps)->getAlias(),
            ]);

            return $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
        }
        throw new \UnexpectedValueException('No sitemap has been defined');
    }

    public function sitemapAction(string $sitemap): Response
    {
        $sitemap = $this->sitemapManager->getSitemap($sitemap);
        $sitemap->build($this->router);

        return new Response($this->twig->render('@LeaptCore/Sitemap/sitemap.xml.twig', ['sitemap' => $sitemap]));
    }
}
