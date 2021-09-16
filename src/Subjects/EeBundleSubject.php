<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Subjects\EeBundleSubject
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Bundle\Ee\Subjects;

use TechDivision\Import\Utils\RegistryKeys;
use TechDivision\Import\Product\Ee\Subjects\EeBunchSubject;
use TechDivision\Import\Product\Bundle\Subjects\BundleSubjectTrait;

/**
 * A subject implementation that provides extended functionality for importing
 * bundles in Magento 2 EE edition.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */
class EeBundleSubject extends EeBunchSubject
{

    /**
     * The trait that provides the functionality to handle bundle import on subject level.
     *
     * @var \TechDivision\Import\Product\Bundle\Subjects\BundleSubjectTrait
     */
    use BundleSubjectTrait;

    /**
     * Intializes the previously loaded global data for exactly one variants.
     *
     * @param string $serial The serial of the actual import
     *
     * @return void
     */
    public function setUp($serial)
    {

        // invoke the parent method
        parent::setUp($serial);

        // load the entity manager and the registry processor
        $registryProcessor = $this->getRegistryProcessor();

        // load the status of the actual import process
        $status = $registryProcessor->getAttribute(RegistryKeys::STATUS);

        // load the SKU => row/entity ID mapping
        $this->skuRowIdMapping = $status[RegistryKeys::SKU_ROW_ID_MAPPING];
        $this->skuEntityIdMapping = $status[RegistryKeys::SKU_ENTITY_ID_MAPPING];
    }
}
