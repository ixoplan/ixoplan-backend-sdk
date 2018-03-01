# dislo-backend-sdk
PHP SDK for the Dislo Backend API

## Installation

Simply add ixolit/dislo-backend-sdk and a provider of ixolit/dislo-sdk-http (e.g. ixolit/dislo-sdk-http-guzzle) to your composer.json, e.g:

    {
        "name": "myvendor/myproject",
        "description": "Using dislo-sdk",
        "require": {
            "ixolit/dislo-backend-sdk": "*"
            "ixolit/dislo-sdk-http-guzzle": "*"
        }
    }

## Usage

### Instantiate the Client
The client is designed for different transport layers. It needs a RequestClient interface (e.g. HTTPRequestClient) to actually communicate with Dislo.

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
