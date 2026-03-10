<!DOCTYPE html>
<html>
<head>
    <title>Debug AJAX</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test AJAX Brand Creation</h1>
    <button onclick="testAJAX()">Test Add Brand</button>
    <div id="result"></div>

    <script>
        function testAJAX() {
            const formData = {
                name: 'Test AJAX Brand',
                pic: 'AJAX PIC',
                contact: 'ajax@test.com',
                target_market: 'AJAX Market Test',
                tone: 'Friendly,Professional',
                status: 'Active'
            };

            fetch('/brands', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                document.getElementById('result').innerHTML = JSON.stringify(data, null, 2);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('result').innerHTML = 'ERROR: ' + error.message;
            });
        }
    </script>
</body>
</html>
