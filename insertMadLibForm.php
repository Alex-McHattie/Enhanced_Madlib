<html>
<head>
<title>Lab 19 Mad Lib Insert Form</title>

<!--  I honor Parkland's core values by affirming that I have followed all academic integrity guidelines for this work.
Jmchattie1 
CSC155201F -->

<?php
// local functions

// ALEX MOVED SPECIAL CHARACTERS FUNCTION HERE LIKE IN HOUR 11 FORMS WHERE IT WORKED
//      HOWEVER, IT STILL DOESN'T KEEP RICK ROLL OUT IN THIS CODE,  NOR IN KEN'S HOUR 19 SCRIPT
/*
function getPost( $name )  #version 2
{
# check to see if it been used, if it has, return it
    if ( isset($_POST[$name]) )
    {
        return htmlspecialchars($_POST[$name]);
    }
    return "";
}
*/


function insertNewRecord($conn)
{
// ALEX QUESTIONS WHETHER TO ADD THIS GLOBAL FROM LAB 18
// global $critter, $verb, $friendName, $anyObject, $anotherFriend, $vegitable, $footware, $eyeHole, $shoeBrand, $shoeTongue, $furnitureLeg, $airplaneWing;

  
    // prepare and bind
    $stmt = $conn->prepare("INSERT INTO madLib (critter, verb, friendName, anyObject, anotherFriend, vegitable, footware, eyeHole, shoeBrand, shoeTongue, furnitureLeg, airplaneWing) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
    $stmt->bind_param("ssssssssssss", $critter, $verb, $friendName, $anyObject, $anotherFriend, $vegitable, $footware, $eyeHole, $shoeBrand, $shoeTongue, $furnitureLeg, $airplaneWing);


    // set parameters and execute

    $critter = getPost('critter');
    $verb = getPost('verb');
    $friendName = getPost('friendName');
    $anyObject = getPost('anyObject');
    $anotherFriend = getPost('anotherFriend');
    $vegitable = getPost('vegitable');
    $footware = getPost('footware');
    $eyeHole = getPost('eyeHole');
    $shoeBrand = getPost('shoeBrand');
    $shoeTongue = getPost('shoeTongue'); 
    $furnitureLeg = getPost('furnitureLeg');
    $airplaneWing = getPost('airplaneWing');

    $stmt->execute();
    header("Location: showMadLibData.php");
}


// FOR LAB 19 THIS IS THE HTMLSPCLCHAR AND getPost KEN WANTS.
// THIS IS ALSO WHERE KEN PUT IT IN HOUR 19 VIDEO. 
// Also Ken says this $name is local to getPost 38:50 (SO ALEX DOES NOT USE $row, CORRECT?)
// ALSO, FROM END OF KEN'S HOUR 19 LECTURE, SOUNDS LIKE HE WANTS THIS IN LAB 18 AS WELL (NOT SPECIFIED AT THAT TIME)

// THIS SPECIAL CHARACTERS FUNCTION DOES NOT STOP RICK ROLL DOWN HERE SO ALEX TRIED MOVING IT UP TO THE TOP. IT DOESN'T WORK THERE, EITHER.

function getPost( $name )  #version 2
{
# check to see if it been used, if it has, return it
    if ( isset($_POST[$name]) ) 
    {
        return htmlspecialchars($_POST[$name]);  # KENS ORIGINAL PER HOUR 11 FF
        // echo htmlspecialchar($_POST('name'));    # KENS APR 29 DM SUGGESTION -THIS PRODUCED A FATAL ERROR
        // echo htmlspecialchars($_POST[$name]);    # ALEX TRIED THIS AMALGAMATION OF THE 1ST 2.  RICK SHOWED UP.
    }
    return "";
}


// Create connection object
$user = "jmchattie1";
$conn = mysqli_connect("localhost",$user,$user,$user);

// Check connection
if (mysqli_connect_errno()) {
  echo "<b>Failed to connect to MySQL: " . mysqli_connect_error() . "</b>";
  // Ken suggests loading an error page here
} 

// NEW FROM HOUR 19 35:00 KEN SAYS MAKE INSERTED INFO STAY WITH A REQUIRED
$nameerror = "";

if (isset($_POST['submit']))
{
    if ($_POST['submit'] == "Insert New Record")
    {
        // if (!empty( $_POST['name'] )) 
        // name is required
        if (!empty( $_POST['critter'] ))     // ALEX SWITCHED THIS OUT FOR LAB 19 to critter required
        {
            insertNewRecord($conn);
        }
        else
        {
            $nameerror = "*Required";
        }
    }
    else if ($_POST['submit'] == "Cancel")
    {
        header("Location: showMadLibData.php");
    }
}

// ALEX PUT THIS IN LAB 18. THIS MAY -OR- MAY NOT BE APPROPRIATE FOR LAB 19:
/*
else
{
    global $critter, $verb, $friendName, $anyObject, $anotherFriend, $vegitable, $footware, $eyeHole, $shoeBrand, $shoeTongue, $furnitureLeg, $airplaneWing;
    $critter = "";
    $verb = "";
    $friendName = "";
    $anyObject = "";
    $anotherFriend = "";
    $vegitable = "";
    $footware = "";
    $eyeHole = "";
    $shoeBrand = "";
    $shoeTongue = "";
    $furnitureLeg = "";
    $airplaneWing = "";
}
*/

?>
</head>
<body>
<table align='center'>
<form method='POST'>

<!-- ALEX APPROPRIATES KEN'S FORM and MODIFIES IT FOR LAB19: -->

    <h2>A MadLib for a Literary Quote...</h2>
    <h3><i>please enter a word for each of the following categories:</i></h3>
    <tr>
<!-- ALEX NOTE: CHANGES FROM WHAT ALEX DID IN LAB 18 -->

    <!-- <td>Type of critter:</td><td><input type='text' name='critter' value='<?php echo $critter;?>'></td> -->
    <td>Type of critter:</td><td><input type='text' name='critter' > <?php echo $nameerror; ?> </td>
    </tr>
    <tr>
    <!-- <td>Action verb (past tense):</td><td><input type='text' name='verb' value='<?php echo $verb;?>'></td> -->
    <td>Action verb (past tense):</td><td><input type='text' name='verb' value='<?php echo getPost('verb'); ?>'> </td>
    </tr>   
    <tr>
    <td>Your best friend's name:</td><td><input type='text' name='friendName' value='<?php echo getPost('friendName'); ?>'> </td>
    </tr>
    <tr>
    <td>An object of any kind:</td><td><input type='text' name='anyObject' value='<?php echo getPost('anyObject'); ?>'> </td>
    </tr>
    <tr>
    <td>Another friend's name:</td><td><input type='text' name='anotherFriend' value='<?php echo getPost('anotherFriend'); ?>'> </td>
    </tr>
    <tr>
    <td>Vegitable (plural):</td><td><input type='text' name='vegitable' value='<?php echo getPost('vegitable'); ?>'> </td>
    </tr>
    <tr>
    <td>Type of footware (just the left one):</td><td><input type='text' name='footware' value='<?php echo getPost('footware'); ?>'> </td>
    </tr>
    <tr>
    <td>Object with a hole in it:</td><td><input type='text' name='eyeHole' value='<?php echo getPost('eyeHole'); ?>'> </td>
    </tr>
    <tr>
    <td>A brand of shoe:</td><td><input type='text' name='shoeBrand' value='<?php echo getPost('shoeBrand'); ?>'> </td>
    </tr>
    <tr>
    <td>A type of laced shoe (only the right one):</td><td><input type='text' name='shoeTongue' value='<?php echo getPost('shoeTongue'); ?>'> </td>
    </tr>
    <tr>
    <td>A type of furniture:</td><td><input type='text' name='furnitureLeg' value='<?php echo getPost('furnitureLeg'); ?>'> </td>
    </tr>
    <tr>
    <td>A type of airplane:</td><td><input type='text' name='airplaneWing' value='<?php echo getPost('airplaneWing'); ?>'> </td>
    </tr>

    <tr><td><input type='submit' name='submit' value='Insert New Record'>
    <input type='submit' name='submit' value='Cancel'> </td></tr>
</form>
</table>
</body>
</html>
