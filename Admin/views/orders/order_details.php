<!-- views/admin/view_order.php -->

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Order Details</h2>

    <?php if (!empty($order)): ?>
        <!-- Order Info -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Order Information</h3>
            <p><strong>Order ID:</strong> <?= $order['order_id'] ?></p>
            <p><strong>Status:</strong> <?= ucfirst($order['status']) ?></p>
            <p><strong>Date:</strong> <?= $order['order_date'] ?></p>
            <p><strong>Total Amount:</strong> $<?= $order['total_amount'] ?></p>
        </div>

        <!-- User Info -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
            <p><strong>Name:</strong> <?= $order['user_name'] ?></p>
            <p><strong>Email:</strong> <?= $order['email'] ?></p>
            <p><strong>Phone:</strong> <?= $order['phone'] ?></p>
        </div>

        <!-- Shipping Info -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Shipping Information</h3>
            <p><strong>Address:</strong> <?= $order['address'] ?></p>
            <p><strong>Shipping Method:</strong> <?= $order['shipping_method'] ?></p>
            <!-- <p><strong>Postal Code:</strong> <?= $order['postal_code'] ?></p> -->
        </div>

        <!-- Payment Info -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Payment Information</h3>
            <p><strong>Payment Method:</strong> <?= $order['payment_method'] ?></p>
            <p><strong>Transaction ID:</strong> <?= $order['transaction_id'] ?? 'null' ?></p>
        </div>

        <!-- Ordered Products -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Ordered Products</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- <?php print_r($order_items)?> -->
                        <?php foreach ($order_items[$order['order_id']  ] as $item): ?>
                             <!-- <?php print_r($item)?> -->
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-800"><?= $item['product_name'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-800"><?= $item['quantity'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-800">$<?= $item['price'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-800">$<?= $item['quantity'] * $item['price'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>
        <p class="p-4 text-gray-600">Order not found.</p>
    <?php endif; ?>

    <div class="mt-6">
        <a href="index.php?page=orders" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Back to Orders
        </a>
    </div>
</div>
