<?php
declare(strict_types=1);

namespace TechDeCo\ElasticApmAgent\Message;

use JsonSerializable;
use TechDeCo\ElasticApmAgent\Serialization;

final class Context implements JsonSerializable
{
    /**
     * @var mixed[]|null
     */
    private $custom;

    /**
     * @var Response|null
     */
    private $response;

    /**
     * @var Request|null
     */
    private $request;

    /**
     * @var string[]
     */
    private $tagList = [];

    /**
     * @var User|null
     */
    private $user;

    /**
     * @param mixed $value
     */
    public function withCustomVariable(string $name, $value): self
    {
        $me                = clone $this;
        $me->custom[$name] = $value;

        return $me;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function withResponse(Response $response): self
    {
        $me           = clone $this;
        $me->response = $response;

        return $me;
    }

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function withRequest(Request $request): self
    {
        $me          = clone $this;
        $me->request = $request;

        return $me;
    }

    public function withTag(string $tag, string $value): self
    {
        $me                = clone $this;
        $me->tagList[$tag] = $value;

        return $me;
    }

    public function withUser(User $user): self
    {
        $me       = clone $this;
        $me->user = $user;

        return $me;
    }

    /**
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return Serialization::filterUnset([
            'custom' => $this->custom,
            'response' => Serialization::serializeOr($this->response),
            'request' => Serialization::serializeOr($this->request),
            'tags' => $this->tagList,
            'user' => Serialization::serializeOr($this->user),
        ]);
    }
}
