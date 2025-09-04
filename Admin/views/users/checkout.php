<!-- views/user/checkout.php -->
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>

    <!-- Cart Items -->
    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <h2 class="text-lg font-semibold mb-4">Your Cart</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left py-2 px-3">Product</th>
                    <th class="text-left py-2 px-3">Price</th>
                    <th class="text-left py-2 px-3">Quantity</th>
                    <th class="text-left py-2 px-3">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cart)): ?>
                    <?php $total = 0; ?>
                    <?php $total_Quantity = 0 ?>
                    <?php foreach ($cart as $item): ?>
                        <?php $subtotal = $item['product_price'] * $item['quantity']; ?>
                        <?php $total += $subtotal; ?>

                        <tr class="border-b">
                            <td class="py-2 px-3"><?= htmlspecialchars($item['product_name']) ?></td>
                            <td class="py-2 px-3">$<?= number_format($item['product_price'], 2) ?></td>
                            <td class="py-2 px-3"><?= $item['quantity'] ?></td>
                            <td class="py-2 px-3">$<?= number_format($subtotal, 2) ?></td>

                        </tr>
                        <?php $total_Quantity += $item['quantity'] ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4">Your cart is empty.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Checkout Form -->
    <form method="POST" action="index.php?page=place_order&user_id=<?= $item['user_id'] ?>" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach ($cart as $index => $item): ?>
            <input type="hidden" name="products[<?= $index ?>][id]" value="<?= $item['product_id'] ?>">
            <input type="hidden" name="products[<?= $index ?>][name]" value="<?= $item['product_name'] ?>">
            <input type="hidden" name="products[<?= $index ?>][quantity]" value="<?= $item['quantity'] ?>">
            <input type="hidden" name="products[<?= $index ?>][price]" value="<?= $item['product_price'] ?>">
        <?php endforeach; ?>

        <!-- Shipping Method -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-4">Shipping Method</h2>
            <!-- <?php print_r($shipping_methods); ?> -->
            <?php foreach ($shipping_methods as $method): ?>
                <label class="flex items-center mb-2">
                    <input type="radio" name="shipping_method" value="<?= $method['name'] ?>" required
                        class="form-radio text-blue-600">

                    <span class="ml-2"><?= htmlspecialchars($method['name']) ?>
                        ($<?= number_format($method['cost'], 2) ?> per product, <?= $method['estimated_days'] ?> days)
                        <?php $shiptotal = $method['cost'] * $total_Quantity ?>

                    </span>
                </label>
            <?php endforeach; ?>
            <input type="hidden" name="products_Quantity" value="<?= $total_Quantity ?>">
        </div>

        <!-- Payment Method -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-4">Payment Method</h2>
            <?php foreach ($payment_methods as $pmethod): ?>
                <label class="flex items-center mb-2">
                    <input type="radio" name="payment_method" value="<?= $pmethod['method'] ?>" required
                        class="form-radio text-blue-600">
                    <span class="ml-2"><?= strtoupper(htmlspecialchars($pmethod['method'])) ?></span>
                </label>
            <?php endforeach; ?>
        </div>

        <!-- Order Summary -->
        <div class="md:col-span-2 bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
            <p class="text-gray-700 mb-2">Subtotal: <span class="float-right">$<?= number_format($total, 2) ?></span></p>
            <p class="text-gray-700 mb-2">Shipping: <span class="float-right">$<?= number_format($shiptotal, 2) ?></span></p>
            <p class="font-bold text-lg">Total: <span class="float-right">$<?= number_format($total += $shiptotal, 2) ?></span></p>

            <button type="submit"
                class="w-full mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                Place Order
            </button>
            <input type="hidden" name="total_payment" value="<?= $total += $shiptotal ?>">
        </div>

    </form>
</div>