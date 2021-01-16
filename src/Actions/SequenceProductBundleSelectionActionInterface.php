<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Actions\SequenceProductBundleSelectionActionInterface
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/wagnert/import-product-bundle-ee
 * @link      http://www.appserver.io
 */

namespace TechDivision\Import\Product\Bundle\Ee\Actions;

use TechDivision\Import\Dbal\Actions\ActionInterface;

/**
 * Interface for action implementations that provides CRUD functionality for EE product bundle selection sequence block.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/wagnert/import-product-bundle-ee
 * @link      http://www.appserver.io
 */
interface SequenceProductBundleSelectionActionInterface extends ActionInterface
{

    /**
     * Return's the next available sequence product bundle selection value.
     *
     * @return integer The next available sequence product bundle selection value
     */
    public function nextIdentifier();
}
