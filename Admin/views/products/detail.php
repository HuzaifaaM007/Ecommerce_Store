<?php if (!empty($products)): ?>
    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php foreach ($products as $product): ?>
                <!-- Product Image -->
                <?php if ($product['published']==1): ?>
                    <div>
                        <?php if (!empty($product['image'])): ?>
                            <img src="././../public/<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="w-full h-auto rounded shadow">
                        <?php else: ?>
                            <span class="text-gray-400">No Image</span>
                        <?php endif; ?>

                    </div>

                    <!-- Product Info -->
                    <div>
                        <h1 class="text-3xl font-bold mb-4"><?= htmlspecialchars($product['name']) ?></h1>

                        <p class="text-gray-600 mb-4">
                            <?= nl2br(htmlspecialchars($product['description'])) ?>
                        </p>

                        <p class="text-2xl text-green-600 font-bold mb-4">
                            $<?= number_format($product['price'], 2) ?>
                        </p>

                        <p class="mb-4">
                            <span class="font-semibold">Stock:</span>
                            <?php if ($product['stock'] > 0): ?>
                                <span class="text-green-600"><?= $product['stock'] ?> available</span>
                            <?php else: ?>
                                <span class="text-red-600">Out of stock</span>
                            <?php endif; ?>
                        </p>

                        <p class="mb-4 text-sm text-gray-500">
                            Added on: <?= date("F j, Y", strtotime($product['created_at'])) ?>
                        </p>

                        <!-- Add to cart button -->
                        <?php if ($session->getSessionValue('isadmin')): ?>
                            <a href="index.php?page=edit_product&id=<?= $product['id'] ?>"
                                class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Edit</a>
                            <a href="index.php?page=unpublish_product&id=<?= $product['id'] ?>"
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Unpublish</a>
                            <a href="index.php?page=delete_product&id=<?= $product['id'] ?>&name=<?= $product['name'] ?>"
                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>

                        <?php else: ?>
                            <?php if ($product['stock'] > 0): ?>
                                <a href="index.php?page=add_items_cart&action=add&id=<?= $product['id'] ?>&user_id=<?= $session->getSessionValue('id') ?>"
                                    class="bg-black text-white px-6 py-3 rounded hover:bg-gray-800">
                                    Add to Cart
                                </a>
                            <?php else: ?>
                                <button disabled class="bg-gray-400 text-white px-6 py-3 rounded cursor-not-allowed">
                                    Out of Stock
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>

    </div>
<?php else: ?>
    <div class="p-6 text-center text-red-500 text-xl">
        Product not found.
    </div>
<?php endif; ?>