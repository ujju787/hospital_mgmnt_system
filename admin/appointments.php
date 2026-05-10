<?php
session_start();
include('../php/db_connect.php');

// 1. Session Guard: If not logged in, send back to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.html");
    exit();
}

// Get all bookings
$bookings_query = "SELECT * FROM bookings ORDER BY created_at DESC";
$bookings_result = mysqli_query($conn, $bookings_query);
$all_bookings = [];
if ($bookings_result) {
    while ($row = mysqli_fetch_assoc($bookings_result)) {
        $all_bookings[] = $row;
    }
}

// Count bookings by status
$pending_count = 0;
$confirmed_count = 0;
$completed_count = 0;
$cancelled_count = 0;

foreach ($all_bookings as $booking) {
    switch ($booking['status']) {
        case 'Pending': $pending_count++; break;
        case 'Confirmed': $confirmed_count++; break;
        case 'Completed': $completed_count++; break;
        case 'Cancelled': $cancelled_count++; break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareFlow - Appointments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans text-gray-800 bg-gray-50">

    <nav class="flex items-center justify-between px-8 py-4 bg-white shadow-sm">
        <div class="flex items-center space-x-2">
            <div class="bg-emerald-500 p-2 rounded-full">
                <i class="fas fa-heartbeat text-white text-xl"></i>
            </div>
            <span class="text-2xl font-bold text-gray-700 tracking-tight"><span style="color:green;">Care</span>Flow</span>
        </div>

        <div class="hidden md:flex items-center space-x-6 text-gray-600 font-medium">
            <a href="adminDashboard.php" class="hover:text-emerald-500">Dashboard</a>
            <a href="admin.patent.html" class="hover:text-emerald-500">Patients</a>
            <a href="admin.visit.html" class="hover:text-emerald-500">Visits</a>
            <a href="admin.feedback.html" class="hover:text-emerald-500">Feedback</a>
            <a href="admin.massage.html" class="hover:text-emerald-500">Messages</a>
            <a href="appointments.php" class="text-emerald-500">Appointments</a>
            <a href="admin.registration.html" class="hover:text-emerald-500">Registration</a>
        </div>

        <div class="flex items-center space-x-4">
            <span class="text-gray-600">Welcome, <strong><?php echo htmlspecialchars($_SESSION['admin_name']); ?></strong></span>
            <a href="../php/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md font-medium hover:bg-red-600 transition">Logout</a>
        </div>
    </nav>

    <main class="px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Appointments</h1>
            <div class="flex space-x-4">
                <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg">
                    <strong><?php echo $pending_count; ?></strong> Pending
                </div>
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                    <strong><?php echo $confirmed_count; ?></strong> Confirmed
                </div>
                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
                    <strong><?php echo $completed_count; ?></strong> Completed
                </div>
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg">
                    <strong><?php echo $cancelled_count; ?></strong> Cancelled
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appointment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hospital & Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booked On</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($all_bookings as $booking): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($booking['full_name']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo $booking['age']; ?> years, <?php echo $booking['gender']; ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo date('M d, Y', strtotime($booking['booking_date'])); ?></div>
                                <div class="text-sm text-gray-500"><?php echo date('h:i A', strtotime($booking['booking_time'])); ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($booking['hospital']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars($booking['speciality']); ?> - <?php echo htmlspecialchars($booking['doctor']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($booking['contact_number']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars(substr($booking['address'], 0, 30)) . '...'; ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form method="POST" action="../php/update_booking_status.php" class="inline">
                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                    <select name="status" onchange="this.form.submit()" class="text-xs px-2 py-1 rounded-full border-0 font-semibold
                                        <?php
                                        switch($booking['status']) {
                                            case 'Confirmed': echo 'bg-green-100 text-green-800'; break;
                                            case 'Pending': echo 'bg-yellow-100 text-yellow-800'; break;
                                            case 'Completed': echo 'bg-blue-100 text-blue-800'; break;
                                            case 'Cancelled': echo 'bg-red-100 text-red-800'; break;
                                            default: echo 'bg-gray-100 text-gray-800';
                                        }
                                        ?>">
                                        <option value="Pending" <?php if($booking['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                        <option value="Confirmed" <?php if($booking['status']=='Confirmed') echo 'selected'; ?>>Confirmed</option>
                                        <option value="Completed" <?php if($booking['status']=='Completed') echo 'selected'; ?>>Completed</option>
                                        <option value="Cancelled" <?php if($booking['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo date('M d, Y h:i A', strtotime($booking['created_at'])); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="viewDetails(<?php echo $booking['id']; ?>)" class="text-emerald-600 hover:text-emerald-900 mr-3">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button onclick="deleteBooking(<?php echo $booking['id']; ?>)" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (empty($all_bookings)): ?>
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-calendar-times text-6xl mb-4"></i>
                    <h3 class="text-xl font-medium mb-2">No Appointments Yet</h3>
                    <p>Appointments booked through the website will appear here.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Modal for viewing full details -->
    <div id="detailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Appointment Details</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="modalContent" class="text-sm text-gray-600">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewDetails(bookingId) {
            // For now, just show an alert. In a real app, you'd fetch details via AJAX
            alert('View details for booking ID: ' + bookingId + '\n\nFeature coming soon!');
        }

        function deleteBooking(bookingId) {
            if (confirm('Are you sure you want to delete this appointment?')) {
                // Create a form to submit delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '../php/delete_booking.php';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'booking_id';
                input.value = bookingId;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function closeModal() {
            document.getElementById('detailsModal').classList.add('hidden');
        }
    </script>
</body>
</html>