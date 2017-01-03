<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Observers\EeBundleOptionObserverTest
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

use TechDivision\Import\Utils\EntityStatus;
use TechDivision\Import\Utils\StoreViewCodes;
use TechDivision\Import\Product\Bundle\Utils\MemberNames;

/**
 * Test class for the EE bundle option observer implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */
class EeBundleOptionObserverTest extends \PHPUnit_Framework_TestCase
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
            0  => $sku = '24-WG080',
            1  => null,
            2  => 'dynamic',
            3  => 'dynamic',
            4  => 'Price range',
            5  => 'dynamic',
            6  => null,
            7  => $bundleValueName = 'Sprite Stasis Ball',
            8  => $bundleValueType = 'radio',
            9  => $bundleValueRequired = 1,
            10 => '24-WG081-blue',
            11 => 0.0000,
            12 => 1,
            13 => 1.0000,
            14 => 'fixed'
        );

        // initialize the product bundle option to be persisted
        $productBundleOption = array(
            EntityStatus::MEMBER_NAME => EntityStatus::STATUS_CREATE,
            MemberNames::PARENT_ID    => $parentId = 1000,
            MemberNames::REQUIRED     => $bundleValueRequired,
            MemberNames::POSITION     => $position = 1,
            MemberNames::TYPE         => $bundleValueType
        );

        // create a persist processor mock instance
        $mockSubject = $this->getMock('TechDivision\Import\Product\Bundle\Ee\Subjects\EeBundleSubject');
        $mockSubject->expects($this->once())
                    ->method('mapSkuToRowId')
                    ->with($sku)
                    ->willReturn($parentId);
        $mockSubject->expects($this->any())
                    ->method('getHeaders')
                    ->willReturn($headers);
        $mockSubject->expects($this->once())
                    ->method('getStoreViewCode')
                    ->with(StoreViewCodes::ADMIN)
                    ->willReturn(StoreViewCodes::ADMIN);
        $mockSubject->expects($this->once())
                    ->method('exists')
                    ->with($bundleValueName)
                    ->willReturn(false);
        $mockSubject->expects($this->once())
                    ->method('persistProductBundleOption')
                    ->with($productBundleOption)
                    ->willReturn(null);

        // create a mock for the EE bundle option observer
        $mockObserver = $this->getMockBuilder('TechDivision\Import\Product\Bundle\Ee\Observers\EeBundleOptionObserver')
                             ->setMethods(array('getSubject'))
                             ->getMock();
        $mockObserver->expects($this->any())
                     ->method('getSubject')
                    ->willReturn($mockSubject);

        // test the handle() method
        $this->assertSame($row, $mockObserver->handle($row));
    }
}
