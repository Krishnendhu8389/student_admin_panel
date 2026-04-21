<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-2xl mx-auto py-10">

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-6">
            <h2 class="text-2xl font-bold text-white">✏️ Edit Student</h2>
            <p class="text-blue-100 text-sm mt-1">Update student information</p>
        </div>

        <form method="POST" action="?action=update&id=<?= $data['id'] ?>" class="p-6 space-y-4">

            <div>
                <label class="text-sm text-gray-600">Name</label>
                <input type="text" name="name" value="<?= $data['name'] ?>"
                       class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="text-sm text-gray-600">Email</label>
                <input type="text" name="email" value="<?= $data['email'] ?>"
                       class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="text-sm text-gray-600">Phone</label>
                <input type="text" name="phone" value="<?= $data['phone'] ?>"
                       class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="text-sm text-gray-600">Marks</label>
                <input type="number" name="marks" value="<?= $data['marks'] ?>"
                       class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="flex justify-between items-center pt-4">

                <a href="/student_admin_panel/public/"
                   class="text-gray-600 hover:text-black">
                    ← Back
                </a>

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                    Update Student
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>