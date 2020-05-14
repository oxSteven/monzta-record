<?php

namespace Kiryi\MonztaRecord\Model;

use Kiryi\MonztaRecord\Helper\TagListReader;

class Record
{
    const CONTENTSTRUCTURE = [
        ['name', '## '],
        ['region', '**Region:** '],
        ['class', '**Class:** '],
        ['holder', '**Record Holder:** '],
        ['value', '**Record Value:** '],
        ['proof', '**Proof:** '],
    ];

    private int $id = 0;
    private array $tags = [];
    private string $name = '';
    private string $region = '';
    private string $class = '';
    private string $holder = '';
    private string $value = '';
    private string $proof = '';

	public function __construct(array $data)
	{
        $this->setId($data['id']);
        $this->setTags($data['tags']);

        $content = preg_split('/\n/', $data['content']);

        for ($i = 0; $i < count($content); $i++) {
            $content[$i] = str_replace($this::CONTENTSTRUCTURE[$i][1], '', $content[$i]);
            $setterName = 'set' . $this::CONTENTSTRUCTURE[$i][0];
            
            $this->$setterName($content[$i]);
        }
    }

    public function getProperties(): array
	{
        return get_object_vars($this);
    }

    private function setId(int $value): void
    {
        $this->id = $value;
    }

    private function setTags(array $currentTags): void
    {
        $tagList = (new TagListReader())->read();

        foreach ($tagList as $tag) {
            foreach ($currentTags as $currentTag) {
                if ($currentTag == $tag->id) {
                    $this->tags[] = $tag->name;
                }
            }
        }
    }

    private function setName(string $value): void
    {
        $this->name = $value;
    }

    private function setRegion(string $value): void
    {
        $this->region = strtoupper($value);
    }

    private function setClass(string $value): void
    {
        $this->class = $value;
    }

    private function setHolder(string $value): void
    {
        if ($value == '-') {
            $this->holder = 'n/a';
        } else {
            $this->holder = $value;
        }
    }

    private function setValue(string $value): void
    {
        if ($value == '-') {
            $this->value = 'n/a';
        } else {
            $this->value = $value;
        }
    }

    private function setProof(string $value): void
    {
        if ($value == '-') {
            $this->proof = '';
        } else {
            $this->proof = $value;
        }
    }
}
