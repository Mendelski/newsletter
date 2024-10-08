<?php

use App\Services\ApiReturnService;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    Response::swap(Response::getFacadeRoot());
});

it('returns a successful response', function () {
    $response = ApiReturnService::apiReturnSuccess(['key' => 'value'], 'Operation successful');
    $pattern = [
        'message' => 'Operation successful',
        'data' => ['key' => 'value'],
        'error' => false,
    ];

    expect($response)->toBeInstanceOf(JsonResponse::class)
        ->and($response->getStatusCode())->toBe(200)
        ->and($response->getData(true))
        ->toMatchArray($pattern);
});

it('returns an error response', function () {
    $response = ApiReturnService::apiReturnError(['key' => 'value'], 'Operation failed');
    $pattern = [
        'message' => 'Operation failed',
        'data' => ['key' => 'value'],
        'error' => true,
    ];

    expect($response)->toBeInstanceOf(JsonResponse::class)
        ->and($response->getStatusCode())->toBe(400)
        ->and($response->getData(true))->toMatchArray($pattern);
});
