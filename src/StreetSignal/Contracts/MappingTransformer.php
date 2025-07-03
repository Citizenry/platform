<?php

/**
 * StreetSignal Platform User Defined Mapping Transformer
 *
 * A user defined transform, transforms records based on
 * - a source-destination mapping
 * - a set of fixed destination values
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface MappingTransformer extends Transformer
{
    public function setColumnNames(array $columnNames);
    public function setMap(array $map);
    public function setFixedValues(array $fixedValues);
}
