<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

<div class="max-w-6xl mx-auto py-8 px-4 space-y-5">

    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-xl shadow-md p-5 text-white flex justify-between items-center">

        <div>
            <h1 class="text-2xl font-bold">🎓 Student Dashboard</h1>
            <p class="text-white/80 text-sm">Manage students & marks</p>
        </div>

        <a href="?action=create"
           class="bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold shadow hover:scale-105 transition text-sm">
            + Add Student
        </a>

    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

        <div class="bg-white rounded-lg shadow-sm p-4">
            <p class="text-xs text-gray-500">Students</p>
            <h2 class="text-xl font-bold text-blue-600"><?= $stats['total_students'] ?? 0 ?></h2>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <p class="text-xs text-gray-500">Exam Total Marks</p>
                <h2 class="text-lg font-bold text-gray-800"><?= $examTotal ?></h2>
            </div>

            <form method="POST" action="?action=update_exam_marks" class="flex items-center gap-2">

                <input type="number"
                    name="exam_total_marks"
                    value="<?= $examTotal ?>"
                    class="border rounded-md px-3 py-2 w-24 text-sm focus:ring-2 focus:ring-blue-400">

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                    Save
                </button>

            </form>

        </div>

        <div class="bg-white rounded-lg shadow-sm p-4">
            <p class="text-xs text-gray-500">Highest</p>
            <h2 class="text-xl font-bold text-yellow-600"><?= $stats['highest_marks'] ?? 0 ?></h2>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4">
            <p class="text-xs text-gray-500">Average</p>
            <h2 class="text-xl font-bold text-purple-600">
                <?= round($stats['avg_marks'] ?? 0, 2) ?>
            </h2>
        </div>

    </div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">

<div class="p-4 border-b flex flex-col lg:flex-row lg:justify-between lg:items-center gap-3">

    <div>
        <h2 class="font-semibold text-gray-700">Students</h2>
        <p class="text-xs text-gray-400">Latest records</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-3 lg:items-center">

        <div class="flex gap-2">

            <a href="?action=export_pdf"
               class="bg-red-100 text-red-700 px-3 py-1 rounded-md text-xs hover:bg-red-200">
                📄 PDF
            </a>

            <a href="?action=export_excel"
               class="bg-green-100 text-green-700 px-3 py-1 rounded-md text-xs hover:bg-green-200">
                📊 Excel
            </a>

            <label class="bg-blue-100 text-blue-700 px-3 py-1 rounded-md text-xs hover:bg-blue-200 cursor-pointer">
                ⬆ Import
                <input type="file" name="import_file" class="hidden">
            </label>

        </div>

        <form method="GET" class="flex flex-wrap gap-2 items-center">

            <select name="sort" class="border rounded-md px-2 py-1 text-xs">
                <option value="">Sort</option>
                <option value="asc">Low → High</option>
                <option value="desc">High → Low</option>
            </select>

            <input type="number" name="min" placeholder="Min"
                   class="border rounded-md px-2 py-1 text-xs w-16">

            <input type="number" name="max" placeholder="Max"
                   class="border rounded-md px-2 py-1 text-xs w-16">

            <input type="number" name="from" placeholder="From"
                   class="border rounded-md px-2 py-1 text-xs w-16">

            <input type="number" name="to" placeholder="To"
                   class="border rounded-md px-2 py-1 text-xs w-16">

            <button class="bg-blue-600 text-white px-3 py-1 rounded-md text-xs hover:bg-blue-700">
                Apply
            </button>

            <a href="/student_admin_panel/public/"
               class="text-gray-500 text-xs hover:text-black">
                Reset
            </a>

        </form>

    </div>

</div>

<div class="overflow-x-auto">

    <table class="w-full text-sm">
            

                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Phone</th>
                        <th class="p-3 text-left">Marks</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php while ($row = $students->fetch_assoc()) { ?>

                    <tr class="border-t hover:bg-gray-50">

                        <td class="p-3"><?= $row['id'] ?></td>
                        <td class="p-3 font-medium"><?= $row['name'] ?></td>
                        <td class="p-3 text-gray-500"><?= $row['email'] ?></td>
                        <td class="p-3 text-gray-500"><?= $row['phone'] ?></td>

                        <td class="p-3">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                                <?= $row['marks'] ?> / <?= $examTotal ?>
                            </span>
                        </td>

                        <td class="p-3">
                            <?php if ($row['marks'] >= ($examTotal / 2)): ?>
                                <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded">
                                    Pass
                                </span>
                            <?php else: ?>
                                <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">
                                    Fail
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="p-3 flex gap-2">

                            <a href="?action=view&id=<?= $row['id'] ?>"
                               class="text-xs px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">
                                View
                            </a>

                            <a href="?action=edit&id=<?= $row['id'] ?>"
                               class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">
                                Edit
                            </a>

                            <a href="?action=delete&id=<?= $row['id'] ?>"
                               class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

            <div class="flex justify-between items-center p-4 bg-white border-t">

                <p class="text-xs text-gray-500">
                    Showing page <?= $page ?> of <?= $totalPages ?>
                </p>

                <div class="flex gap-2">

                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>"
                        class="px-3 py-1 text-sm bg-gray-100 rounded hover:bg-gray-200">
                            Prev
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                        <a href="?page=<?= $i ?>"
                        class="px-3 py-1 text-sm rounded 
                        <?= ($page == $i) ? 'bg-blue-600 text-white' : 'bg-gray-100 hover:bg-gray-200' ?>">
                            <?= $i ?>
                        </a>

                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>"
                        class="px-3 py-1 text-sm bg-gray-100 rounded hover:bg-gray-200">
                            Next
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>