<?php
namespace Ixolit\Dislo\Backend\Response;

use Ixolit\Dislo\Backend\WorkingObjects\Coupon;

/**
 * Class CouponGetResponse
 *
 * @package Ixolit\Dislo\Backend\Response
 */
class CouponGetResponse {
    /** @var Coupon */
    protected $coupon;

    /**
     * CouponGetResponse constructor.
     *
     * @param $coupon
     */
    public function __construct($coupon) {
        $this->coupon = $coupon;
    }

    /**
     * @return Coupon
     */
    public function getCoupon() {
        return $this->coupon;
    }

    /**
	 * @param array $response
	 *
	 * @return static
	 */
	public static function fromResponse($response) {
		return new static(Coupon::fromResponse($response['coupon']));
	}
}