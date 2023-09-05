<!DOCTYPE html>
<html>
<head>
    <title>Finance Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>

<header>
    <div class="logo">CoinCount</div>
    <nav>
      <ul class="nav-links">
      <li><a href="profile.php">Profile</a></li>
      <li><a href="dataviz.php">Viz</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="#testimonials">Testimonials</a></li>
        <li><a href="#faq">FAQ</a></li>
        <li>  <a href="logout.html">
          <span class="glyphicon glyphicon-log-out"></span>
        </a></li>
      </ul>
    </nav>
  </header>
  <br><br>
    <div class="container">
       
      <div class="transactions">

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">


      <input type="date" name="d" id="" placeholder="Date">
      <input type="submit" value="Filter">

      <br><br>
      </form>
            <table >
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                  



                <?php
                  $d=date('d-m-Y');
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    
                    $d = $_POST['d'];
                
                    
                   
                  }
                   session_start();
                   $email=$_SESSION['email'];

                    $host = 'localhost';
                    $dbUsername = 'root';
                    $dbPassword = '';
                    $dbName = 'coincount';

                    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    
                    $currentMonthYear = date('m-Y');
                    $monthYear = date('m-Y', strtotime($d));

                    $sql = "SELECT * FROM transactions where email='$email' and DATE_FORMAT(month, '%m-%Y')='$monthYear'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>$" . $row['amount'] . "</td>";
                            echo "<td><a href='update_amount.html?id=" . $row['id'] . "'><button class='c1'>Edit</button></a> <a href='delete_transaction.php?id=" . $row['id'] . "'><button class='c2'>Delete</button></a></td>";
                           
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No transactions found</td></tr>";
                    }

                    $conn->close();
                    ?>


                    
                </tbody>
            </table>

                </div>
            <div class="add-transaction">
                <h2>Add Transaction</h2>
                <br>
                <form id="transaction-form" action="add_transaction.php" method="POST">
                  
                    <input type="text" name="description" placeholder="Description" required><br><br>
                    <input type="number" name="amount" placeholder="Amount" step="0.01" required><br><br>
                    <input type="date" name="month" placeholder="Date" required><br><br>
                    
                    <input type="submit" value="Add">
                </form>
                <br>
            </div>


           
        <div class="total">
            
         
                <h2 class="p">Total Expense: </h2>
                <!-- <span> -->
                    
                    <?php
                   
                    $email=$_SESSION['email'];
                    $host = 'localhost';
                    $dbUsername = 'root';
                    $dbPassword = '';
                    $dbName = 'coincount';
                    $currentMonthYear = date('m-Y');
                    
                    


                    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT SUM(amount) AS balance FROM transactions where email='$email' and DATE_FORMAT(month, '%m-%Y')='$monthYear'";
                    $sql1 = "SELECT SUM(amount) AS bal FROM transactions where email='$email' and DATE_FORMAT(month, '%m-%Y')='$currentMonthYear'";
                    $result = $conn->query($sql);
                    $result1 = $conn->query($sql1);

                    $row = $result->fetch_assoc();
                    $row1 = $result1->fetch_assoc();
                    $balance = $row['balance'] ?? 0;
                    $bal = $row1['bal'];


                    echo '<h2 class="p">' . '$' . $balance.'</h2><br>';
                    $balance=$bal;

                    $conn->close();

                    $_SESSION['balance']=$balance;

                  
                    
                    ?>
                    
                    
    
           
           
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h2 class="p">Current Balance: </h2>
                
          

                    <?php
                   
                    $email=$_SESSION['email'];
                    $host = 'localhost';
                    $dbUsername = 'root';
                    $dbPassword = '';
                    $dbName = 'coincount';
                    $currentMonthYear = date('m-Y');
                    
                    


                    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT salary, credit_score  FROM users where email='$email'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $salary = $row['salary'] ;
                    $credit_score=$row['credit_score'];
                    $_SESSION['salary']=$salary;
                    $_SESSION['credit_score']=$credit_score;


                    echo '<h2 class="p">' . '$' . $salary-$balance.'</h2><br>';


                    $conn->close();

                   
                    ?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


                    
           <h2 class="p">Credit Score: </h2>
           <?php
           echo '<h2 class="p">' . '$' . $credit_score .'</h2><br>';

           ?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<h2 class="p">Salary: </h2>
           <?php
           echo '<h2 class="p">' . '$' . $salary .'</h2><br>';
           include('cal.php');

           ?>
                    
        </div>
    </div>
</body>
</html>


