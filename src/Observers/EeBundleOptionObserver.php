<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Observers\EeBundleOptionObserver
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Bundle\Ee\Observers;

use TechDivision\Import\Utils\StoreViewCodes;
use TechDivision\Import\Product\Bundle\Utils\ColumnKeys;
use TechDivision\Import\Product\Bundle\Observers\BundleOptionObserver;

/**
 * A SLSB that handles the process to import product bunches.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */
class EeBundleOptionObserver extends BundleOptionObserver
{

    /**
     * {@inheritDoc}
     * @see \Importer\Csv\Actions\Listeners\Row\ListenerInterface::handle()
     */
    public function handle(array $row)
    {

        // load the header information
        $headers = $this->getHeaders();

        // initialize the store view code
        $storeViewCode = $row[$headers[ColumnKeys::STORE_VIEW_CODE]] ?: StoreViewCodes::ADMIN;

        if ($storeViewCode !== StoreViewCodes::ADMIN) {
            return $row;
        }

        // load the product bundle option name/SKU
        $name = $row[$headers[ColumnKeys::BUNDLE_VALUE_NAME]];
        $parentSku = $row[$headers[ColumnKeys::BUNDLE_PARENT_SKU]];

        // load parent/option ID
        $parentId = $this->mapSkuToRowId($parentSku);

        // query whether or not the option has already been created
        if (!$this->exists($name)) {
            // reset the position counter for the bundle selection
            $this->resetPositionCounter();

            // extract the parent/child ID as well as type and position
            $required = $row[$headers[ColumnKeys::BUNDLE_VALUE_REQUIRED]];
            $type = $row[$headers[ColumnKeys::BUNDLE_VALUE_TYPE]];
            $position = 1;

            // persist the product bundle option
            $optionId = $this->persistProductBundleOption(array($parentId, $required, $position, $type));

            // store the name => option ID mapping
            $this->addNameOptionIdMapping($name, $optionId);
        }

        // returns the row
        return $row;
    }

    /**
     * Return the row ID for the passed SKU.
     *
     * @param string $sku The SKU to return the row ID for
     *
     * @return integer The mapped row ID
     * @throws \Exception Is thrown if the SKU is not mapped yet
     */
    public function mapSkuToRowId($sku)
    {
        return $this->getSubject()->mapSkuToRowId($sku);
    }
}
