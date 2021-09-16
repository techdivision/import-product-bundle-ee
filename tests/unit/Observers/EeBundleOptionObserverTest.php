<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Observers\EeBundleOptionObserverTest
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Bundle\Ee\Observers;

use PHPUnit\Framework\TestCase;
use TechDivision\Import\Product\Bundle\Utils\ColumnKeys;

/**
 * Test class for the EE bundle option observer implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */
class EeBundleOptionObserverTest extends TestCase
{

    /**
     * Test's the handle() method successfull.
     *
     * @return void
     */
    public function testHandleWithSuccess()
    {

        // initialize the headers row
        $headers = array(
            'bundle_parent_sku'        =>  0,
            'store_view_code'          =>  1,
            'bundle_sku_type'          =>  2,
            'bundle_price_type'        =>  3,
            'bundle_price_view'        =>  4,
            'bundle_weight_type'       =>  5,
            'bundle_shipment_type'     =>  6,
            'bundle_value_name'        =>  7,
            'bundle_value_type'        =>  8,
            'bundle_value_required'    =>  9,
            'bundle_value_sku'         => 10,
            'bundle_value_price'       => 11,
            'bundle_value_default'     => 12,
            'bundle_value_default_qty' => 13,
            'bundle_value_price_type'  => 14
        );

        // initialize a data row
        $row = array(
            0  => '24-WG080',
            1  => $storeViewCode = null,
            2  => 'dynamic',
            3  => 'dynamic',
            4  => 'Price range',
            5  => 'dynamic',
            6  => null,
            7  => $bundleValueName = 'Sprite Stasis Ball',
            8  => 'radio',
            9  => 1,
            10 => '24-WG081-blue',
            11 => 0.0000,
            12 => 1,
            13 => 1.0000,
            14 => 'fixed'
        );

        // create a persist processor mock instance
        $mockSubject = $this->getMockBuilder('TechDivision\Import\Product\Bundle\Ee\Subjects\EeBundleSubject')
                            ->disableOriginalConstructor()
                            ->setMethods(
                                array(
                                    'mapSkuToRowId',
                                    'getHeader',
                                    'hasHeader',
                                    'getHeaders',
                                    'getStoreViewCode',
                                    'getRow'
                                )
                            )
                            ->getMock();
        $mockSubject->expects($this->any())
                    ->method('getHeaders')
                    ->willReturn($headers);
        $mockSubject->expects($this->any())
                    ->method('getRow')
                    ->willReturn($row);
        $mockSubject->expects($this->any())
                    ->method('hasHeader')
                    ->withConsecutive(array(ColumnKeys::STORE_VIEW_CODE), array(ColumnKeys::BUNDLE_VALUE_NAME))
                    ->willReturnOnConsecutiveCalls(true, true);
        $mockSubject->expects($this->any())
                    ->method('getHeader')
                    ->withConsecutive(array(ColumnKeys::STORE_VIEW_CODE), array(ColumnKeys::BUNDLE_VALUE_NAME))
                    ->willReturn($storeViewCode, $bundleValueName);

        // create a mock for the EE bundle option observer
        $mockObserver = $this->getMockBuilder('TechDivision\Import\Product\Bundle\Ee\Observers\EeBundleOptionObserver')
                             ->disableOriginalConstructor()
                             ->setMethods(array('getSubject'))
                             ->getMock();
        $mockObserver->expects($this->any())
                     ->method('getSubject')
                    ->willReturn($mockSubject);

        // test the handle() method
        $this->assertSame($row, $mockObserver->handle($mockSubject));
    }
}
