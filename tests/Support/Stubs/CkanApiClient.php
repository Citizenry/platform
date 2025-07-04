<?php

namespace Germanazo\CkanApi;

/**
 * Stub implementation of CkanApiClient for testing
 */
class CkanApiClient
{
    protected $client;

    public function __construct($client = null)
    {
        $this->client = $client;
    }

    public function dataset()
    {
        return new class {
            public function show($id)
            {
                return ['result' => ['id' => $id]];
            }

            public function create($data)
            {
                return ['result' => array_merge($data, ['id' => 'test-id'])];
            }

            public function update($data)
            {
                return ['result' => $data];
            }
        };
    }

    public function resource()
    {
        return new class {
            public function create($data)
            {
                return ['result' => array_merge($data, ['id' => 'test-resource-id'])];
            }
        };
    }
}