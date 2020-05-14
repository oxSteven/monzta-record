<?php

namespace Kiryi\Flaryi\Endpoint;

class User extends Endpoint
{
    const APIENDPOINT = 'users';

    public function get(int $userId, ?array $responseFields = null): object
    {
        $this->setType('GET');
        $this->setUri($this->setEndpointId($userId));
        $this->setUri($this->setResponseFields($responseFields));
        $this->setBody();

        try {
            return $this->call();
        } catch (\Exception $e) {
            throw new \Exception(sprintf($this::NOTFOUND, 'User', 'ID', $userId));
        }
    }

    public function getAll(?array $responseFields = null): array
    {
        $responseCollection = [];
        $pageOffset = 0;

        while ($pageOffset >= 0) {
            $this->setType('GET');
            $this->setUri($this->setResponseFields($responseFields));
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

    public function setGroups(int $userId, array $groupIds = null): object
    {
        $groupJson = '';

        if ($groupIds!== null) {
            foreach ($groupIds as $groupId) {
                $groupJson .= $this->createDataObjectJson('groups', $groupId);
                $groupJson .= ',';
            }
            
            $groupJson = substr($groupJson, 0, -1);
        }

        $this->setType('PATCH');
        $this->setUri($this->setEndpointId($userId));
        $this->setBody(sprintf($this->getJsonBody(), $groupJson));

        return $this->call();
    }
}
