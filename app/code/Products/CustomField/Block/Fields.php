<?php 

namespace Products\CustomField\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ResourceConnection;
use Magento\Catalog\Helper\Data;
class Fields extends Template 
{
    protected $resourceConnection;
    protected  $catalogHelper;
    protected $_product = null;

    public function __construct(
        Template\Context $context,
        ResourceConnection $resourceConnection,
        Data $catalogHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->resourceConnection = $resourceConnection;
        $this->catalogHelper = $catalogHelper;
    }
    public function getProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->catalogHelper->getProduct();
        }
        return $this->_product;
    }
    public function getProductPrioritys()
    {   $productId = $this->getProduct()->getId();
        $connection = $this->resourceConnection->getConnection();
        $customFieldsTable = $this->resourceConnection->getTableName('catalog_product_entity_custom_field');
       
        $query = "SELECT `priority` FROM `" . $customFieldsTable . "` WHERE product_id = $productId ";
        
        $result = $connection->fetchOne($query);
        
        return $result;
    }
    public function getProductVendorName()
    {   $productId = $this->getProduct()->getId();
        $connection = $this->resourceConnection->getConnection();
        $customFieldsTable = $this->resourceConnection->getTableName('catalog_product_entity_custom_field');
       
        $query = "SELECT `vendor_name` FROM `" . $customFieldsTable . "` WHERE product_id = $productId ";
        
        $result = $connection->fetchOne($query);
        
        return $result;
    }
}