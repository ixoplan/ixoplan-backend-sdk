<?php


namespace Ixolit\Dislo\Backend\WorkingObjects;

/**
 * UsageCount item wrapper
 *
 * @package Ixolit\Dislo\Backend\WorkingObjects
 */
class UsageCount {
    /** @var int usage count */
    protected $count;

    /** @var string partition, Y-m-d for daily, Y-m for monthly, Y for yearly and Y-W for weekly */
    protected $partition;

    /**
     * UsageCount constructor.
     *
     * @param int $count
     * @param string $partition
     */
    public function __construct($count, $partition) {
        $this->count = $count;
        $this->partition = $partition;
    }

    /**
     * @return int
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @param int $count
     * @return UsageCount
     */
    public function setCount($count) {
        $this->count = $count;
        return $this;
    }

    /**
     * @return string
     */
    public function getPartition() {
        return $this->partition;
    }

    /**
     * @param string $partition
     * @return UsageCount
     */
    public function setPartition($partition) {
        $this->partition = $partition;
        return $this;
    }

    /**
     * @param array $data
     * @return UsageCount
     */
    public static function fromResponse(array $data) {
        return new UsageCount(
            (int) $data['count'],
            $data['partition']
        );
    }

    public function toArray() {
        return [
            'count' => $this->getCount(),
            'partition' => $this->getPartition()
        ];
    }
}