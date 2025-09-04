<div class="container mx-auto px-6 py-8 flex-1">
    <h1 class="text-2xl font-bold mb-6">Our Products</h1>

    <?php if (!empty($products)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($products as $product): ?>
                <?php if ($product['published'] === 1): ?>
                    <div class="bg-white rounded-lg shadow-md p-4 flex flex-col">
                        <!-- Product Image -->
                        <div class="h-40 flex items-center justify-center mb-4 bg-gray-100 rounded">
                            <?php if (!empty($product['image'])): ?>
                                <img src="././././public/<?= htmlspecialchars($product['image']) ?>"

                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                    class="max-h-36 object-contain">
                            <?php else: ?>
                                <span class="text-gray-400">No Image</span>
                            <?php endif; ?>
                        </div>

                        <!-- Product Info -->
                        <h2 class="text-lg font-semibold mb-2">
                            <?= htmlspecialchars($product['name']) ?>
                            <!-- <?= htmlspecialchars($product['id']) ?> -->
                        </h2>
                        <p class="text-gray-600 text-sm flex-1">
                            <?= htmlspecialchars(substr($product['description'], 0, 60)) ?>...
                        </p>

                        <!-- Price & Actions -->
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-lg font-bold text-green-600">
                                $<?= number_format($product['price'], 2) ?>
                            </span>
                            <a href="index.php?page=product_details&id=<?= $product['id'] ?>"
                                class="bg-black text-white px-3 py-1 rounded hover:bg-gray-800 text-sm">
                                View
                            </a>
                        </div>

                        <?php if ($product['stock'] > 0): ?>
                            <a href="index.php?page=add_items_cart&id=<?= $product['id'] ?>&user_id=<?= $session->getSessionValue('id') ?>"
                                class="mt-3 text-center bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700">
                                Add to Cart
                            </a>
                        <?php else: ?>
                            <p class="mt-3 text-center text-red-500 font-semibold">Out of Stock</p>
                        <?php endif; ?>
                    </div>
                    
                <?php endif; ?>
            <?php endforeach; ?>
            
        </div>
    <?php else: ?>
        <p class="text-gray-600">No products available.</p>
    <?php endif; ?>
</div>