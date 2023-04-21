<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayRequest;
use App\Lib\JWT\JWT;
use App\Models\Order;
use Libraries\Request\Request;

class PaymentController extends Controller
{

    public function pay(PayRequest $request): void
    {
        $data = $request->validated();
        $order = Order::getCart();
        if ($order->total === 0) {
            response()->json([
                'status' => false,
                'data' => [
                    'message' => 'Nothing in cart',
                ],
            ]);
        }

        $order->update([
            'address' => $data['address'],
            'phone' => $data['phone'],
            'bank_code' => $data['bank_code'],
            'transaction_code' => '',
            'created_at' => now()->toDateTimeString(),
        ]);
        $return_url = url('pay/verify');
        $url = $this->createPaymentUrl($order->total, $data['bank_code'], $return_url, $order->id);

        response()->json([
            'status' => true,
            'data' => [
                'url' => $url,
            ],
        ]);
    }

    public function verifyPayment(Request $request): void
    {
        $inputData = [];
        foreach ($_GET as $key => $value) {
            if (str_starts_with($key, "vnp_")) {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i === 1) {
                $hashData .= '&'.urlencode($key)."=".urlencode($value);
            } else {
                $hashData .= urlencode($key)."=".urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, env('VNP_HASH_SECRET'));
        if ($secureHash !== $vnp_SecureHash) {
            throwHttpException('Invalid signature', 403);
        }
        $data = $request->all();
        if (! isset($data['vnp_TxnRef'], $data['vnp_BankCode'])) {
            throwHttpException('Bad request', 403);
        }

        (new Order)->where('id', $data['vnp_TxnRef'])->update([
            'status' => 'Payment successfully',
            'transaction_code' => $request->get('vnp_BankCode'),
        ]);

        response()->json([
            'status' => true,
            'data' => [
                'message' => 'Payment successfully',
            ],
        ]);
    }

    private function createPaymentUrl($amount, $bank_code, $return_url, $order_id): string
    {
        $vnp_TmnCode = env('VNP_TMNCODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_Url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $vnp_ReturnUrl = $return_url;
        $startTime = date('YmdHis');
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_Amount = $amount;
        $vnp_Locale = 'vn';
        $vnp_BankCode = $bank_code;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_Amount' => $vnp_Amount * 100,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $vnp_IpAddr,
            'vnp_Locale' => $vnp_Locale,
            'vnp_OrderInfo' => 'Thanh toan GDnh toan GDnh toan GDnh toan GD:' . $order_id,
            'vnp_OrderType' => 'other',
            'vnp_ReturnUrl' => $vnp_ReturnUrl,
            'vnp_TxnRef' => $order_id,
            'vnp_ExpireDate'=>$expire
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode !== '') {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = '';
        $i = 0;
        $hash_data = '';
        foreach ($inputData as $key => $value) {
            if ($i === 1) {
                $hash_data .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hash_data .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }

        $vnp_Url .= '?'.$query;
        $vnpSecureHash = hash_hmac('sha512', $hash_data, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        return $vnp_Url;
    }

}