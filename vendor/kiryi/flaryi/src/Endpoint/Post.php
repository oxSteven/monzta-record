<?php

namespace Kiryi\Flaryi\Endpoint;

class Post extends Endpoint
{
    const APIENDPOINT = 'posts';

    public function get(int $postId, ?array $responseFields = null): object
    {
        $this->setType('GET');
        $this->setUri($this->setEndpointId($postId));
        $this->setUri($this->setResponseFields($responseFields));
        $this->setBody();

        try {
            return $this->call();
        } catch (\Exception $e) {
            throw new \Exception(sprintf($this::NOTFOUND, 'Post', 'ID', $postId));
        }
    }

    public function getAll(?array $responseFields = null, ?string $filter = null): array
    {
        $responseCollection = [];
        $pageOffset = 0;

        while ($pageOffset >= 0) {
            $this->setType('GET');
            $this->setUri($this->setResponseFields($responseFields));
            $this->setUri($this->setFilter($filter));
            $this->setUri($this->setPagination($pageOffset));
            $this->setBody();
    
            $response = $this->call();
    
            foreach ($response->data as $data) {
                $responseCollection[] = $data;
            }
                
            if (isset($response->links->next)) {
                $pageOffset = $pageOffset + 20;
            } else {
                $pageOffset = -1;
            }
        }
        
        return $responseCollection;
    }

    public function create(string $userId, string $discussionId, string $content): object
    {
        $this->setType('POST');
        $this->setUri();
        $this->setBody(sprintf(
            $this->getJsonBody(),
            $content,
            $userId,
            $discussionId
        ));
        
        return $this->call();
    }
}
