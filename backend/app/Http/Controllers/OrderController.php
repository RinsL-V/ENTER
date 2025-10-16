<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.chapter_id' => 'required|exists:chapters,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $items = $request->items;

        // Рассчитываем общую сумму
        $totalAmount = 0;
        foreach ($items as $item) {
            $chapter = Chapter::findOrFail($item['chapter_id']);
            $totalAmount += $chapter->price * $item['quantity'];
        }

        // Создаем заказ
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_amount' => $totalAmount
        ]);

        // Добавляем товары в заказ
        foreach ($items as $item) {
            $chapter = Chapter::findOrFail($item['chapter_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'chapter_id' => $chapter->id,
                'price' => $chapter->price,
                'quantity' => $item['quantity']
            ]);
        }

        return response()->json([
            'success' => true,
            'order' => $order->load('items.chapter')
        ], 201);
    }

    public function index(Request $request): JsonResponse
    {
        // Для админа: все заказы на модерации
        // Измененная проверка - используем поле роли напрямую
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }

        $orders = Order::with(['user', 'items.chapter'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return response()->json($orders);
    }

    public function approve($id): JsonResponse
    {
        $order = Order::with('items.chapter')->findOrFail($id);
        $order->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'order' => $order
        ]);
    }

    public function reject($id): JsonResponse
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'rejected']);

        return response()->json(['success' => true]);
    }

    public function userOrders(): JsonResponse
    {
        $user = Auth::user();

        $orders = Order::with('items.chapter')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json($orders);
    }

    public function completedOrders(): JsonResponse
    {
        $user = Auth::user();

        $orders = Order::with('items.chapter')
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->latest()
            ->get();

        return response()->json($orders);
    }

    public function show($id): JsonResponse
    {
        $order = Order::with(['user', 'items.chapter'])->findOrFail($id);

        // Проверяем права доступа
        if (Auth::user()->id !== $order->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }

        return response()->json($order);
    }
}
