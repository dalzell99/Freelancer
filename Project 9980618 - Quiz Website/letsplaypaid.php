<html>
    <head></head>
    <body>
        <button id='button'>Let's Play</button>
        <script>
            window.onload = function() {
                if (sessionStorage.loggedIn == 'false') {
                    document.getElementById('button').onclick = function() {
                        alert("Please login or signup to proceed");
                    }
                } else {
                    document.getElementById('button').onclick = function() {
                        window.location = 'quizzes.php?type=paid';
                    }
                }
            }
        </script>
    </body>
</html>