<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\DB;
use App\Models\UserTransaction;
use App\Models\UserPayment;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function init()
    {
        $user = user();
        if($user->is_premium) {
            return redirect()->back()->with('error', 'You are already a premium user');
        }

        try {
            DB::beginTransaction();
                UserPayment::where('user_id', $user->id)->where('status', UserPayment::STATUS_PENDING)->update([
                    'status' => UserPayment::STATUS_CANCELLED,
                ]);

                //Create User Transaction Entry
                $userTransaction = UserTransaction::create([
                    'receiver_id' => null,
                    'sender_id' => $user->id,
                    'amount' => config('app.premium_price'),
                    'note' => 'Premium Payment',
                    'status' => UserTransaction::STATUS_PENDING,
                    'type' => UserTransaction::TYPE_DEBIT,
                ]);

                //Create User Payment Entry
                $userPayment = UserPayment::create([
                    'user_id' => $user->id,
                    'user_transaction_id' => $userTransaction->id,
                    'amount' => config('app.premium_price'),
                    'currency' => config('app.currency'),
                    'status' => UserPayment::STATUS_PENDING,
                    'payment_method' => UserPayment::PAYMENT_METHOD_SSLCOMMERZ,
                    'payment_note' => 'Premium Payment through SSLCommerz',
                ]);

            DB::commit();


            $post_data = array();
            $post_data['total_amount'] = config('app.premium_price');
            $post_data['currency'] = config('app.currency');
            $post_data['tran_id'] = $userTransaction->id;

            # CUSTOMER INFORMATION
            $post_data['cus_name'] = $user->name ?? 'Uparzone User'.$user->id;
            $post_data['cus_email'] = $user->email ?? 'user'.$user->id.'@uparzone.com';
            $post_data['cus_add1'] = $user->address ?? 'Uparzone User'.$user->id;
            $post_data['cus_add2'] = "";
            $post_data['cus_city'] = "";
            $post_data['cus_state'] = "";
            $post_data['cus_postcode'] = "";
            $post_data['cus_country'] = "Bangladesh";
            $post_data['cus_phone'] = $user->phone ?? '01700000000';
            $post_data['cus_fax'] = "";

            # SHIPMENT INFORMATION
            $post_data['ship_name'] = $user->name ?? 'Uparzone User'.$user->id;
            $post_data['ship_add1'] = $user->address ?? 'Uparzone User'.$user->id;
            $post_data['ship_add2'] = "Dhaka";
            $post_data['ship_city'] = "Dhaka";
            $post_data['ship_state'] = "Dhaka";
            $post_data['ship_postcode'] = "1000";
            $post_data['ship_phone'] = $user->phone ?? '01700000000';
            $post_data['ship_country'] = "Bangladesh";

            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "Premium Payment";
            $post_data['product_category'] = "Goods";
            $post_data['product_profile'] = "physical-goods";

            # OPTIONAL PARAMETERS
            $post_data['value_a'] = "ref001";
            $post_data['value_b'] = "ref002";
            $post_data['value_c'] = "ref003";
            $post_data['value_d'] = "ref004";

            $sslc = new SslCommerzNotification();
            # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
            $payment_options = $sslc->makePayment($post_data, 'hosted');

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
            }
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
