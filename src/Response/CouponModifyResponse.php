<?php
namespace Ixolit\Dislo\Backend\Response;

use Ixolit\Dislo\Backend\WorkingObjects\Coupon;

/**
 * Class CouponModifyResponse
 *
 * @package Ixolit\Dislo\Backend\Response
 */
class CouponModifyResponse {
    /** @var Coupon */
    protected $coupon;

    /**
     * CouponModifyResponse constructor.
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
     * @return CouponModifyResponse
     */
    public static function fromResponse($response) {
        return new static(Coupon::fromResponse($response['coupon']));
    }
}