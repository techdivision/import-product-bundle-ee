<?php

/**
 * TechDivision\Import\Product\Bundle\Ee\Observers\EeBundleOptionObserver
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

use TechDivision\Import\Dbal\Utils\EntityStatus;
use TechDivision\Import\Observers\StateDetectorInterface;
use TechDivision\Import\Observers\AttributeLoaderInterface;
use TechDivision\Import\Observers\EntityMergers\EntityMergerInterface;
use TechDivision\Import\Product\Bundle\Utils\MemberNames;
use TechDivision\Import\Product\Bundle\Observers\BundleOptionObserver;
use TechDivision\Import\Product\Bundle\Services\ProductBundleProcessorInterface;
use TechDivision\Import\Product\Bundle\Ee\Actions\SequenceProductBundleOptionActionInterface;

/**
 * Oberserver that provides functionality for the bundle option replace operation for the
 * Magento 2 EE edition.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-bundle-ee
 * @link      http://www.techdivision.com
 */
class EeBundleOptionObserver extends BundleOptionObserver
{

    /**
     * The sequence product bundle option action instance.
     *
     * @var \TechDivision\Import\Product\Bundle\Ee\Actions\SequenceProductBundleOptionActionInterface
     */
    protected $sequenceProductBundleOptionAction;

    /**
     * Initialize the observer with the passed product bundle processor instance.
     *
     * @param \TechDivision\Import\Product\Bundle\Services\ProductBundleProcessorInterface              $productBundleProcessor            The product bundle processor instance
     * @param \TechDivision\Import\Product\Bundle\Ee\Actions\SequenceProductBundleOptionActionInterface $sequenceProductBundleOptionAction The action instance
     * @param \TechDivision\Import\Observers\AttributeLoaderInterface|null                              $attributeLoader                   The attribute loader instance
     * @param \TechDivision\Import\Observers\EntityMergers\EntityMergerInterface                        $entityMerger                      The entity merger instance
     * @param \TechDivision\Import\Observers\StateDetectorInterface|null                                $stateDetector                     The state detector instance
     */
    public function __construct(
        ProductBundleProcessorInterface $productBundleProcessor,
        SequenceProductBundleOptionActionInterface $sequenceProductBundleOptionAction,
        AttributeLoaderInterface $attributeLoader = null,
        EntityMergerInterface $entityMerger = null,
        StateDetectorInterface $stateDetector = null
    ) {

        // initialize the parent instance
        parent::__construct($productBundleProcessor, $attributeLoader, $entityMerger, $stateDetector);

        // set the passed sequence product bundle option action instance
        $this->sequenceProductBundleOptionAction = $sequenceProductBundleOptionAction;
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

        // query whether or not, we found a new product bundle option
        if ($attr[EntityStatus::MEMBER_NAME] === EntityStatus::STATUS_CREATE) {
            $attr[MemberNames::OPTION_ID] = $this->nextIdentifier();
        }

        // return the attributes
        return $attr;
    }

    /**
     * Returns the sequence product bundle option action instance.
     *
     * @return \TechDivision\Import\Product\Bundle\Ee\Actions\SequenceProductBundleOptionActionInterface The action instance
     */
    protected function getSequenceProductBundleOptionAction()
    {
        return $this->sequenceProductBundleOptionAction;
    }

    /**
     * Returns the next available product bundle option ID.
     *
     * @return integer The next available product bundle option ID
     */
    protected function nextIdentifier()
    {
        return $this->getSequenceProductBundleOptionAction()->nextIdentifier();
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
