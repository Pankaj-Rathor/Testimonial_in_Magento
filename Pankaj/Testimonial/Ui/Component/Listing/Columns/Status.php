<?php
namespace Pankaj\Testimonial\Ui\Component\Listing\Columns;

class Status extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');
        foreach ($dataSource['data']['items'] as &$item) {
            if (isset($item[$fieldName])) {
                $item[$fieldName] = $this->getOptionText($item[$fieldName]);
            }
        }
        
        return $dataSource;
    }

    public function getOptionText($value)
    {
        $status_option = [
            0 => 'Disable',
            1 => 'Enable'
        ];
        return $status_option[$value];
    }
}

