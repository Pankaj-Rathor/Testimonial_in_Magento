<?php
namespace Pankaj\Testimonial\Ui\Component\Listing\Columns;

class Actions extends \Magento\Ui\Component\Listing\Columns\Column
{

    const URL_PATH_DELETE = 'testimonial/testimonial/delete';
    const URL_PATH_EDIT = 'testimonial/testimonial/edit';
    const URL_PATH_UPDATE_STATUS = 'testimonial/testimonial/updateStatus';
    protected $urlBuilder;

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
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
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'entity_id' => $item['entity_id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'change_status' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_UPDATE_STATUS,
                                [
                                    'entity_id' => $item['entity_id']
                                ]
                            ),
                            'label' => __('Change Status'),
                            'confirm' => [
                                'Title' => __('Change Status "%1"', $item['entity_id']), 
                                'message' => __('Are you sure you want to change the status of "%1" record?', $item['entity_id'])
                            ]
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'entity_id' => $item['entity_id']
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "%1"', $item['entity_id']),
                                'message' => __('Are you sure you want to delete a "%1" record?', $item['entity_id'])
                            ]
                        ]
                    ];
                }
            }
        }
        
        return $dataSource;
    }
}

