<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class Rep
{
    /**
     * @param array|Collection $data
     * @param Status|null $status
     * @param string|null $message
     * @param array|null $info
     * @return JsonResponse
     */
    static function toJson(array|Collection $data, Status|null $status = null, string|null $message = null, array|null $info = null): JsonResponse
    {
        return response()->json([
            "datetime" => date('Y-m-d H:i:s', time()),
            "status" => $status ?? Status::Failed,
            "message" => $message ?? "No message",
            "info" => $info,
            "data" => $data
        ]);
    }

    static function denied() : JsonResponse {
        return Rep::toJson(data : [], message: "Access denied");
    }

    static function failed(null|string $message = null) : JsonResponse {
        return Rep::toJson(data : [], message: $message ?? "Request failed");
    }
    static function unimplemented() : JsonResponse {
        return Rep::toJson(data : [], message: "Unplemented method");
    }
}
