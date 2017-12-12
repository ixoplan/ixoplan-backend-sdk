<?php


namespace Ixolit\Dislo\Backend\WorkingObjects;

/**
 * Backend coupon data object
 *
 * @package Ixolit\Dislo\Backend\WorkingObjects
 */
class Coupon {
    const COUPON_TYPE_FIXED_PRICE = 'fixedPrice';
    const COUPON_TYPE_PERCENTAGE = 'percentage';
    const COUPON_TYPE_PRICE_DROP = 'priceDrop';

    const COUPON_EVENT_SUBSCRIPTION_START = 'subscription_start';
	const COUPON_EVENT_SUBSCRIPTION_EXTEND = 'subscription_extend';

    /** @var int */
    protected $id;

    /** @var string */
    protected $code;

    /** @var string */
    protected $description;

    /** @var bool */
    protected $enabled;

    /** @var bool */
    protected $superseded;

    /** @var \DateTime */
    protected $createdAt;

    /** @var \DateTime */
    protected $modifiedAt;

    /** @var \DateTime|null */
    protected $validFrom;

    /** @var \DateTime|null */
    protected $validTo;

    /** @var int */
    protected $maxUsages;

    /** @var int */
    protected $maxPeriods;

    /** @var bool */
    protected $strictUsages;

    /** @var array */
    protected $validEvents;

    /** @var string */
    protected $type;

    /** @var array */
    protected $typeParameters;

    /** @var bool */
    protected $groupCoupon;

    /**
     * Coupon constructor.
     *
     * @param int $id
     * @param string $code
     * @param string $description
     * @param bool $enabled
     * @param bool $superseded
     * @param \DateTime $createdAt
     * @param \DateTime $modifiedAt
     * @param \DateTime|null $validFrom
     * @param \DateTime|null $validTo
     * @param int $maxUsages
     * @param int $maxPeriods
     * @param bool $strictUsages
     * @param array $validEvents
     * @param string $type
     * @param array $typeParameters
     * @param bool $groupCoupon
     */
    public function __construct($id, $code, $description, $enabled, $superseded, \DateTime $createdAt,
            \DateTime $modifiedAt, \DateTime $validFrom = null, \DateTime $validTo = null, $maxUsages,
            $maxPeriods, $strictUsages, array $validEvents, $type, array $typeParameters, $groupCoupon) {

        $this->id = $id;
        $this->code = $code;
        $this->description = $description;
        $this->enabled = $enabled;
        $this->superseded = $superseded;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
        $this->validFrom = $validFrom;
        $this->validTo = $validTo;
        $this->maxUsages = $maxUsages;
        $this->maxPeriods = $maxPeriods;
        $this->strictUsages = $strictUsages;
        $this->validEvents = $validEvents;
        $this->type = $type;
        $this->typeParameters = $typeParameters;
        $this->groupCoupon = $groupCoupon;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function getEnabled() {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function getSuperseded() {
        return $this->superseded;
    }

    /**
     * @param bool $superseded
     * @return $this
     */
    public function setSuperseded($superseded) {
        $this->superseded = $superseded;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedAt() {
        return $this->modifiedAt;
    }

    /**
     * @param \DateTime $modifiedAt
     * @return $this
     */
    public function setModifiedAt($modifiedAt) {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getValidFrom() {
        return $this->validFrom;
    }

    /**
     * @param \DateTime|null $validFrom
     * @return $this
     */
    public function setValidFrom($validFrom) {
        $this->validFrom = $validFrom;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getValidTo() {
        return $this->validTo;
    }

    /**
     * @param \DateTime|null $validTo
     * @return $this
     */
    public function setValidTo($validTo) {
        $this->validTo = $validTo;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxUsages() {
        return $this->maxUsages;
    }

    /**
     * @param int $maxUsages
     * @return $this
     */
    public function setMaxUsages($maxUsages) {
        $this->maxUsages = $maxUsages;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxPeriods() {
        return $this->maxPeriods;
    }

    /**
     * @param int $maxPeriods
     * @return $this
     */
    public function setMaxPeriods($maxPeriods) {
        $this->maxPeriods = $maxPeriods;
        return $this;
    }

    /**
     * @return bool
     */
    public function getStrictUsages() {
        return $this->strictUsages;
    }

    /**
     * @param bool $strictUsages
     * @return $this
     */
    public function setStrictUsages($strictUsages) {
        $this->strictUsages = $strictUsages;
        return $this;
    }

    /**
     * @return string[] self::COUPON_EVENT_*
     */
    public function getValidEvents() {
        return $this->validEvents;
    }

    /**
     * @param string[] $validEvents self::COUPON_EVENT_*
     * @return $this
     */
    public function setValidEvents($validEvents) {
        $this->validEvents = $validEvents;
        return $this;
    }

    /**
     * @return string self::COUPON_TYPE_*
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type self::COUPON_TYPE_*
     * @return $this
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function getTypeParameters() {
        return $this->typeParameters;
    }

    /**
     * @param array $typeParameters
     * @return $this
     */
    public function setTypeParameters($typeParameters) {
        $this->typeParameters = $typeParameters;
        return $this;
    }

    /**
     * @return bool
     */
    public function getGroupCoupon() {
        return $this->groupCoupon;
    }

    /**
     * @param bool $groupCoupon
     * @return $this
     */
    public function setGroupCoupon($groupCoupon) {
        $this->groupCoupon = $groupCoupon;
        return $this;
    }

    /**
     * @param array $response
     *
     * @return self
     */
    public static function fromResponse($response) {
        return new Coupon(
            (int) $response['id'],
            $response['code'],
            $response['description'],
            (bool) $response['enabled'],
            (bool) $response['superseded'],
            new \DateTime($response['createdAt']),
            new \DateTime($response['modifiedAt']),
            $response['validFrom'] ? new \DateTime($response['validFrom']) : null,
            $response['validTo'] ? new \DateTime($response['validTo']) : null,
            (int) $response['maxUsages'],
            (int) $response['maxPeriods'],
            (bool) $response['strictUsages'],
            $response['validEvents'],
            $response['type'],
            $response['typeParameters'],
            $response['groupCoupon']
        );
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'description' => $this->description,
            'enabled' => $this->enabled,
            'superseded' => $this->superseded,
            'createdAt'  => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'modifiedAt' => $this->modifiedAt,
            'validFrom' => $this->validFrom,
            'validTo' => $this->validTo,
            'maxUsages' => $this->maxUsages,
            'maxPeriods' => $this->maxPeriods,
            'strictUsages' => $this->strictUsages,
            'validEvents' => $this->validEvents,
            'type' => $this->type,
            'typeParameters' => $this->typeParameters,
            'groupCoupon' => $this->groupCoupon
        ];
    }
}