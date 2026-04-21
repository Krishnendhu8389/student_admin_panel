<?php
    session_start();

    $errors = $_SESSION['errors'] ?? [];
    $old    = $_SESSION['old'] ?? [];
    unset($_SESSION['errors'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-12 bg-white shadow-lg rounded-xl p-8">

<h2 class="text-2xl font-bold text-center mb-6">➕ Add Student</h2>

<form method="POST" action="?action=store" class="space-y-4">

    <div>
        <label>Name</label>
        <input type="text" name="name"
               value="<?php echo $old['name'] ?? '' ?>"
               class="w-full border p-2 rounded">

        <?php if (isset($errors['name'])): ?>
            <p class="text-red-500 text-sm"><?php echo $errors['name'] ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label>Email</label>
        <input type="text" name="email"
               value="<?php echo $old['email'] ?? '' ?>"
               class="w-full border p-2 rounded">

        <?php if (isset($errors['email'])): ?>
            <p class="text-red-500 text-sm"><?php echo $errors['email'] ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label>Phone</label>
        <input type="text" name="phone"
               value="<?php echo $old['phone'] ?? '' ?>"
               class="w-full border p-2 rounded">

        <?php if (isset($errors['phone'])): ?>
            <p class="text-red-500 text-sm"><?php echo $errors['phone'] ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label>Marks</label>
        <input type="number" name="marks" min="0" max="100"
       value="<?php echo $old['marks'] ?? '' ?>"
       class="w-full border p-2 rounded">

        <?php if (isset($errors['marks'])): ?>
            <p class="text-red-500 text-sm"><?php echo $errors['marks'] ?></p>
        <?php endif; ?>
    </div>

    <div class="flex justify-between">
        <a href="/student_admin_panel/public/" class="text-gray-600">Back</a>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Save
        </button>
    </div>

</form>

</div>

</body>
</html>