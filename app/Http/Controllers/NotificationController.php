<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Notification::where('user_id', Auth::id())
            ->where('type', 'customer')
            ->latest();

        if ($request->filled('filter')) {
            $filter = $request->filter;
            if ($filter === 'unread') {
                $query->where('is_read', false);
            } elseif ($filter === 'read') {
                $query->where('is_read', true);
            } elseif ($filter === 'today') {
                $query->whereDate('created_at', today());
            } elseif ($filter === 'week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $notifications = $query->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function fetch(): JsonResponse
    {
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
            ->where('type', 'customer')
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', $userId)
            ->where('type', 'customer')
            ->where('is_read', false)
            ->count();

        $latestId = $notifications->isNotEmpty() ? $notifications->max('id') : 0;

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
            'latest_id' => $latestId,
        ]);
    }

    public function markAsRead($id): JsonResponse
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(): JsonResponse
    {
        Notification::where('user_id', Auth::id())
            ->where('type', 'customer')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function destroy($id): JsonResponse
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true]);
    }
}
