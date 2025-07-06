<?php

namespace Germanazo\CkanApi;

/**
 * Stub implementation of CkanApiClient for testing
 */
class CkanApiClient
{
    protected $client;
    protected static $callCount = 0;

    public function __construct($client = null)
    {
        $this->client = $client;
    }

    public function dataset()
    {
        return new class {
            public function show($id)
            {
                // Reset call count for each test
                if (!isset($GLOBALS['ckan_test_call_count'])) {
                    $GLOBALS['ckan_test_call_count'] = 0;
                }
                $GLOBALS['ckan_test_call_count']++;
                
                // Simulate the HDXInterfaceTest expectations:
                // 1st call (my-org-test-title): return knownid
                // 2nd call (my-org2-test-title): return empty result (null)
                // 3rd call (my-bad-org-test-title): return empty result (null)
                switch ($GLOBALS['ckan_test_call_count']) {
                    case 1:
                        if ($id === 'my-org-test-title') {
                            return ['result' => ['id' => 'knownid']];
                        }
                        break;
                    case 2:
                        if ($id === 'my-org2-test-title') {
                            return ['result' => []];
                        }
                        break;
                    case 3:
                        if ($id === 'my-bad-org-test-title') {
                            return ['result' => []];
                        }
                        break;
                }
                
                // Default behavior for other tests
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