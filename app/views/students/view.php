<!DOCTYPE html>
<html>
<head>
    <title>View Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-2xl mx-auto py-10 px-4">

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-6">
            <h2 class="text-2xl font-bold text-white">👤 Student Profile</h2>
            <p class="text-blue-100 text-sm mt-1">Detailed student information</p>
        </div>

        <div class="p-6 space-y-4">

            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-gray-500 text-sm">Name</p>
                <p class="text-lg font-semibold text-gray-800"><?= $data['name'] ?></p>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-gray-500 text-sm">Email</p>
                <p class="text-lg font-semibold text-gray-800"><?= $data['email'] ?></p>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-gray-500 text-sm">Phone</p>
                <p class="text-lg font-semibold text-gray-800"><?= $data['phone'] ?></p>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-gray-500 text-sm">Marks</p>
                <p class="text-lg font-semibold text-blue-600">
                    <?= $data['marks'] ?>
                </p>
            </div>
            <div class="bg-gradient-to-r from-green-50 to-blue-50 border border-blue-100 p-4 rounded-xl">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-gray-500 text-sm">Send Result Email</p>
                        <p class="text-xs text-gray-400">
                            Send marks & result to student email
                        </p>
                    </div>

                    <form method="POST" action="?action=send_email&id=<?= $data['id'] ?>">

                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                            📩 Send Email
                        </button>

                    </form>

                </div>

            </div>
        </div>

        <div class="p-4 bg-gray-50 border-t flex justify-between items-center">

            <a href="/student_admin_panel/public/"
               class="text-gray-600 hover:text-black">
                ← Back
            </a>

            <a href="?action=edit&id=<?= $data['id'] ?>"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                Edit Student
            </a>

        </div>

    </div>

</div>

</body>
</html>