<?php

/**
 * StreetSignal CSV Entity
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity;

use StreetSignal\Core\StaticEntity;

class CSV extends StaticEntity
{

    protected $id;
    protected $columns;
    protected $maps_to;
    protected $fixed;
    protected $filename;
    protected $mime;
    protected $size;
    protected $created;
    protected $updated;
    protected $completed;
    protected $status;
    protected $errors;
    protected $processed;
    protected $collection_id;

    // DataTransformer
    public function getDefinition()
    {
        return [
            'id'           => 'int',
            'columns'      => '*json',
            'maps_to'      => '*json',
            'fixed'        => '*json',
            'filename'     => 'string',
            'mime'         => 'string',
            'status'       => 'string',
            'errors'       => 'string',
            'processed'    => 'string',
            'created_ids'  => 'string',
            'collection_id'=> 'int',
            'size'         => 'int',
            'created'      => 'int',
            'updated'      => 'int',
            'completed'    => 'bool',
        ];
    }

    // Entity
    public function getResource()
    {
        return 'csv';
    }
}
