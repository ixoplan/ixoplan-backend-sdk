<?php
namespace Ixolit\Dislo\Backend\Response;

use Ixolit\Dislo\Backend\WorkingObjects\Coupon;

/**
 * Class CouponListResponse
 *
 * @package Ixolit\Dislo\Backend\Response
 */
class CouponListResponse {
    /** @var Coupon[] */
    protected $coupons;

    /** @var int */
    protected $totalCount;

    /**
     * CouponListResponse constructor.
     *
     * @param Coupon[] $coupons
     * @param int $totalCount
     */
    public function __construct(array $coupons, $totalCount) {
        $this->coupons = $coupons;
        $this->totalCount = $totalCount;
    }

    /**
	 * @param array $response
	 *
	 * @return CouponListResponse
	 */
	public static function fromResponse($response) {
        $coupons = [];
		foreach ($response['coupons'] as $couponArray) {
            $coupons[] = Coupon::fromResponse($couponArray);
		}

		return new CouponListResponse(
		    $coupons,
            $response['totalCount']
        );
	}

    /**
     * @return Coupon[]
     */
    public function getCoupons() {
        return $this->coupons;
    }

    /**
     * @return int
     */
    public function getTotalCount() {
        return $this->totalCount;
    }
}