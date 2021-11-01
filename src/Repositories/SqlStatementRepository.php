<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Repositories\SqlStatementRepository
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
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
 * @license   https://opensource.org/licenses/MIT
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
            'INSERT INTO ${table:sequence_product_bundle_option} VALUES ()',
        SqlStatementKeys::CREATE_SEQUENCE_PRODUCT_BUNDLE_SELECTION =>
            'INSERT INTO ${table:sequence_product_bundle_selection} VALUES ()',
        SqlStatementKeys::UPDATE_PRODUCT_BUNDLE_OPTION =>
            'UPDATE ${table:catalog_product_bundle_option}
                SET ${column-values:catalog_product_bundle_option}
              WHERE option_id = :option_id
                AND parent_id = :parent_id',
        SqlStatementKeys::UPDATE_PRODUCT_BUNDLE_SELECTION =>
            'UPDATE ${table:catalog_product_bundle_selection}
                SET ${column-values:catalog_product_bundle_selection}
              WHERE selection_id = :selection_id
                AND parent_product_id = :parent_product_id',
    );

    /**
     * Initializes the SQL statement repository with the primary key and table prefix utility.
     *
     * @param \IteratorAggregate<\TechDivision\Import\Dbal\Utils\SqlCompilerInterface> $compilers The array with the compiler instances
     */
    public function __construct(\IteratorAggregate $compilers)
    {

        // pass primary key + table prefix utility to parent instance
        parent::__construct($compilers);

        // compile the SQL statements
        $this->compile($this->statements);
    }
}
