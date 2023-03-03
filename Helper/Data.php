<?php
namespace Croapp\Integration\Helper;

use Magento\Framework\Module\ModuleListInterface;
use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * Interface Scope Config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Interface Module List
     *
     * @var ModuleListInterface
     */
    protected $_moduleList;

    /**
     * Constructor
     *
     * @param Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param ModuleListInterface $moduleList
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        ModuleListInterface $moduleList
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_moduleList = $moduleList;
        parent::__construct(
            $context
        );
    }

    /**
     * Get Event Type
     *
     * @param string $event - event name
     */
    public function getEventType($event)
    {
        $eventMap = [
            'home_viewed'         =>  'home_viewed',
            'content_page_viewed' =>  'content_page_viewed',
            'collection_viewed'   =>  'collection_viewed',
            'view_item'           =>  'view_item',
            'view_search_results' =>  'view_search_results',
            'sign_up'             =>  'sign_up',
            'login'               =>  'login',
            'logout'              =>  'logout',
            'view_cart'           =>  'view_cart',
            'begin_checkout'      =>  'begin_checkout',
            'purchase'            =>  'purchase',
        ];

        if (!empty($eventMap[$event])) {
            return $eventMap[$event];
        } else {
            return "unknown-$event";
        }
    }

    /**
     * Check if module is enabled
     */
    public function isEnabled()
    {
        if ($this->getGaId()) {
            return 1;
        } else {
            return false;
        }
    }

    /**
     * Get Google Analytics Measurement ID
     */
    public function getGaId()
    {
        $gaId = $this->scopeConfig->getValue('croapp/configuration/gaId', ScopeInterface::SCOPE_STORE);
        if (empty($gaId)) {
            return false;
        } else {
            return $gaId;
        }
    }

    /**
     * Get Module Version
     */
    public function getModuleVersion()
    {
        $ccModule = $this->_moduleList
            ->getOne('Croapp_Integration');
        return !empty($ccModule['setup_version']) ? $ccModule['setup_version'] : null;
    }

    /**
     * Sanitize Parameter
     *
     * @param string $param - parameter to be sanitized
     */
    public function sanitizeParam($param)
    {
        return strip_tags($param);
    }
}
