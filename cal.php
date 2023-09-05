

<?php



$balance=$_SESSION['balance'];
$sal=$_SESSION['salary'];
$saving=$sal-$balance;
$credit=$_SESSION['credit_score'];

function myFunction($sal,$saving,$credit) 
{
    if(($saving/$sal)*100>10)
    {
         $credit=$credit+20;

                    $email=$_SESSION['email'];
                    $host = 'localhost';
                    $dbUsername = 'root';
                    $dbPassword = '';
                    $dbName = 'coinbase';
                    $currentMonthYear = date('m-Y');
                    
                    


                    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "Update users set credit_score='$credit' where email='$email'";
                    $result = $conn->query($sql);
                   

                   


                    $conn->close();
    }
}


$currentDate = new DateTime();


$lastDayOfMonth = date('Y-m-t', strtotime('this month'));


if ($currentDate->format('Y-m-d') === $lastDayOfMonth && $currentDate->format('H:i') === '23:59') {
  
    myFunction($sal,$saving,$credit);
}

?>

