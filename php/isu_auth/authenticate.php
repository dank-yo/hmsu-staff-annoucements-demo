<?php 
require('../../config.php');

if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $clientIP = $_SERVER['REMOTE_ADDR'];
}

function generateSQLid(){
    global $dbserv; global $dbname; global $dbuser; global $dbpass;
    $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    //This checks the last ID used in the database and increments it by 1.
    $sql = "SELECT id FROM hmsu_sa_users ORDER BY ID DESC LIMIT 1";
  
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
  
    $conn = null;
  
    //Newly generated SQL database ID, which is the primary key.
    return (intval($result[0]['id'] + 1));
}

echo "Client IP Address: " . $clientIP . '<br>';
$randomNumber = rand(1000, 10000);

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Prepare and execute a query
try {
    $existingUser = true;
    $randomNumber = 0;

    while ($existingUser) {
        $randomNumber = rand(1000, 10000);
        $query = "SELECT * FROM hmsu_sa_users WHERE portal_id = 'guest" . $randomNumber . "'";
        $statement = $pdo->prepare($query);
        $statement->execute();

        // Fetch the results
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) {
            $existingUser = false;
        }
    }

    $sqlID = generateSQLid();
    $_SESSION['firstname'] = 'Guest';
    $_SESSION['lastname'] = 'User';
    $_SESSION['user'] = 'guest' . $randomNumber;
    $_SESSION['role'] = 'user';
    $active = 1;
    $_SESSION['groups'] = 'GST.';
    $_SESSION['logged_in'] = true;

    $_SESSION['firstlast'] = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
    $_SESSION['lastlogin'] = date('Y-m-d h:i A');

    $data = [
        'id' => $sqlID,
        'firstname' => $_SESSION['firstname'],
        'lastname' => $_SESSION['lastname'],
        'portal_id' => $_SESSION['user'],
        'role' => $_SESSION['role'],
        'active' => $active,
        'groups' => $_SESSION['groups'],
        'lastlogin' => $_SESSION['lastlogin'],
        'ip' => $clientIP
    ];

    // Insert the guest user
    $sql = "INSERT INTO hmsu_sa_users (id, firstname, lastname, portal_id, role, isActive, groups, lastlogin, ip)
          VALUES (:id, :firstname, :lastname, :portal_id, :role, :active, :groups, :lastlogin, :ip)";

    $statement = $pdo->prepare($sql);
    $statement->execute($data);

    echo $_SESSION['user'] . " inserted successfully!";

} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

// Close the connection
$pdo = null;

$_SESSION['query_col'] = 0;
$_SESSION['query_range'] = 10;
$_SESSION['page_no'] = 1;
$_SESSION['success'] = "You are now logged in as: " . $_SESSION['firstlast'];
header("Location: ../../");
?>
