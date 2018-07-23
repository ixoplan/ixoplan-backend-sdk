<?php


namespace Ixolit\Dislo\Backend;

use Ixolit\Dislo\AbstractClient;
use Ixolit\Dislo\Backend\Response\CouponCreateResponse;
use Ixolit\Dislo\Backend\Response\CouponGetAggregatedUsageCountsResponse;
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
    const PT_DAILY = 'daily';
    const PT_WEEKLY = 'weekly';
    const PT_MONTHLY = 'monthly';
    const PT_YEARLY = 'yearly';

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
    public function couponList($limit = 10, $offset = 0, $orderDir = self::ORDER_DIR_ASC) {
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
     * @param string[] $validPlans plan identifiers
     * @return CouponGetResponse
     */
    public function couponCreate($type, array $typeParameters, $code, $maxUsages = 0, $maxPeriods = 0, $description = '',
        $enabled = true, $groupCoupon = false, $strictUsages = false,
        array $validEvents = [Coupon::COUPON_EVENT_SUBSCRIPTION_START, Coupon::COUPON_EVENT_SUBSCRIPTION_EXTEND],
        \DateTime $validFrom = null, \DateTime $validTo = null, array $validPlans = [], $allowMultipleUsagesPerUser = false) {

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
            'validFrom' => $validFrom ? $validFrom->format('Y-m-d H:i:s') : null,
            'validTo' => $validTo ? $validTo->format('Y-m-d H:i:s') : null,
            'validPlans' => $validPlans,
            'allowMultipleUsagesPerUser' => $allowMultipleUsagesPerUser
        ];

        $response = $this->request('/backend/subscription/coupon/create', $data);

        return CouponCreateResponse::fromResponse($response);
    }

    /**
     * @param int $id
     * @param array $modifyFields modifiable fields: maxUsages (int), description (string), enabled (bool),
     *                            strictUsages (bool), validEvents (string[]), validFrom (\DateTime|null),
     *                            validTo (\DateTime|null), allowMultipleUsagesPerUser (bool), validPlans (array, only
     *                            if the coupon had valid plans before and you can only add but not remove plans)
     *
     * @return CouponModifyResponse
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
            'validTo',
            'validPlans',
            'allowMultipleUsagesPerUser',
        ];

        $data = ['id' => $id];

        foreach($modifyFields as $field => $newValue) {
            if(!in_array($field, $modifiableFields)) {
                throw new DisloException('Coupon field ' . $field . ' can not be modified or does not exist');
            }

            if(in_array($field, ['validFrom', 'validTo'])) {
                if($newValue !== null && ! $newValue instanceof \DateTime) {
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

    /**
     * @param int $id
     * @return bool
     */
    public function couponDelete($id) {
        $data = [
            'id' => $id
        ];

        $response = $this->request('/backend/subscription/coupon/delete', $data);

        return isset($response['success']) ? (bool) $response['success'] : false;
    }

    /**
     * @param int $id
     * @param \DateTime $dateFrom only date part is used
     * @param \DateTime $dateTo only date part is used
     *
     * @param string $partitionType self::PT_*
     * @return CouponGetAggregatedUsageCountsResponse
     * @throws DisloException
     */
    public function couponGetAggregatedUsageCounts($id, \DateTime $dateFrom, \DateTime $dateTo, $partitionType = self::PT_DAILY) {
        $data = [
            'id' => $id,
            'dateFrom' => $dateFrom->format('Y-m-d'),
            'dateTo' => $dateTo->format('Y-m-d'),
            'partitionType' => $partitionType
        ];

        if($dateFrom > $dateTo) {
            throw new DisloException('$dateTo must be greater than or equal to $dateFrom');
        }

        $validPartTypes = [self::PT_DAILY, self::PT_WEEKLY, self::PT_MONTHLY, self::PT_YEARLY];
        if(!in_array($partitionType, $validPartTypes)) {
            throw new DisloException('$partitionType must be one of ' . implode(', ', $validPartTypes));
        }

        $response = $this->request('backend/subscription/coupon/getAggregatedUsageCounts', $data);

        return CouponGetAggregatedUsageCountsResponse::fromResponse($response);
    }
}
