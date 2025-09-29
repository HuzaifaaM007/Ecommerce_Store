<?php
require_once __DIR__ . "/../../../core/Session.php";

$session = core\Session\Session::getInstance();

// $session->setSessionValue("show_Login",false) ;
$showLogin = false;
$showRegister = false;
$error = "";



?>
<div class="container mx-auto px-6 py-8 flex-grow">
    <h1 class="text-2xl font-bold mb-6">Shopping Cart</h1>

    <?php if (!empty($cartItems)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg shadow">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4">Product</th>
                        <th class="text-left py-3 px-4">Price</th>
                        <th class="text-left py-3 px-4">Quantity</th>
                        <th class="text-left py-3 px-4">Total</th>
                        <th class="text-left py-3 px-4">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if ($session->has('id')) :
                        $grandTotal = 0;
                        foreach ($cartItems as $item):
                            $itemTotal = $item['subtotal'];
                            $grandTotal += $itemTotal;

                    ?>
                            <tr class="border-t">
                                <td class="py-3 px-4 flex items-center">
                                    <img src="./././public/<?= htmlspecialchars($item['image_URL']) ?>"
                                        alt="<?= htmlspecialchars($item['product_name']) ?>"
                                        class="w-16 h-16 object-cover mr-4 rounded">
                                    <span><?= htmlspecialchars($item['product_name']) ?></span>
                                </td>
                                <td class="py-3 px-4">$<?= number_format($item['product_price'], 2) ?></td>
                                <td class="py-3 px-4">
                                    <form action="index.php?page=update_cart" method="POST" class="flex items-center space-x-2">
                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">

                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>"
                                            min="1" max="<?= $item['stock'] ?>" class="w-16 border px-2 py-1 rounded">
                                        <button type="submit" class="bg-black text-white px-2 py-1 rounded hover:bg-gray-800">Update</button>
                                    </form>
                                </td>
                                <td class="py-3 px-4">$<?= number_format($itemTotal, 2) ?></td>
                                <td class="py-3 px-4">
                                    <a href="index.php?page=remove_cart_items&id=<?= $item['product_id'] ?>"
                                        class="text-red-600 hover:underline">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php
                        $grandTotal = 0;
                        // print_r($cartItems);
                        foreach ($cartItems as $products):
                            foreach ($products as $item) :
                                $itemTotal = $item['subtotal']*$products_Quantity[$item['product_id']];
                                $grandTotal += $itemTotal;

                        ?>
                                <tr class="border-t">
                                    <td class="py-3 px-4 flex items-center">
                                        <img src="./././public/<?= htmlspecialchars($item['image_URL']) ?>"
                                            alt="<?= htmlspecialchars($item['product_name']) ?>"
                                            class="w-16 h-16 object-cover mr-4 rounded">
                                        <span><?= htmlspecialchars($item['product_name']) ?></span>
                                    </td>
                                    <td class="py-3 px-4">$<?= number_format($item['product_price'], 2) ?></td>
                                    <td class="py-3 px-4">
                                        <form action="index.php?page=update_cart_without" method="POST" class="flex items-center space-x-2">
                                            <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">

                                            <input type="number" name="quantity" value="<?= $products_Quantity[$item['product_id']] ?>"
                                                min="1" max="<?= $item['stock'] ?>" class="w-16 border px-2 py-1 rounded">
                                            <button type="submit" class="bg-black text-white px-2 py-1 rounded hover:bg-gray-800">Update</button>
                                        </form>
                                    </td>
                                    <td class="py-3 px-4">$<?= number_format($itemTotal, 2) ?></td>
                                    <td class="py-3 px-4">
                                        <a href="index.php?page=remove_cart_items_without&id=<?= $item['product_id'] ?>"
                                            class="text-red-600 hover:underline">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot class="bg-gray-100">
                    <tr>
                        <td colspan="3" class="text-right font-bold py-3 px-4">Grand Total:</td>
                        <td colspan="2" class="font-bold py-3 px-4">
                            $<?= number_format($grandTotal, 2) ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="index.php?page=products"
                class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-300">
                Continue Shopping
            </a>
            <?php if ($session->has('id')) : ?>

                <a href="index.php?page=check_out"
                    class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800">
                    Checkout
                </a>
                <a href="index.php?page=clear_cart"
                    class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-300">
                    Clear Cart.
                </a>
            <?php else: ?>

                <!-- <a href="index.php?page=check_out_without"
                class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800">
                Checkout
            </a> -->

                <form id="login_form" method="post">
                    <input type="hidden" name="login" value="1">
                </form>

                <a href="<?= htmlspecialchars($url) ?>&login=1" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800">Checkout </a>
<!-- 
                <Button type="submit"
                    form="login_form" name="check_out_login"
                    class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800">
                    Checkout </Button> -->

                <a href="index.php?page=clear_cart_without"
                    class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-300">
                    Clear Cart.
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-600">Your cart is empty.</p>
        <a href="index.php?page=products"
            class="mt-4 inline-block bg-black text-white px-4 py-2 rounded hover:bg-gray-800">
            Browse Products
        </a>
    <?php endif; ?>
</div>