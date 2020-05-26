<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Observers\EeBundleOptionObserver
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
use TechDivision\Import\Observers\StateDetectorInterface;
use TechDivision\Import\Observers\AttributeLoaderInterface;
use TechDivision\Import\Product\Bundle\Utils\MemberNames;
use TechDivision\Import\Product\Bundle\Observers\BundleSelectionObserver;
use TechDivision\Import\Product\Bundle\Services\ProductBundleProcessorInterface;
use TechDivision\Import\Product\Bundle\Ee\Actions\SequenceProductBundleSelectionActionInterface;

/**
 * Oberserver that provides functionality for the bundle selection replace operation for the
 * Magento 2 EE edition.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */
class EeBundleSelectionObserver extends BundleSelectionObserver
{

    /**
     * The sequence product bundle selection action instance.
     *
     * @var \TechDivision\Import\Product\Bundle\Ee\Actions\SequenceProductBundleSelectionActionInterface
     */
    protected $sequenceProductBundleSelectionAction;

    /**
     * Initialize the observer with the passed product bundle processor instance.
     *
     * @param \TechDivision\Import\Product\Bundle\Services\ProductBundleProcessorInterface                 $productBundleProcessor               The product bundle processor instance
     * @param \TechDivision\Import\Product\Bundle\Ee\Actions\SequenceProductBundleSelectionActionInterface $sequenceProductBundleSelectionAction The action instance
     * @param \TechDivision\Import\Observers\AttributeLoaderInterface|null                                 $attributeLoader                      The attribute loader instance
     * @param \TechDivision\Import\Observers\StateDetectorInterface|null                                   $stateDetector                        The state detector instance
     */
    public function __construct(
        ProductBundleProcessorInterface $productBundleProcessor,
        SequenceProductBundleSelectionActionInterface $sequenceProductBundleSelectionAction,
        AttributeLoaderInterface $attributeLoader = null,
        StateDetectorInterface $stateDetector = null
    ) {

        // initialize the parent instance
        parent::__construct($productBundleProcessor, $attributeLoader, $stateDetector);

        // set the passed sequence product bundle selection action instance
        $this->sequenceProductBundleSelectionAction = $sequenceProductBundleSelectionAction;
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributes()
    {

        // prepare the attributes
        $attr = parent::prepareAttributes();

        // query whether or not, we found a new product bundle selection
        if ($attr[EntityStatus::MEMBER_NAME] === EntityStatus::STATUS_CREATE) {
            $attr[MemberNames::SELECTION_ID] = $this->nextIdentifier();
        }

        // return the attributes
        return $attr;
    }

    /**
     * Returns the sequence product bundle selection action instance.
     *
     * @return \TechDivision\Import\Product\Bundle\Ee\Actions\SequenceProductBundleSelectionActionInterface The action instance
     */
    protected function getSequenceProductBundleSelectionAction()
    {
        return $this->sequenceProductBundleSelectionAction;
    }

    /**
     * Returns the next available product bundle option ID.
     *
     * @return integer The next available product bundle option ID
     */
    protected function nextIdentifier()
    {
        return $this->getSequenceProductBundleSelectionAction()->nextIdentifier();
    }

    /**
     * Returns the row ID for the passed SKU.
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
