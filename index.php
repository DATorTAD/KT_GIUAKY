<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Information</title>
</head>
<body>
  <table border="1">
    <tr>
      <th>Mã Nhân Viên</th>
      <th>THÔNG TIN NHÂN VIÊN</th>
    </tr>
    <?php
    // Connect to MySQL 
    $mysqli = new mysqli('127.0.0.1', 'root@localhost', 'quanlysv');

    // Check for errors
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Get the total number of employees
    $sql_count = 'SELECT COUNT(*) as total FROM employees';
    $result_count = $mysqli->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    $total_employees = $row_count['total'];

    // Calculate the number of pages
    $employees_per_page = 5;
    $total_pages = ceil($total_employees / $employees_per_page);

  // lay du lieu tu mýql
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($current_page - 1) * $employees_per_page;
    $sql = "SELECT * FROM employees LIMIT $start, $employees_per_page";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
    
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Ma_NV'] . "</td>";
            echo "<td>";
            echo "Tên Nhân Viên: " . $row['Ten_NV'] . "<br>" .
                 "Nơi Sinh: " . $row['Noi_Sinh'] . "<br>" .
                 "Tên Phòng: " . $row['Ten_Phong'] . "<br>" .
                 "Lương: " . $row['Luong'] . "<br>" . "<br>" .
                 "<img src='" . ($row['Phai'] === 'Nu' ? 'woman.jpg' : 'man.jpg') . "' alt='" . $row['Phai'] . "'>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No results found.</td></tr>";
    }


    $mysqli->close();
    ?>
  </table>


  <div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a href="?page=<?php echo $i; ?>" class="<?php if ($i == $current_page) echo 'active'; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
  </div>
</body>
</html>