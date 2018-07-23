<?php


namespace Ixolit\Dislo\Backend\Response;

use Ixolit\Dislo\Backend\WorkingObjects\UsageCount;

/**
 * Class CouponGetAggregatedUsageCountsResponse
 *
 * @package Ixolit\Dislo\Backend\Response
 */
class CouponGetAggregatedUsageCountsResponse {
    /** @var UsageCount[] */
    protected $usageCounts = [];

    /**
     * CouponGetAggregatedUsageCountsResponse constructor.
     *
     * @param UsageCount[] $usageCounts
     */
    public function __construct(array $usageCounts) {
        $this->usageCounts = $usageCounts;
    }

    /**
     * @return UsageCount[]
     */
    public function getUsageCounts() {
        return $this->usageCounts;
    }

    /**
	 * @param array $response
	 *
	 * @return static
	 */
	public static function fromResponse(array $response) {
		return new static(\array_map(function(array $v) {
		    return UsageCount::fromResponse($v);
        }, $response['usageCounts']));
	}
}