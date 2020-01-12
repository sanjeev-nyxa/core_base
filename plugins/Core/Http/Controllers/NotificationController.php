<?php

namespace Labs\Core\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Labs\Core\Http\Resources\NotificationResource;

/**
 * Class NotificationController
 * @package Labs\Core\Http\Controllers
 * @resource User Notification
 *
 */
class NotificationController extends Controller
{
    /**
     * All
     * note: you can listen for upcoming notifications on channel ("notifications_{$user->id}")
     * **Method: Labs\Core\Http\Controllers\NotificationController@all **
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(Request $request)
    {
        return NotificationResource::collection($request->user()->notifications);
    }

    /**
     * Unread
     * **Method: Labs\Core\Http\Controllers\NotificationController@unread **
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function unread(Request $request)
    {
        return NotificationResource::collection($request->user()->unreadNotifications);
    }

    /**
     * Mark All As Read
     * **Method: Labs\Core\Http\Controllers\NotificationController@markAsRead **
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function markAsRead(Request $request)
    {
        $user = $request->user();
        $user->unreadNotifications->markAsRead();
        return NotificationResource::collection($user->notifications);
    }
}