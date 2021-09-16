<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Actions\SequenceProductBundleOptionAction
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

use TechDivision\Import\Dbal\Utils\EntityStatus;
use TechDivision\Import\Dbal\Collection\Actions\AbstractAction;

/**
 * An action implementation that provides CRUD functionality for EE product bundle option sequence block.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/wagnert/import-product-bundle-ee
 * @link      http://www.appserver.io
 */
class SequenceProductBundleOptionAction extends AbstractAction implements SequenceProductBundleOptionActionInterface
{

    /**
     * Helper method that create/update the passed entity, depending on
     * the entity's status.
     *
     * @param array       $row  The entity data to create/update
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return string The last inserted ID
     */
    public function persist(array $row, $name = null)
    {

        // load the method name
        $methodName = $row[EntityStatus::MEMBER_NAME];

        // invoke the method
        return $this->$methodName($row, $name);
    }

    /**
     * Creates's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to create
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return string The last inserted ID
     */
    public function create(array $row, $name = null)
    {
        return $this->getCreateProcessor()->execute($row, $name);
    }

    /**
     * Return's the next available sequence product bundle option value.
     *
     * @return integer The next available sequence product bundle option value
     */
    public function nextIdentifier()
    {
        return $this->getCreateProcessor()->execute(array());
    }
}
