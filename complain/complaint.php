<!DOCTYPE html>
<html>
<head>
  <title>Complaints Database</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color:   #BDCE6FFF;
    }
    table{
      /* border-collapse: collapse; */
      background-color: #7A7B72FF;
     text-align: center; 
    }
    table tr td{
      color:rgb(0, 0, 0);
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Complaints Database</h1>
    <table class="table table-striped" id="complaintsTable" border="2">
      <thead>
        <tr>
          <th>Complain ID</th>
          <th>Member ID</th>
          <th>Complaint Description</th>
          <th>Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data will be inserted here -->
      </tbody>
    </table>
    <div class="text-center">
            <a href="..//login/home.php" class="btn btn-primary">Back to Home</a>
        </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      fetchComplaints();

      function fetchComplaints() {
        $.ajax({
          url: 'fetch_complaints.php',
          method: 'GET', // Use GET to fetch data
          dataType: 'json', // Expect JSON response
          success: function(data) {
            const tbody = $('#complaintsTable tbody');
            tbody.empty(); // Clear existing rows
            data.forEach(complaint => {
              tbody.append(`
                <tr>
                  <td>${complaint.complainid}</td>
                  <td>${complaint.memberid}</td>
                  <td>${complaint.complaindescription}</td>
                  <td>${complaint.date}</td>
                  <td>${complaint.status}</td>
                  <td>
                    <button class="btn btn-primary" onclick="updateStatus(${complaint.complainid})">Update Status</button>
                  </td>
                </tr>
              `);
            });
          },
          error: function(error) {
            alert('Error fetching complaints.');
          }
        });
      }

      window.updateStatus = function(complainId) {
        const newStatus = prompt("Enter new status:");
        if (newStatus) {
          $.ajax({
            url: 'update_status.php',
            method: 'POST',
            data: { complainid: complainId, status: newStatus },
            success: function(response) {
              if (response.success) {
                alert('Status updated successfully!');
                fetchComplaints(); // Refresh the table
              } else {
                alert('Error updating status: ' + response.error);
              }
            },
            error: function(error) {
              alert('Error updating status.');
            }
          });
        }
      };
    });
  </script>
</body>
</html>