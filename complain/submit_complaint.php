<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color:   #BDCE6FFF;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Submit a Complaint</h1>
        <form action="process_complaint.php" method="POST" class="mt-4">
            <div class="form-group">
                <label for="memberid">Member ID</label>
                <input type="number" class="form-control" id="memberid" name="memberid" required>
            </div>
            <div class="form-group">
                <label for="complaindescription">Complaint Description</label>
                <textarea class="form-control" id="complaindescription" name="complaindescription" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit Complaint</button>
            <a href="../member/dashboard.php" class="btn btn-primary">Back to Home</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>