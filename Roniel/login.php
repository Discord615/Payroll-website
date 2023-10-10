<?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ? Place holders
    if (!loginLogic($email, $password)) {
        print('Wrong Email/Password');
    } else {
        print('Successful Login');
    }
}

function loginLogic($email, $password)
{
    $loginDataArray = checkEmail($email);
    if ($loginDataArray == false) return false;

    if (!checkPass($password, $loginDataArray[1])) return false;

    return true;
}

function checkPass($enteredPass, $pass)
{
    return $enteredPass == $pass;
}

function checkEmail($email)
{
    $filePath = ['employeeData.txt', 'employerData.txt'];

    for ($i = 0; $i < 2; $i++) {
        $data = fopen($filePath[$i], 'r');

        while (!feof($data)) {
            $result = fgets($data);

            $resultArray = explode(' ', $result);

            if ($resultArray[0] == $email) return $resultArray;
        }
    }

    return false;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav>
        <h1 id="businessName">EMPPAX</h1>
        <ul class="nav-link">
            <li><a href="main.php">Home</a></li>
            <!-- <li><a class="About" href="index.html">About</a></li> -->
            <li><a class="active" href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></a></li>
    </nav>
    <div id="formContainer">
        <h1>Login</h1>
        <form method="post">
            <input type="email" name="email" id="email" placeholder="Email Address">
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="submit" value="Login" name="submit">
        </form>
    </div>
    <script src="script.js"></script>
</body>

</html>