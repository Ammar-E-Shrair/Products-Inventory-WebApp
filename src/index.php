<?php
session_start();

// المنتجات الافتراضية (تستخدم فقط أول مرة)
$defaultProducts = [
    [
        'id' => 1,
        'name' => 'Running Shoes',
        'description' => 'Lightweight sports shoes designed for running and training.',
        'price' => 75.50,
        'category' => 'Clothing'
    ],
    [
        'id' => 2,
        'name' => 'Coffee Maker',
        'description' => 'Automatic drip coffee maker with 12-cup capacity.',
        'price' => 89.99,
        'category' => 'Home'
    ],
];

$categories = ["Electronics", "Books", "Clothing", "Home", "Other"];
$submittedData = [];
$errors = [];
$successMessage = "";

// ✅ تهيئة المنتجات داخل السيشن مرة واحدة
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = $defaultProducts;
}

// ✅ خلي المنتجات تشتغل من session
$products = &$_SESSION['products'];

// ✅ إظهار رسالة نجاح بعد Redirect
if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    unset($_SESSION['successMessage']);
}

// معالجة الفورم
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submittedData = [
        "name" => htmlspecialchars(trim($_POST["name"] ?? "")),
        "description" => htmlspecialchars(trim($_POST["description"] ?? "")),
        "price" => htmlspecialchars(trim($_POST["price"] ?? "")),
        "category" => htmlspecialchars(trim($_POST["category"] ?? ""))
    ];

    // Validation
    if ($submittedData["name"] === "") {
        $errors["name"] = "Product name is required.";
    }
    if ($submittedData["description"] === "") {
        $errors["description"] = "Description is required.";
    }
    if ($submittedData["price"] === "" || !is_numeric($submittedData["price"]) || $submittedData["price"] <= 0) {
        $errors["price"] = "Enter a valid positive price.";
    }
    if ($submittedData["category"] === "" || !in_array($submittedData["category"], $categories)) {
        $errors["category"] = "Please select a valid category.";
    }

    // ✅ Add product
    if (empty($errors)) {
        $lastId = empty($products) ? 0 : max(array_column($products, 'id'));
        $newId = $lastId + 1;

        $products[] = [
            "id" => $newId,
            "name" => $submittedData["name"],
            "description" => $submittedData["description"],
            "price" => (float)$submittedData["price"],
            "category" => $submittedData["category"]
        ];

        // ✅ PRG Pattern لمنع تكرار الإضافة عند Refresh
        $_SESSION['successMessage'] = "Product added successfully!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Product Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4 text-center">Product Inventory</h1>
        <!-- Alerts -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">Please fix the errors below.</div>
        <?php endif; ?>
        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>
        <!-- Product Table -->
        <div class="card mb-4 shadow">
            <div class="card-header bg-primary text-white">Product List</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price ($)</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><?= (int)$p["id"] ?></td>
                                <td><?= htmlspecialchars($p["name"]) ?></td>
                                <td><?= htmlspecialchars($p["description"]) ?></td>
                                <td><?= number_format((float)$p["price"], 2) ?></td>
                                <td><?= htmlspecialchars($p["category"]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Product Form -->
        <div class="card shadow">
            <div class="card-header bg-success text-white">Add New Product</div>
            <div class="card-body">
                <form method="POST" action="">
                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name"
                            class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($submittedData['name'] ?? '') ?>">
                        <?php if (isset($errors['name'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['name']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                            class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"><?= htmlspecialchars($submittedData['description'] ?? '') ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['description']) ?></div>
                        <?php endif; ?>
                    </div>
                    <!-- Price -->
                    <div class="mb-3">
                        <label class="form-label">Price ($)</label>
                        <input type="text" name="price"
                            class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($submittedData['price'] ?? '') ?>">
                        <?php if (isset($errors['price'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['price']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select <?= isset($errors['category']) ? 'is-invalid' : '' ?>">
                            <option value="">-- Select --</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= htmlspecialchars($c) ?>"
                                    <?= (isset($submittedData['category']) && $submittedData['category'] === $c) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['category'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['category']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success">Add Product</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>