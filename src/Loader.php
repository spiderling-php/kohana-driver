<?php

namespace SP\KohanaDriver;

use SP\Crawler\LoaderInterface;
use GuzzleHttp\Psr7;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Request;
use LogicException;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Loader implements LoaderInterface
{
    const MAX_REDIRECTS = 5;
    const USER_AGENT = 'Spiderling Kohana Driver';

    private $current = null;

    public function getKohanaRequest(ServerRequestInterface $request)
    {
        parse_str($request->getUri()->getQuery(), $query);

        $kohanaRequest = new Request((string) $request->getUri());
        $kohanaRequest->method($request->getMethod());
        $kohanaRequest->body((string) $request->getBody());
        $kohanaRequest->query($query);

        if ($request->getParsedBody()) {
            $kohanaRequest->post($request->getParsedBody());
        }

        if ($this->current) {
            $kohanaRequest->referrer((string) $this->current->getUri());
        }

        return $kohanaRequest;
    }

    private function executeKohanaRequest(ServerRequestInterface $request, $redirect = 0)
    {
        if ($redirect >= self::MAX_REDIRECTS) {
            throw new LogicException(sprintf(
                'Maximum Number of redirects (%s) for url %s',
                self::MAX_REDIRECTS,
                $request->getUri()
            ));
        }

        Request::$initial = $kohanaRequest = $this->getKohanaRequest($request);
        Request::$user_agent = self::USER_AGENT;

        $_FILES = $request->getAttribute('FILES');

        $kohanaResponse = $kohanaRequest->execute();

        $this->current = $request;
        $status = $kohanaResponse->status();

        if ($status >= 300 && $status < 400) {
            $redirectUri = new Psr7\Uri($kohanaResponse->headers('location'));

            $localUri = $redirectUri
                ->withScheme(null)
                ->withUserInfo(null)
                ->withHost(null)
                ->withPort(null);

            return $this->executeKohanaRequest(
                new Psr7\ServerRequest('GET', $localUri),
                $redirect + 1
            );
        }

        return $kohanaResponse;
    }

    /**
     * @param  ServerRequestInterface $request
     */
    public function send(ServerRequestInterface $request)
    {
        $kohanaResponse = $this->executeKohanaRequest($request);

        return new Psr7\Response(
            $kohanaResponse->status(),
            $kohanaResponse->headers()->getArrayCopy(),
            $kohanaResponse->body()
        );
    }

    /**
     * @return \Psr\Http\Message\UriInterface
     */
    public function getCurrentUri()
    {
        return $this->current ? $this->current->getUri() : new Psr7\Uri('');
    }
}
