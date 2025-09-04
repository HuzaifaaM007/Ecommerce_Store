<!-- views/admin/products.php -->

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Manage Products</h2>
    <!-- Error Messages -->
    <?php if (!empty($errors)): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Success Message -->
    <?php if (!empty($success)): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <!-- Add Product Button -->
    <div class="mb-4">
        <a href="index.php?page=add_products"
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            + Add Product
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h3 class="text-lg font-semibold">Product List</h3>
        </div>

        <?php if (!empty($products)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- <?php print_r($products) ?> -->
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-800"><?= $product['id'] ?></td>
                                <td class="py-3 px-4 flex items-center">
                                    <img src="././../public/<?= htmlspecialchars($product['image']) ?>"
                                        alt="<?= htmlspecialchars($product['name']) ?>"
                                        class="w-16 h-16 object-cover mr-4 rounded">
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-800"><?= $product['name'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-800"><?= $product['category_id'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-800">$<?= $product['price'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-800"><?= $product['stock'] ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                                        <?php if ($product['stock'] > 0) echo 'bg-green-100 text-green-700';
                                        else echo 'bg-red-100 text-red-700'; ?>">
                                        <?= $product['stock'] > 0 ? 'Available' : 'Out of Stock' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm flex gap-2">
                                    <a href="index.php?page=product_details&id=<?= $product['id'] ?>"
                                        class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">View</a>
                                    <a href="index.php?page=edit_product&id=<?= $product['id'] ?>"
                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Edit</a>
                                    <?php if ($product['published']): ?>
                                        <a href="index.php?page=unpublish_product&id=<?= $product['id'] ?>&name=<?= $product['name'] ?>&published=0"
                                            class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Unpublish</a>
                                    <?php else: ?>
                                        <a href="index.php?page=publish_product&id=<?= $product['id'] ?>&name=<?= $product['name'] ?>&published=1"
                                            class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">publish</a>

                                    <?php endif; ?>
                                    <a href="index.php?page=delete_product&id=<?= $product['id'] ?>&name=<?= $product['name'] ?>"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                        onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="p-4 text-gray-600">No products found.</p>
        <?php endif; ?>
    </div>
</div>