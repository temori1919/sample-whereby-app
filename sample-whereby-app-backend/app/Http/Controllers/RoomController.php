<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class RoomController extends Controller
{
    public function create()
    {
        $enddate = date(DATE_RFC3339, strtotime('+1 hour'));

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('app.api_key'),
        ])->accept(
            'application/json'
        )->post('https://api.whereby.dev/v1/meetings', [
            'endDate' => $enddate,
            'fields' => ['hostRoomUrl'],
        ]);

        throw_if(!$response->created(), $response->body());

        return $response->body();
    }

    public function delete($meeting_id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('app.api_key'),
        ])->accept(
            'application/json'
        )->delete("https://api.whereby.dev/v1/meetings/{$meeting_id}");

        throw_if(!$response->noContent());

        return $response->body();
    }
}
