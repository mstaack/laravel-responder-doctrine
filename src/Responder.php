<?php

namespace Flugg\Responder;

use Flugg\Responder\ErrorResponse;
use Flugg\Responder\Http\ErrorResponseBuilder;
use Flugg\Responder\Http\SuccessResponseBuilder;
use Flugg\Responder\SuccessResponse;
use Illuminate\Http\JsonResponse;

/**
 * The responder service. This class is responsible for generating JSON API responses.
 *
 * @package flugger/laravel-responder
 * @author  Alexander Tømmerås <flugged@gmail.com>
 * @license The MIT License
 */
class Responder
{
    /**
     * The response builder used to build success responses.
     *
     * @var \Flugg\Responder\Http\SuccessResponseBuilder
     */
    protected $successResponse;

    /**
     * The response builder used to build error responses.
     *
     * @var \Flugg\Responder\Http\ErrorResponseBuilder
     */
    protected $errorResponse;

    /**
     * JMS Doctrine Serialize groups
     * @var mixed
     */
    protected $serializeGroups;

    /**
     * Constructor.
     *
     * @param \Flugg\Responder\Http\ErrorResponseBuilder   $errorResponse
     * @param \Flugg\Responder\Http\SuccessResponseBuilder $successResponse
     */
    public function __construct(SuccessResponseBuilder $successResponse, ErrorResponseBuilder $errorResponse)
    {
        $this->successResponse = $successResponse;
        $this->errorResponse = $errorResponse;
    }

    /**
     * Generate an error JSON response.
     *
     * @param  string|null $errorCode
     * @param  int|null    $statusCode
     * @param  mixed       $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(string $errorCode = null, int $statusCode = null, $message = null):JsonResponse
    {
        return $this->errorResponse->setError($errorCode, $message)->respond($statusCode);
    }

    /**
     * Generate a successful JSON response.
     *
     * @param  mixed|null $data
     * @param  int|null   $statusCode
     * @param  array      $meta
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data = null, $statusCode = null, array $meta = []):JsonResponse
    {
        if (is_integer($data)) {
            list($data, $statusCode, $meta) = [null, $data, is_array($statusCode) ? $statusCode : []];
        }

        if (is_array($statusCode)) {
            list($statusCode, $meta) = [200, $statusCode];
        }

        return $this->successResponse
            ->setGroups($this->serializeGroups)
            ->transform($data)
            ->addMeta($meta)
            ->respond($statusCode);
    }

    /**
     * Transform the data and return a success response builder.
     *
     * @param  mixed|null           $data
     * @param  callable|string|null $transformer
     * @return \Flugg\Responder\Http\SuccessResponseBuilder
     */
    public function transform($data = null, $transformer = null):SuccessResponseBuilder
    {
        return $this->successResponse->transform($data, $transformer);
    }

    /**
     * Set JMS Doctrine serialize groups
     * @param string|array $groups
     * @return self
     */
    public function setGroups($groups)
    {
        $this->serializeGroups = $groups;
        return $this;
    }

}
