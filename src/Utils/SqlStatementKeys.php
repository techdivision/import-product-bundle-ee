<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Utils\SqlStatementKeys
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Bundle\Ee\Utils;

/**
 * Utility class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */
class SqlStatementKeys extends \TechDivision\Import\Product\Bundle\Utils\SqlStatementKeys
{

    /**
     * The SQL statement to create a new sequence product bundle option value.
     *
     * @var string
     */
    const CREATE_SEQUENCE_PRODUCT_BUNDLE_OPTION = 'create.sequence_product_bundle_option';

    /**
     * The SQL statement to create a new sequence product bundle selection value.
     *
     * @var string
     */
    const CREATE_SEQUENCE_PRODUCT_BUNDLE_SELECTION = 'create.sequence_product_bundle_selection';
}
