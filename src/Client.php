<?php


namespace Ixolit\Dislo\Backend;

use Ixolit\Dislo\AbstractClient;
use Ixolit\Dislo\Backend\Response\CouponGetResponse;
use Ixolit\Dislo\Backend\Response\CouponListResponse;
use Ixolit\Dislo\Backend\Response\CouponModifyResponse;
use Ixolit\Dislo\Backend\WorkingObjects\Coupon;
use Ixolit\Dislo\Exceptions\DisloException;
use Ixolit\Dislo\Request\RequestClient;

/**
 * The backend client class for use with the Dislo API.
 *
 * It extends the frontend Dislo API clients and adds backend specific calls
 *
 * @see \Ixolit\Dislo\Client
 */
class Client extends AbstractClient {
    public function __construct(RequestClient $requestClient) {
        parent::__construct($requestClient, false);
    }

    /**
     * list all coupons ordered by id
     *
     * @param int $limit
     * @param int $offset
     * @param string $orderDir
     *
     * @return CouponListResponse
     */
    public function couponList($limit = 10, $offset = 0, $orderDir = \Ixolit\Dislo\Client::ORDER_DIR_DESC) {
        $data = [
			'limit'    => $limit,
			'offset'   => $offset,
			'orderDir' => $orderDir,
		];

		$response = $this->request('/backend/subscription/coupon/list', $data);

		return CouponListResponse::fromResponse($response);
    }

    /**
     * get a coupon by id
     *
     * @param int $id
     *
     * @return CouponGetResponse
     */
    public function couponGet($id) {
        $response = $this->request('/backend/subscription/coupon/get', ['id' => $id]);

        return CouponGetResponse::fromResponse($response);
    }

    /**
     * create a new coupon
     *
     * @param string $type Coupon::COUPON_TYPE_*
     * @param array $typeParameters type specific parameters
     * @param string $code coupon code or coupon code prefix for group coupon
     * @param int $maxUsages
     * @param int $maxPeriods
     * @param string $description
     * @param bool $enabled
     * @param bool $groupCoupon
     * @param bool $strictUsages
     * @param string[] $validEvents Coupon::COUPON_EVENT_*
     * @param \DateTime|null $validFrom
     * @param \DateTime|null $validTo
     */
    public function couponCreate($type, array $typeParameters, $code, $maxUsages = 0, $maxPeriods = 0, $description = '',
        $enabled = true, $groupCoupon = false, $strictUsages = false,
        array $validEvents = [Coupon::COUPON_EVENT_SUBSCRIPTION_START, Coupon::COUPON_EVENT_SUBSCRIPTION_EXTEND],
        \DateTime $validFrom = null, \DateTime $validTo = null) {

        $data = [
            'type' => $type,
            'typeParameters' => $typeParameters,
            'code' => $code,
            'maxUsages' => $maxUsages,
            'maxPeriods' => $maxPeriods,
            'description' => $description,
            'enabled' => $enabled,
            'groupCoupon' => $groupCoupon,
            'strictUsages' => $strictUsages,
            'validEvents' => $validEvents,
            'validFrom' => $validFrom,
            'validTo' => $validTo
        ];

        $response = $this->request('/backend/subscription/coupon/create', $data);
    }

    /**
     * @param int $id
     * @param array $modifyFields modifiable fields: maxUsages (int), description (string), enabled (bool),
     *                            strictUsages (bool), validEvents (string[]), validFrom (\DateTime|null),
     *                            validTo (\DateTime|null)
     *
     * @throws DisloException
     */
    public function couponModify($id, array $modifyFields = []) {
        $modifiableFields = [
            'maxUsages',
            'description',
            'enabled',
            'strictUsages',
            'validEvents',
            'validFrom',
            'validTo'
        ];

        $data = ['id' => $id];

        foreach($modifyFields as $field => $newValue) {
            if(!in_array($field, $modifiableFields)) {
                throw new DisloException('Coupon field ' . $field . ' can not be modified or does not exist');
            }

            if(in_array($field, ['validFrom', 'validTo'])) {
                if(newValue !== null && ! $newValue instanceof \DateTime) {
                    throw new DisloException('DateTime expected');
                }

                $data[$field] = $newValue ? $newValue->format('Y-m-d H:i:s') : null;

            } else {
                $data[$field] = $newValue;
            }
        }

        $response = $this->request('/backend/subscription/coupon/modify', $data);

        return CouponModifyResponse::fromResponse($response);
    }
}