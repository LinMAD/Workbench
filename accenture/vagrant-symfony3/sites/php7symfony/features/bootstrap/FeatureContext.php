<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    /**
     * The Guzzle HTTP Client.
     */
    protected $client;

    /**
     * The current resource
     */
    protected $resource;

    /**
     * The Guzzle HTTP Response.
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * The request payload
     */
    protected $requestPayload;

    /**
     * FeatureContext constructor.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @Given /^I have the payload:$/
     *
     */
    public function iHaveThePayload(PyStringNode $requestPayload)
    {
        $this->requestPayload = $requestPayload;
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE) ([^"]*)"$/
     *
     */
    public function iRequest($httpMethod, $resource)
    {
        $this->resource = $resource;

        $method = strtolower($httpMethod);

        try {
            switch ($httpMethod) {
                case 'PUT' || 'POST':
                    $response = $this
                        ->client
                        ->$method($resource,  ['body' => $this->requestPayload]);
                    break;
                default:
                    $response = $this
                        ->client
                        ->$method($resource);
            }
        } catch (BadResponseException $e) {

            $response = $e->getResponse();

            // Sometimes the request will fail, at which point we have
            // no response at all. Let Guzzle give an error here, it's
            // pretty self-explanatory.
            if ($response === null) {
                throw $e;
            }
        }

        $this->response = $response;
    }

    /**
     * @Then the response status code should be :status
     */
    public function theResponseStatusCodeShouldBe($statusCode)
    {
        PHPUnit::assertEquals((int) $statusCode, (int) $this->response->getStatusCode());
    }

    /**
     * @Then the :arg1 property should equal :arg2
     */
    public function thePropertyShouldEqual($property, $expectedValue)
    {
        $response = $this->getResponseBody();
        if(!key_exists($property, $this->getResponseBody()))
            throw new Exception("Property $property not exists in response");

        PHPUnit::assertEquals($response[$property], $expectedValue);
    }

    private function getResponseBody()
    {
        return json_decode((string) $this->response->getBody(), true);
    }

}