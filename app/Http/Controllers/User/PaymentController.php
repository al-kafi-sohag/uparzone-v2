<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\DB;
use App\Models\UserTransaction;
use App\Models\UserPayment;
use Illuminate\Support\Facades\Log;
use App\Services\UserTransactionService;

class PaymentController extends Controller
{
    public UserTransactionService $userTransactionService;

    public function __construct(UserTransactionService $userTransactionService)
    {
        $this->userTransactionService = $userTransactionService;
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
                $userTransaction = $this->userTransactionService->createTransaction(null, $user->id, config('app.premium_price'), 'Premium Payment', UserTransaction::STATUS_PENDING, UserTransaction::TYPE_DEBIT);

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
            $post_data['val_id'] = $userPayment->id;
            $post_data['user_id'] = $user->id;
            $post_data['payment_id'] = $userPayment->id;
            $post_data['user_name'] = $user->name;

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

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $payment = UserPayment::where('user_transaction_id', $tran_id)->first();
        $payment->details = json_encode($request->all());
        $payment->save();

        $sslc = new SslCommerzNotification();

        if ($payment->status == UserPayment::STATUS_PENDING) {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                $payment->update(['status' => UserPayment::STATUS_COMPLETED]);
                Log::info("Updated payment $payment");
                sweetalert()->success('Transaction is successfully Completed');
            }
            Log::info("Validation".$validation);
        } else if ($payment->status == UserPayment::STATUS_COMPLETED) {
            sweetalert()->success('Transaction is successfully Completed');
        } else {
            sweetalert()->error('Transaction failed');
        }
        return redirect()->route('user.home');
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $payment = UserPayment::where('user_transaction_id', $tran_id)->first();
        $payment->details = json_encode($request->all());
        $payment->save();

        if ($payment->status == UserPayment::STATUS_PENDING) {
            $payment->update(['status' => UserPayment::STATUS_FAILED]);
            sweetalert()->error('Transaction is Falied');
        } else if ($payment->status == UserPayment::STATUS_COMPLETED || $payment->status == UserPayment::STATUS_FAILED) {
            sweetalert()->warning('Transaction is already Successful');
        } else {
            sweetalert()->error('Transaction is Invalid');
        }

        return redirect()->route('user.wallet');
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $payment = UserPayment::where('user_transaction_id', $tran_id)->first();
        $payment->details = json_encode($request->all());
        $payment->save();

        if ($payment->status == UserPayment::STATUS_PENDING) {
            $payment->update(['status' => UserPayment::STATUS_CANCELLED]);
            sweetalert()->error('Transaction is Cancel');
        } else if ($payment->status == UserPayment::STATUS_COMPLETED || $payment->status == UserPayment::STATUS_FAILED) {
            sweetalert()->warning('Transaction is already Successful');
        } else {
            sweetalert()->error('Transaction is Invalid');
        }
        return redirect()->route('user.wallet');
    }

    public function ipn(Request $request)
    {
        Log::info("IPN: ".json_encode($request->all()));
        if ($request->input('tran_id')) {

            $tran_id = $request->input('tran_id');
            $payment = UserPayment::where('user_transaction_id', $tran_id)->first();
            $payment->details = json_encode($request->all());
            $payment->save();

            if ($payment->status == UserPayment::STATUS_PENDING) {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $payment->amount, $payment->currency);
                if ($validation == TRUE) {
                    Log::info("Payment validated successfully via IPN Payment ID: ".$payment->id);
                    $payment->update(['status' => UserPayment::STATUS_COMPLETED]);
                    sweetalert()->success('Transaction is successfully Completed');
                }
            } else if ($payment->status == UserPayment::STATUS_COMPLETED || $payment->status == UserPayment::STATUS_FAILED || $payment->status == UserPayment::STATUS_CANCELLED) {
                Log::info("Transaction is already Processed Payment ID: ".$payment->id);
            } else {
                Log::info("Invalid Transaction Payment ID: ".$payment->id);
            }
        } else {
            Log::info("Invalid Data from IPN");
        }
    }



}
