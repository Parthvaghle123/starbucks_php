<!-- File: app/Views/auth/invoice_template.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Starbuck || Invoice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            background: linear-gradient(135deg, #f5f5dc 0%, #e8e8d0 100%);
            margin: 0;
            padding: 10px;
            color: #333;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: linear-gradient(145deg, #ffffff 0%, #fafafa 100%);
            padding: 25px;
            border: 2px solid #654321;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #00704A, #654321, #00704A);
        }

        .header {
            color: #654321;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            border-bottom: 2px solid #00704A;
            padding-bottom: 10px;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 2px;
            background: linear-gradient(90deg, #00704A, #654321);
        }

        .company-info {
            margin-bottom: 20px;
            text-align: center;
            background: linear-gradient(145deg, #f8f8f8, #f0f0f0);
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .company-info p {
            margin: 4px 0;
            color: #654321;
            font-size: 13px;
            font-weight: 500;
        }

        .invoice-details {
            background: linear-gradient(135deg, #00704A 0%, #005a3d 100%);
            color: white;
            padding: 10px 20px;
            display: inline-block;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 16px;
            border-radius: 6px;
            box-shadow: 0 3px 10px rgba(0, 112, 74, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .date-section {
            text-align: right;
            margin-bottom: 15px;
            background: linear-gradient(145deg, #f8f8f8, #f0f0f0);
            padding: 10px;
            border-radius: 6px;
            border-left: 3px solid #00704A;
        }

        .date-section strong {
            color: #654321;
            font-size: 14px;
        }

        .section {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
            color: #654321;
            font-size: 16px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #00704A;
            padding-bottom: 6px;
        }

        .customer-details {
            background: linear-gradient(145deg, #f9f9f9, #f0f0f0);
            padding: 15px;
            border-left: 4px solid #00704A;
            border-radius: 6px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .customer-details p {
            margin: 6px 0;
            font-size: 13px;
            line-height: 1.4;
        }

        .customer-details strong {
            color: #654321;
            min-width: 70px;
            display: inline-block;
        }

        .table-container {
            margin-top: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            table-layout: fixed;
        }

        .table th,
        .table td {
            border: 1px solid #e0e0e0;
            padding: 10px 8px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        .table thead {
            background: linear-gradient(135deg, #00704A 0%, #005a3d 100%);
        }

        .table th {
            background: linear-gradient(135deg, #00704A 0%, #005a3d 100%);
            color: #654321;
            font-weight: bold;
             font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 2px solid #00704A;
            padding: 15px 10px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }


        .table tbody tr:nth-child(even) {
            background: linear-gradient(145deg, #f8f8f8, #f0f0f0);
        }

        .table tbody tr:nth-child(odd) {
            background: white;
        }

        .table tbody tr:hover {
            background: linear-gradient(145deg, #e8f5e8, #d0f0d0);
            transition: all 0.3s ease;
        }

        .total-row {
            background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%) !important;
            font-weight: bold;
            border-top: 2px solid #00704A;
            font-size: 16px;
        }

        .total-row td {
            border-top: 2px solid #00704A;
            color: #333;
            font-weight: bold;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            border-top: 2px solid #00704A;
            padding-top: 15px;
            background: linear-gradient(145deg, #f8f8f8, #f0f0f0);
            padding: 15px;
            border-radius: 8px;
        }

        .quote {
            color: #00704A;
            font-style: italic;
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 500;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .company-signature {
            color: #654321;
            font-size: 14px;
            font-weight: bold;
            margin-top: 8px;
        }

        .status-approved {
            color: #28a745;
            font-weight: bold;
            background: linear-gradient(145deg, #d4edda, #c3e6cb);
            padding: 3px 8px;
            border-radius: 15px;
            border: 1px solid #28a745;
            font-size: 12px;
        }

        .status-cancelled {
            color: #dc3545;
            font-weight: bold;
            background: linear-gradient(145deg, #f8d7da, #f5c6cb);
            padding: 3px 8px;
            border-radius: 15px;
            border: 1px solid #dc3545;
            font-size: 12px;
        }

        



        .price-column {
            text-align: center !important;
            font-weight: 600;
            font-size: 13px;
            color: #333;
        }

        .quantity-column {
            text-align: center !important;
            font-weight: 600;
            font-size: 13px;
            color: #333;
        }

        .description-column {
            font-weight: 500;
            font-size: 13px;
            color: #333;
        }

        .table td {
            color: #333;
            font-weight: 500;
        }

        .table th:nth-child(1) {
            width: 40%;
            background: linear-gradient(135deg, #00704A 0%, #005a3d 100%);
        }

        .table th:nth-child(2) {
            width: 15%;
            background: linear-gradient(135deg, #00704A 0%, #005a3d 100%);
        }

        .table th:nth-child(3) {
            width: 20%;
            background: linear-gradient(135deg, #00704A 0%, #005a3d 100%);
        }

        .table th:nth-child(4) {
            width: 25%;
            background: linear-gradient(135deg, #00704A 0%, #005a3d 100%);
        }

        /* Enhanced table header styling */
        .table thead th {
            position: relative;
            overflow: hidden;
            font-family: 'Arial', sans-serif;
            font-weight: 900;
        }

        .table thead th::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #ffffff, #e0e0e0, #ffffff);
        }

        /* Ensure table headers are always visible */
        .table thead {
            display: table-header-group;
        }

        .table thead tr {
            background: linear-gradient(135deg, #00704A 0%, #005a3d 100%) !important;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                border: 1px solid #000;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">STARBUCKS REDESIGN</div>

        <div class="company-info">
            <p>123 Coffee Street, Seattle WA 98101</p>
            <p>Phone: 1-800-STARBUCKS</p>
            <p>http://client-ochre-tau.vercel.app/</p>
        </div>

        <div class="invoice-details">
            INVOICE #<?= esc($order['id']) ?>
        </div>

        <div class="date-section">
            <strong>Date: <?= esc(strtoupper(date("F j, Y", strtotime($order['Date'])))) ?></strong>
        </div>

        <div class="section">
            <div class="label">CUSTOMER DETAILS:</div>
            <div class="customer-details">
                <p><strong>Email:</strong> <?= esc($order['Email']) ?></p>
                <p><strong>Phone:</strong> <?= esc($order['Phone']) ?></p>
                <p><strong>Address:</strong> <?= esc($order['Address']) ?></p>
                <p><strong>Payment:</strong> <?= esc($order['Pay_Mode']) ?></p>
                <p><strong>Status:</strong>
                    <span class="<?= $order['Status'] === 'Approved' ? 'status-approved' : 'status-cancelled' ?>">
                        <?= esc($order['Status']) ?>
                    </span>
                </p>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>DESCRIPTION</th>
                        <th>QTY</th>
                        <th>PRICE</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $grandTotal = 0; ?>
                    <?php foreach ($items as $item): ?>
                        <?php
                        $total = $item['Price'] * $item['Quantity'];
                        $grandTotal += $total;
                        ?>
                        <tr>
                            <td class="description-column"><?= esc($item['Item_Name']) ?></td>
                            <td class="quantity-column"><?= $item['Quantity'] ?></td>
                            <td class="price-column"><?= number_format($item['Price'], 2) ?></td>
                            <td class="price-column"><?= number_format($total, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">
                            <strong>GRAND TOTAL</strong>
                        </td>
                        <td class="price-column">
                            <strong><?= number_format($grandTotal, 2) ?></strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <div class="quote">
                "<?php
                $quotes = [
                    "Life happens, coffee helps.",
                    "Coffee is always a good idea.",
                    "But first, coffee.",
                    "Coffee: because adulting is hard.",
                    "Rise and grind, coffee time.",
                    "Coffee makes everything better.",
                    "Fueled by coffee and determination.",
                    "Coffee: the solution to everything.",
                    "One cup at a time.",
                    "Coffee is my love language."
                ];
                echo $quotes[array_rand($quotes)];
                ?>"
            </div>
            <div class="company-signature">- Starbucks Redesign</div>
        </div>
    </div>
</body>

</html>