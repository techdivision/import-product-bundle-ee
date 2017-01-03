<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Observers\EeBundleOptionValueUpdateObserver
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

use TechDivision\Import\Product\Bundle\Observers\BundleOptionValueUpdateObserver;

/**
 * Oberserver that provides functionality for the bundle option value add/update operation for the
 * Magento 2 EE edition.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */
class EeBundleOptionValueUpdateObserver extends BundleOptionValueUpdateObserver
{

    /**
     * Return the row ID for the passed SKU.
     *
     * @param string $sku The SKU to return the row ID for
     *
     * @return integer The mapped row ID
     * @throws \Exception Is thrown if the SKU is not mapped yet
     */
    protected function mapSku($sku)
    {
        return $this->getSubject()->mapSkuToRowId($sku);
    }
}
