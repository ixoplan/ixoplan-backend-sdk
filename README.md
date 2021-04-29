# ixoplan-backend-sdk
PHP SDK for the Ixoplan Backend API

## Installation

Simply add ixoplan/ixoplan-backend-sdk and a provider of ixoplan/ixoplan-sdk-http (e.g. ixoplan/ixoplan-sdk-http-guzzle) to your composer.json, e.g:

    {
        "name": "myvendor/myproject",
        "description": "Using ixoplan-backend-sdk",
        "require": {
            "ixoplan/ixoplan-backend-sdk": "*"
            "ixoplan/ixoplan-sdk-http-guzzle": "*"
        }
    }

## Usage

### Instantiate the Client
The client is designed for different transport layers. It needs a RequestClient interface (e.g. HTTPRequestClient) to actually communicate with Ixoplan.

    use Ixolit\Dislo\Backend\Client;
    use Ixolit\Dislo\HTTP\Guzzle\GuzzleHTTPClientAdapter;
    use Ixolit\Dislo\Request\HTTPRequestClient;
    
    $httpAdapter = new GuzzleHTTPClientAdapter();

    $httpClient = new HTTPRequestClient(
        $httpAdapter,
        $host,
        $apiKey,
        $apiSecret
    );

    $apiClient = new Client($httpClient);

### Coupons

Retrieve a list of all coupons in multiple requests, each limited to ten items:

    $apiClient = new \Ixolit\Dislo\Backend\Client($httpClient);

    $limit = 10;
    $offset = 0;
    do {
        $couponListResponse = $apiClient->couponList($limit, $offset);
        foreach ($couponListResponse->getCoupons() as $coupon) {
            echo $coupon->getCode();
            $offset++;
        }
    } while ($offset < $couponListResponse->getTotalCount());
