<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İş Çizelgesi</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
</head>
<body class="bg-gray-100 p-10">
<div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-6 text-center">İş Çizelgesi</h1>
    <p class="text-center mb-10">Tüm işler, başlangıçtan sonra {{ $totalHours->total_hours ?? 0 }} saat sonra tamamlanmış olacaktır. Yani iş minimum {{ round(($totalHours->total_hours ?? 0)/45, 2) }} haftalık bir süreçte tamamlanacaktır.</p>

    <table id="assignmentsTable" class="display nowrap w-full border-collapse border border-gray-300">
        <thead>
        <tr class="bg-gray-200">
            <th class="border border-gray-300 px-4 py-2">Dev.</th>
            <th class="border border-gray-300 px-4 py-2">Task</th>
            <th class="border border-gray-300 px-4 py-2">Tahmini Süre (Saat)</th>
            <th class="border border-gray-300 px-4 py-2">Zorluk</th>
            <th class="border border-gray-300 px-4 py-2">Task Süresi (Saat)</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($assignments as $assignment)
            <tr class="bg-white border-b hover:bg-gray-100">
                <td class="border border-gray-300 px-4 py-2">{{ $assignment->developer->name }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $assignment->task->name }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $assignment->estimated_completion_time }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $assignment->task->difficulty }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $assignment->task->duration }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-6 text-right">
        <p class="text-lg font-bold">
            İşim tamamlanacağı toplam süre: <span class="text-green-600">{{ $totalHours->total_hours }} hours</span>
        </p>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#assignmentsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'print'
            ],
            responsive: true,
            pageLength: 50,
            order: [[2, 'asc']],
        });
    });
</script>
</body>
</html>
