<?php
namespace Pankaj\Testimonial\Ui\Component\Listing;

use Pankaj\Testimonial\Model\ResourceModel\Testimonial\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = parent::getData();
        // // Modify the created_at column date format
        // if (isset($data['items'])) {
        //     foreach ($data['items'] as &$item) 
        //     {
        //         if (isset($item['updated_at'])) 
        //         {
        //             $item['updated_at'] = $this->helper->dateFormat($item['updated_at']);
        //         }
        //         if (isset($item['customer_id'])) 
        //         {
        //             if ($item['customer_id'] > 0) {
        //                 $item['customer_id'] = $this->helper->getCustomerNameById($item['customer_id']);
        //             }
        //         }
        //     }
        // }

        return $data;
    }

}