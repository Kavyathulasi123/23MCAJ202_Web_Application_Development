<!DOCTYPE html>
<html>
<head>
    <title>Register Form</title>
    <script>
        function resetForm() {
            // Reset the form after successful submission
            document.getElementById("registrationForm").reset(); //the function resetForm() will reset the form by its id registration form and reset all the fields inside it
        }
    </script>
</head>
<style>
    .error {color: #FF0000;} /*.error is for styling the error msgs in red*/
    body{
        background-color:lightblue;
        font-size:30px;
    }
    h2{
        color:green;
        text-decoration:underline;
    }
</style>
<body>

<?php  //php part
//this initializes some variables for storing error messages and form data
$nameErr = $emailErr = $phonenumberErr = $genderErr = $countryErr = $passwordErr = $confirmpasswordErr = "";
$name = $email = $phonenumber = $gender = $country = $password = $confirmpassword = "";
//this checks if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {  //gets the method used to send the form in this case post means the form data is sent to server
    // Name Validation
    if (empty($_POST["name"])) {    //checks if the name is empty
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {   //if provided uses a regular expression preg_match to ensure the validation
            $nameErr = "Only letters and white space allowed";
        }
    }

    // Email Validation
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Phone Number Validation (10-digit number)
    if (empty($_POST["phonenumber"])) {
        $phonenumberErr = "Phone number is required";
    } else {
        $phonenumber = test_input($_POST["phonenumber"]);
        if (!preg_match('/^[0-9]{10}$/', $phonenumber)) {
            $phonenumberErr = "Invalid phone number (Must be 10 digits)";
        }
    }

    // Gender Validation
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    // Country Validation
    if (empty($_POST["country"])) {
        $countryErr = "Country is required";
    } else {
        $country = test_input($_POST["country"]);
    }

    // Password Validation (minimum 8 characters)
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters long.";
        }
    }

    // Confirm Password Validation
    if (empty($_POST["confirmpassword"])) {
        $confirmpasswordErr = "Confirm password is required";
    } else {
        $confirmpassword = test_input($_POST["confirmpassword"]);
        if ($confirmpassword !== $password) {
            $confirmpasswordErr = "Passwords do not match.";
        }
    }

    // If there are no errors, reset the form (we call resetForm() in JavaScript to reset the form)
    if (empty($nameErr) && empty($emailErr) && empty($phonenumberErr) && empty($genderErr) && empty($countryErr) && empty($passwordErr) && empty($confirmpasswordErr)) {
        echo "<h2>Successfully Registered:</h2>";
        echo "Name: " . $name . "<br>";                   //displays a success message then displays the data submitted by the user
        echo "Email: " . $email . "<br>";
        echo "Phone Number: " . $phonenumber . "<br>";
        echo "Gender: " . $gender . "<br>";
        echo "Country: " . $country . "<br>";

        // Call JavaScript function to reset the form after submission
        echo "<script>resetForm();</script>";
    }
}

// Function to sanitize input
function test_input($data) {
    $data = trim($data);  //removing extra spaces-trim
    $data = stripslashes($data);  //removing any backslashes
    $data = htmlspecialchars($data);  //converting special characters to prevent issues like script injection
    return $data;
}
?>

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field</span></p>
<!---html form--->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="registrationForm"> <!---action sends the form to the same page--->
  <!---name field--->
    Name: <input type="text" name="name" value="<?php echo $name;?>">
    <span class="error">* <?php echo $nameErr;?></span>
    <br><br>
<!---email field--->
    E-mail: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailErr;?></span>
    <br><br>
<!---phone number field--->
    Phone Number: <input type="tel" name="phonenumber" value="<?php echo $phonenumber;?>">
    <span class="error">* <?php echo $phonenumberErr;?></span>
    <br><br>
<!---gender field--->
    Gender:
    <input type="radio" name="gender" value="Female" <?php if($gender=="Female") echo "checked";?>> Female
    <input type="radio" name="gender" value="Male" <?php if($gender=="Male") echo "checked";?>> Male
    <input type="radio" name="gender" value="Other" <?php if($gender=="Other") echo "checked";?>> Other
    <span class="error">* <?php echo $genderErr;?></span>
    <br><br>
<!---country field--->
    Country:
    <select name="country">  <!---dropdown select is for selecting the country--->
        <option value="">Select a country</option>
        <option value="Australia" <?php if($country=="Australia") echo "selected";?>>Australia</option>
        <option value="India" <?php if($country=="India") echo "selected";?>>India</option>
        <option value="Canada" <?php if($country=="Canada") echo "selected";?>>Canada</option>
        <option value="USA" <?php if($country=="USA") echo "selected";?>>USA</option>
        <option value="UK" <?php if($country=="UK") echo "selected";?>>UK</option>
    </select>
    <span class="error">* <?php echo $countryErr;?></span>
    <br><br>
<!---password field--->
    Password: <input type="password" name="password">
    <span class="error">* <?php echo $passwordErr;?></span>
    <br><br>
<!---confirm password field--->
    Confirm Password: <input type="password" name="confirmpassword">
    <span class="error">* <?php echo $confirmpasswordErr;?></span>
    <br><br>
<!---submit button--->
    <input type="submit" name="submit" value="Submit">

</form>

</body>
</html>