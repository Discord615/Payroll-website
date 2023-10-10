<?php
if (isset($_POST['submit'])) {
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $email = $_POST['Email'];
    $pass = $_POST['Password'];
    $rePass = $_POST['RePassword'];
    $accessLevel = $_POST['accessLevel'];

    echo (registerMain($accessLevel, $email, $pass, $rePass, $firstName, $lastName));
    // TODO: fix output
    // echo ("Error: Email Already Exists/Failed to register successfully");
}

function registerMain($accessLevel, $email, $pass, $rePass, $firstName, $lastName)
{

    if (doesEmailExist($email)) return 'Email already exists';
    if (!confirmPassword($pass, $rePass)) return 'Password does not match';

    switch ($accessLevel) {
        case 'Employee':
            registerEmployee($email, $pass, $firstName, $lastName);


        case 'Employer':
            registerEmployer($email, $pass, $firstName, $lastName);
    }

    header('Location: register.php');
}

function registerEmployee($email, $pass, $firstName, $lastName)
{
    $isSuccess = false;
    $format = "$email $pass $firstName $lastName\n";
    $formattedString = sprintf($format, $email, $pass, $firstName, $lastName);

    if (doesEmailExist($email)) return $isSuccess;

    $empDataFile = fopen('employeeData.txt', 'a');
    if (fwrite($empDataFile, $formattedString) != false) $isSuccess = true;
    fclose($empDataFile);
    return $isSuccess;
}

function registerEmployer($email, $pass, $firstName, $lastName)
{
    $isSuccess = false;
    $format = "$email $pass $firstName $lastName\n";
    $formattedString = sprintf($format, $email, $pass, $firstName, $lastName);

    if (doesEmailExist($email)) return $isSuccess;

    $empDataFile = fopen('employerData.txt', 'a');
    if (fwrite($empDataFile, $formattedString) != false) $isSuccess = true;
    fclose($empDataFile);
}

function doesEmailExist($email)
{
    $FilePath = ['employeeData.txt', 'employerData.txt'];

    for ($i = 0; $i < 2; $i++) {
        $empDataFile = fopen($FilePath[$i], 'r');

        while (!feof($empDataFile)) {

            $result = fgets($empDataFile);

            $splitString = explode(" ", $result);

            if ($splitString[0] == $email) {
                return true;
            }
        }

        fclose($empDataFile);
    }

    return false;
}

function confirmPassword($pass, $rePass)
{
    if ($pass == $rePass) return true;
    return false;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payroll System</title>
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
            <li><a href="login.php">Login</a></li>
            <li><a class="active" href="register.php">Register</a></a></li>
    </nav>
    <div id="formContainer">
        <form method="post">
            <h1>REGISTER</h1>
            <label for="FirstName">First Name</label>
            <input type="text" name="FirstName" id="FirstName" placeholder="your name...">

            <Name for="LastName">Last Name</label>
                <input type="text" name="LastName" id="LastName" placeholder="your last name...">

                <label for="Email">Email Address</label>
                <input type="email" name="Email" id="Email" placeholder="your email...">

                <label for="pass">Password</label>
                <input type="password" name="Password" id="pass" placeholder="enter password">

                <label for="rePass">Confirm Password</label>
                <input type="password" name="RePassword" id="rePass" placeholder="re-enter password">

                <div>
                    <label for="accessLevel" style="float: left;">Employer</label>
                    <input type="radio" name="accessLevel" id="accessLevel" value="Employer" style="float: left;">

                    <label for="accessLevel" style="float: right;">Employee</label>
                    <input type="radio" name="accessLevel" id="accessLevel" value="Employee" style="float: right;">
                </div>

                <input type="submit" value="Register" name="submit">
        </form>
    </div>
</body>

</html>