<?php

namespace Leapt\CoreBundle\Controller;

use Leapt\CoreBundle\Feed\FeedManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

/**
 * Class FeedController.
 */
class FeedController
{
    private FeedManager $feedManager;

    private ValidatorInterface $validator;

    private Environment $twig;

    public function __construct(FeedManager $feedManager, ValidatorInterface $validator, Environment $twig)
    {
        $this->feedManager = $feedManager;
        $this->validator = $validator;
        $this->twig = $twig;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \ErrorException
     */
    public function indexAction(Request $request, string $feedName)
    {
        $feed = $this->feedManager->getFeed($feedName);

        $builtFeedItems = [];
        $items = $feed->getItems();
        foreach ($items as $item) {
            $builtItem = $feed->buildItem($item);
            $errors = $this->validator->validate($builtItem);
            if (0 < \count($errors)) {
                throw new \ErrorException('Invalid feed item');
            }
            $builtFeedItems[] = $builtItem;
        }

        return new Response($this->twig->render('@LeaptCore/Feed/index.' . $request->getRequestFormat() . '.twig', [
            'feed'     => $feed,
            'feedName' => $feedName,
            'locale'   => $request->getLocale(),
            'items'    => $builtFeedItems,
        ]));
    }
}
