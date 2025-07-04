<?php

namespace StreetSignal\DataSource\Contracts;

/**
 * Base Interface for all Data Source
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    DataSource
 * @copyright  2013 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License Version 3 (GPLv3)
 */
interface DataSource
{

    /**
     * Constructor function for DataSource
     */
    // @todo add state store
    public function __construct(array $config);
    public function getName();
    public function getId();
    public function getServices();
    public function getOptions();
    public function getInboundFields();
    public function getInboundFormId();
    public function getInboundFieldMappings();
    public function isUserConfigurable();
}
