<?php

namespace StreetSignal\Tests\Unit\Core\Traits;

class MockDataTransformer
{
    use \StreetSignal\Core\Concerns\TransformData;

    protected function getDefinition()
    {
        return [
            'date' => '*date',
        ];
    }

    public function pTransform($data)
    {
        return $this->transform($data);
    }
}
