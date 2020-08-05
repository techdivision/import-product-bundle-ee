<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Utils\SqlStatementKeys
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

namespace TechDivision\Import\Product\Bundle\Ee\Utils;

/**
 * Utility class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
