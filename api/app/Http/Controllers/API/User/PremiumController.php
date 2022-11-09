<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\Transaction\Transaction;
use App\Models\User\Premium\Premium;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class PremiumController extends Controller
{
    public function getFreePremium()
    {
        $user_id = auth()->user()->getKey();
        $premium = Premium::where('user_id', $user_id)
            ->where('finish',Carbon::create(2022,3,1))->first();
        if ($premium) {
            return new JsonResponse('You have a premium!',422);
        }
        $transaction = Transaction::firstOrCreate([
            'user_id' => $user_id,
            'amount'    =>  0,
            'status_id' =>  1,
            'description'   =>  'Free Premium',
            'type'          =>  Transaction::TYPE_WITHDRAW,
        ]);
        $order = Order::firstOrCreate([
            'price'             => 0,
            'transaction_id'    =>  $transaction->getKey(),
            'desc'              =>  'Free Premium',
        ]);
        $premium = Premium::firstOrCreate([
            'user_id'   =>  $user_id,
            'order_id'  =>  $order->getKey(),
            'start'     =>  now()->format('Y-m-d'),
            'finish'    =>  Carbon::create(2022,3,1),
        ]);
        return new JsonResponse('Success');
    }
}
