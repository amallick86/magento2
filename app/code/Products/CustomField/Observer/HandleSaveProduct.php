<?php 
namespace Products\CustomField\Observer;

use \Magento\Framework\Event\Observer;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Event\ObserverInterface;
use Products\CustomField\Ui\DataProvider\Product\Form\Modifier\NewField;
class HandleSaveProduct implements ObserverInterface
{
protected $request;
protected $resourceConnection;
  
    public function __construct(\Magento\Framework\App\RequestInterface $request, ResourceConnection $resourceConnection,)
    {
        $this->request = $request;
        $this->resourceConnection = $resourceConnection;
    }
    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        if (!$product) {
            return;
        }
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('catalog_product_entity_custom_field');
        $productId = $product->getID();
        $priority = $product->getData(NewField::FIELD_NAME_TEXT_PRIORITY);
        $vendorName = $product->getData(NewField::FIELD_NAME_TEXT_VENDOR_NAME);
        $query = "INSERT INTO " . $tableName . " (vendor_name, priority, product_id)
        VALUES ('.$vendorName',  $priority, $productId)";
        $connection->query($query);
         
        }

    }
