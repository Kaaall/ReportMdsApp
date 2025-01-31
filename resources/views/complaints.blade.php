<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Form</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <h1>Form Input Keluhan</h1>
    <textarea id="textArea" rows="5" cols="50" placeholder="Masukkan keluhan Anda..."></textarea>
    <br>
    <button id="submitBtn">Submit</button>
    <button id="generatePdfBtn">Generate PDF</button>

    <h2>Data Keluhan</h2>
    <ul id="complaintList"></ul>

    <script>
        $(document).ready(function() {
            // Submit data ke server
            $('#submitBtn').click(function() {
                let text = $('#textArea').val();
                $.ajax({
                    url: "{{ route('store.text') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        text: text
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            $('#complaintList').empty();
                            response.data.forEach(function(item) {
                                $('#complaintList').append(`<li>${item}</li>`);
                            });
                            $('#textArea').val('');
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan.');
                    }
                });
            });

            // Generate PDF
            $('#generatePdfBtn').click(function() {
                window.location.href = "{{ route('generate.pdf') }}";
            });
        });
    </script>
</body>

</html>
