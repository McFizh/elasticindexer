<?php
namespace McFish\ElasticIndexer\Model\Indexer;
 
use Magento\Eav\Model\Config;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Indexer\SaveHandler\IndexerInterface;
use Magento\Framework\Indexer\IndexStructureInterface;
use Magento\Framework\Search\Request\Dimension;
use Magento\Framework\Search\Request\IndexScopeResolverInterface;
use Magento\Framework\Indexer\SaveHandler\Batch;
use Magento\Framework\Indexer\ScopeResolver\IndexScopeResolver;
use Magento\Framework\App\Config\ScopeConfigInterface;

use Elasticsearch\ClientBuilder;

class IndexerHandler implements IndexerInterface
{
    private $indexStructure;
    private $data;
    private $fields;
    private $resource;
    private $batch;
    private $eavConfig;
    private $batchSize;
    private $indexScopeResolver;
    private $scopeConfig;
    private $elasticClient; 

    public function __construct(Batch $batch, ScopeConfigInterface $scopeConfig, array $data, $batchSize = 50 ) {
        $this->batch = $batch;
        $this->data = $data;
        $this->batchSize = $batchSize;
        $this->scopeConfig = $scopeConfig;

        $t_elasticHost = [
            "host" => $scopeConfig->getValue('catalog/search/eindexer_host', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
            "port" => $scopeConfig->getValue('catalog/search/eindexer_port', \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
        ];        

        echo "Create....\n";

        $this->elasticClient = ClientBuilder::create()
            ->setHosts($t_elasticHost)
            ->build();
    }
 
    public function saveIndex($dimensions, \Traversable $documents)
    {
        foreach($dimensions as $dimension) {
            if( ($scope = $this->parseScope($dimension)) === false)
                continue;
                

            foreach ($this->batch->getItems($documents, $this->batchSize) as $batchDocuments) {
                echo "!save!\n";
            }
        }
    }
 
    public function deleteIndex($dimensions, \Traversable $documents)
    {
        foreach($dimensions as $dimension) {
            if( ($scope = $this->parseScope($dimension)) === false)
                continue;

            foreach ($this->batch->getItems($documents, $this->batchSize) as $batchDocuments) {
                echo "!delete!\n";
            }
        }
    }

    public function cleanIndex($dimensions)
    {
        foreach($dimensions as $dimension) {
            if( ($scope = $this->parseScope($dimension)) === false)
                continue;

            echo "!clean!\n";
        }
    }
 
    public function isAvailable()
    {
        $resp = $this->elasticClient->ping();

        if($resp)
            return true;

        return false;
    }

    //
    private function parseScope($dimension) {
        if($dimension->getName() != "scope") {
            echo "Unknown dimension name/value pair.. \n";
            echo "Dimension name:".$dimension->getName()." value:".$dimension->getValue()."\n";
            return false;    
        }

        return $dimension->getValue();
    }
}

