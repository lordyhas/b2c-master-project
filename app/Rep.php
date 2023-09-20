<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class Rep
{
    /**
     * @param array $data
     * @param Status|null $status
     * @param string|null $message
     * @param array|null $info
     * @return JsonResponse
     */
    static function toJson(array|Collection $data, Status|null $status = null, string|null $message = null, array|null $info = null): JsonResponse
    {
        return response()->json([
            "datetime" => new DateTime(),
            "status" => $status ?? Status::Failed,
            "message" => $message ?? "No message",
            "info" => $info,
            "data" => $data
        ]);
    }
}
