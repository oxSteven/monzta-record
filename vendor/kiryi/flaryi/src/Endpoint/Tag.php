<?php

namespace Kiryi\Flaryi\Endpoint;

class Tag extends Endpoint
{
    const APIENDPOINT = 'tags';

    public function get(int $tagId): object
    {
        $tags = $this->getAll();

        foreach ($tags->data as $tag) {
            if ($tag->id == $tagId) {
                return $tag;
            }
        }

        throw new \Exception(sprintf($this::NOTFOUND, 'Tag', 'ID', $tagId));
    }

    public function getAll(): object
    {
        $this->setType('GET');
        $this->setUri();
        $this->setBody();

        return $this->call();
    }

    public function getByName(string $tagName): object
    {
        $tags = $this->getAll();

        foreach ($tags->data as $tag) {
            if ($tag->attributes->name == $tagName) {
                return $tag;
            }
        }

        throw new \Exception(sprintf($this::NOTFOUND, 'Tag', 'Name', $tagName));
    }
}
