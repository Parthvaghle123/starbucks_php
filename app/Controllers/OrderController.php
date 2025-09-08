<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use Dompdf\Dompdf;

class OrderController extends BaseController
{
    public function downloadBill($orderId)
    {
        $orderModel = new OrderModel();
        $itemModel = new OrderItemModel();

        $order = $orderModel->find($orderId);
        if (!$order) {
            return redirect()->to('/orders')->with('error', 'Order not found!');
        }

        $items = $itemModel->where('order_id', $orderId)->findAll();

        $data = [
            'order' => $order,
            'items' => $items
        ];

        $html = view('auth/invoice_template', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Starbucks_Invoice_{$orderId}.pdf", ["Attachment" => true]);
    }
}   
