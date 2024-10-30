<!DOCTYPE html>
<html>
<head>
    <title>Date & Time Picker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-time {
            display: none;
        }
    </style>
</head>
<body>
    <h2>Date & Time Picker</h2>
    <input type="text" id="datetimepicker" placeholder="Select Date & Time">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Inisialisasi datepicker untuk memilih tanggal dan waktu
        flatpickr('#datetimepicker', {
            enableTime: true,
            altInput: true,
            altFormat: "F j, Y h:i K",
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                // Jika pengguna memilih tanggal, tampilkan bagian waktu
                document.querySelector('.flatpickr-time').style.display = 'block';
            },
            onClose: function(selectedDates, dateStr, instance) {
                // Jika pengguna menutup datepicker, sembunyikan bagian waktu
                document.querySelector('.flatpickr-time').style.display = 'none';
            }
        });
    </script>
</body>
</html>
