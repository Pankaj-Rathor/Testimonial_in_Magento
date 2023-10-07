<?php
namespace Pankaj\Testimonial\Model\ResourceModel\Testimonial;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
	protected $_eventPrefix = 'pankaj_testimonial_testimonial_collection';
	protected $_eventObject = 'testimonial_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Pankaj\Testimonial\Model\Testimonial', 'Pankaj\Testimonial\Model\ResourceModel\Testimonial');
    }
}
