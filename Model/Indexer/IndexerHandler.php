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
 
    public function __construct(
        Batch $batch,
        array $data,
        $batchSize = 50
    ) {
        $this->batch = $batch;
        $this->data = $data;
        $this->batchSize = $batchSize;
    }
 
    public function saveIndex($dimensions, \Traversable $documents)
    {
        foreach ($this->batch->getItems($documents, $this->batchSize) as $batchDocuments) {
 
        }
    }
 
    public function deleteIndex($dimensions, \Traversable $documents)
    {
        foreach ($this->batch->getItems($documents, $this->batchSize) as $batchDocuments) {
 
        }
    }
 
    public function cleanIndex($dimensions)
    {
 
    }
 
    public function isAvailable()
    {
        return true;
    }
}

