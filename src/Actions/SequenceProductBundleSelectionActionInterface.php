<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Actions\SequenceProductBundleSelectionActionInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   https://opensource.org/licenses/MIT
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
 * @license   https://opensource.org/licenses/MIT
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
