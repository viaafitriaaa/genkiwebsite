<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Bundle;
 use Illuminate\Support\Facades\Log;
class PromoController extends Controller {
    
public function claimPromo(Request $r, Order $order)
{
    Log::info('PROMO START', [
        'order_id' => $order->id ?? null,
        'ktm_code' => $r->ktm_code
    ]);

    if ($r->ktm_code && str_starts_with($r->ktm_code, 'NIM')) {

        $order->load('items');

        foreach ($order->items as $item) {

            Log::info('ITEM BEFORE', [
                'item_id' => $item->id,
                'price' => $item->price
            ]);

            if ($item->bundle_id) {
                $bundle = Bundle::find($item->bundle_id);

                if ($bundle && $bundle->student_only) {

                    $newPrice = round($item->price * 0.8, 2);

                    $item->price = $newPrice;
                    $saved = $item->save();

                    Log::info('ITEM AFTER SAVE', [
                        'item_id' => $item->id,
                        'new_price' => $newPrice,
                        'save_result' => $saved
                    ]);
                }
            }
        }

        $order->total = $order->items()
            ->sum(\DB::raw('quantity * price'));
        $order->save();

        Log::info('ORDER UPDATED', [
            'order_id' => $order->id,
            'total' => $order->total
        ]);

        return response()->json(['ok' => true]);
    }

    Log::warning('PROMO FAILED: KTM INVALID');

    return response()->json(['ok' => false]);
}
}