<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Repositories\SqlStatementRepository
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

namespace TechDivision\Import\Product\Bundle\Ee\Repositories;

use TechDivision\Import\Product\Bundle\Ee\Utils\SqlStatementKeys;

/**
 * Repository class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */
class SqlStatementRepository extends \TechDivision\Import\Product\Bundle\Repositories\SqlStatementRepository
{

    /**
     * The SQL statements.
     *
     * @var array
     */
    private $statements = array(
        SqlStatementKeys::CREATE_SEQUENCE_PRODUCT_BUNDLE_OPTION =>
            'INSERT INTO sequence_product_bundle_option VALUES ()',
        SqlStatementKeys::CREATE_SEQUENCE_PRODUCT_BUNDLE_SELECTION =>
            'INSERT INTO sequence_product_bundle_selection VALUES ()',
        SqlStatementKeys::CREATE_PRODUCT_BUNDLE_OPTION =>
            'INSERT
                   INTO catalog_product_bundle_option
                        (option_id,
                         parent_id,
                         required,
                         position,
                         type)
                 VALUES (:option_id,
                         :parent_id,
                         :required,
                         :position,
                         :type)',
        SqlStatementKeys::CREATE_PRODUCT_BUNDLE_SELECTION =>
            'INSERT
                   INTO catalog_product_bundle_selection
                        (selection_id,
                         option_id,
                         parent_product_id,
                         product_id,
                         position,
                         is_default,
                         selection_price_type,
                         selection_price_value,
                         selection_qty,
                         selection_can_change_qty)
                 VALUES (:selection_id,
                         :option_id,
                         :parent_product_id,
                         :product_id,
                         :position,
                         :is_default,
                         :selection_price_type,
                         :selection_price_value,
                         :selection_qty,
                         :selection_can_change_qty)'
    );

    /**
     * Initialize the the SQL statements.
     */
    public function __construct()
    {

        // call the parent constructor
        parent::__construct();

        // merge the class statements
        foreach ($this->statements as $key => $statement) {
            $this->preparedStatements[$key] = $statement;
        }
    }
}
