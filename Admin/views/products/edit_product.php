<!-- views/admin/add_product.php -->

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Edit Product</h2>

    <!-- Error Messages -->
    <?php

    use models\Product\Product;

    if (!empty($errors)): ?>
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

    <?php if (!empty($products)): ?>
        <form action="index.php?page=edit_product" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
           
            <?php foreach ($products as $product): ?>

                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Category</label>
                    <select name="category_id" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"
                                <?= ($product['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Product Name -->
                <div class="mb-4">
                    <input type="hidden" name="id"
                        value="<?= htmlspecialchars($product['id']) ?>"
                        <label class="block text-gray-700 font-medium mb-2">Product Name</label>
                    <input type="text" name="name"
                        value="<?= htmlspecialchars($_POST['name'] ?? $product['name']) ?>"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <input type="hidden" name="old_image"
                        value="<?= htmlspecialchars($product['image']) ?>"
                        <label class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"><?= htmlspecialchars($_POST['description'] ?? $product['description']) ?></textarea>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Price</label>
                    <input type="number" step="0.01" name="price"
                        value="<?= htmlspecialchars($_POST['price'] ?? $product['price']) ?>"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                <!-- Stock -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Stock</label>
                    <input type="number" name="stock"
                        value="<?= htmlspecialchars($_POST['stock'] ?? $product['stock']) ?>"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                <!-- Image -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Product Image</label>
                    <?php if (!empty($product['image'])): ?>
                        <img src="public/<?= htmlspecialchars($product['image']) ?>" alt="Current Image" class="w-32 h-32 mb-2">
                    <?php endif; ?>
                    <input type="file" name="image" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                </div>
                <!-- Published -->
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="published" value="1"
                            <?= !empty($product['published']) ? 'checked' : '' ?>
                            class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="ml-2 text-gray-700">Published</span>
                    </label>

                </div>
            <?php endforeach; ?>
            <!-- Buttons -->
            <div class="flex justify-end gap-3">
                <a href="index.php?page=manage_products"
                    class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Cancel</a>
                <button type="submit" name="submit"
                    class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save Product</button>
            </div>
        </form>
    <?php else: ?>
        <div class="p-6 text-center text-red-500 text-xl">
            Product not found.
        </div>
    <?php endif; ?>
</div>