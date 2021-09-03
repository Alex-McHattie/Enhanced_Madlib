<html>
<head>
<title>Lab 20-21 Mad Lib Delete Form</title>

<!--  I honor Parkland's core values by affirming that I have followed all academic integrity guidelines for this work.
Jmchattie1 
CSC155201F -->

<?php
// local functions MODIFIED HOUR 21 10:30

function deleteRecord($conn)
{
// ALEX QUESTIONS WHETHER TO ADD THIS GLOBAL FROM LAB 18
// global $critter, $verb, $friendName, $anyObject, $anotherFriend, $vegitable, $footware, $eyeHole, $shoeBrand, $shoeTongue, $furnitureLeg, $airplaneWing;

  
    // prepare and bind
    // $stmt = $conn->prepare("DELETE FROM madLib WHERE id=?");
    $stmt = $conn->prepare("UPDATE madLib SET deleted_on = NOW() WHERE id=?"); 
// FLAGGED FOR POSSIBLE NECESSARY FIX
    // Ken put   deleted_on   in his  sample   table, but never suggested we use it for the madLibs, so the above code does not work here 15:00  
    
    $stmt->bind_param("i", $id);


    // set parameters and execute  - id added Lab 20 37:50

    $id = getPost('id');

    $stmt->execute();
    header("Location: showMadLibData.php");
}


// FOR LAB 19 THIS IS THE HTMLSPCLCHAR AND getPost KEN WANTS.
// THIS IS ALSO WHERE KEN PUT IT IN HOUR 19 VIDEO. 
// THIS NEEDS MORE SCRUB CODE ON THE COLUMNS TO WORK -PROVIDED ELSEWHERE

function getPost( $name )  #version 2
{
# check to see if it been used, if it has, return it
    if ( isset($_POST[$name]) ) 
    {
        return htmlspecialchars($_POST[$name]);  # KENS ORIGINAL PER HOUR 11 FF
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
$id = getPost('id'); // added at Hour 20 for Lab 21 - same for block below:

$sql = "SELECT * FROM madLib WHERE id=?"; // SQL with parameters -Hour 20 slide 3
$stmt = $conn->prepare($sql); 
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
$row = $result->fetch_assoc(); // fetch the data 


// submit button handling - MODIFY FOR LAB 20-21 UPDATE FORM
if (isset($_POST['submit']))
{
    if ($_POST['submit'] == "Delete Record")
    {
        // echo 'update'; (DEBUGGING TOOL)
        deleteRecord($conn);
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

<input type='hidden' name='id' value='<?php echo $id;?>'>
<tr><td>ID: <?php echo $id; ?></td></tr>

    <h2>A MadLib for a Literary Quote...</h2>
    <h3><i>this is the record you are considering to delete:</i></h3>
    <tr>
<!-- ALEX NOTE: CHANGES FROM WHAT ALEX DID IN LAB 18 -->
    <!-- <td>Type of critter:</td><td><input type='text' name='critter' value='<?php echo $critter;?>'></td> -->
    <!-- <td>Type of critter:</td><td><input type='text' name='critter' > <?php echo $nameerror; ?> </td> -->
    <!-- <td>Type of critter:</td><td><input type='text' name='critter' value='<?php echo $row['critter']; ?>'> <?php echo $nameerror; ?> </td> -->
    <td>Type of critter: </td><td><?php echo $row['critter']; ?></td>
    </tr>
    <tr>
    <!-- <td>Action verb (past tense):</td><td><input type='text' name='verb' value='<?php echo $verb;?>'></td> -->
    <!-- <td>Action verb (past tense):</td><td><input type='text' name='verb' value='<?php echo getPost('verb'); ?>'> </td> -->
    <td>Action verb (past tense):</td><td><?php echo $row['verb']; ?></td>
<!-- THIS MODIFICATION FOR LAB 20-21 -->
    </tr>   
    <tr>
    <!-- <td>Your best friend's name:</td><td><input type='text' name='friendName' value='<?php echo getPost('friendName'); ?>'> </td> -->
    <td>Your best friend's name:</td><td><?php echo $row['friendName']; ?></td>
    </tr>
    <tr>
    <td>An object of any kind:</td><td><?php echo $row['anyObject']; ?></td>
    </tr>
    <tr>
    <td>Another friend's name:</td><td><?php echo $row['anotherFriend']; ?></td>
    </tr>
    <tr>
    <td>Vegitable (plural):</td><td><?php echo $row['vegitable']; ?></td>
    </tr>
    <tr>
    <td>Type of footware (just the left one):</td><td><?php echo $row['footware']; ?></td>
    </tr>
    <tr>
    <td>Object with a hole in it:</td><td><?php echo $row['eyeHole']; ?></td>
    </tr>
    <tr>
    <td>A brand of shoe:</td><td><?php echo $row['shoeBrand']; ?></td>
    </tr>
    <tr>
    <td>A type of laced shoe (only the right one):</td><td><?php echo $row['shoeTongue']; ?></td>
    </tr>
    <tr>
    <td>A type of furniture:</td><td><?php echo $row['furnitureLeg']; ?></td>
    </tr>
    <tr>
    <td>A type of airplane:</td><td><?php echo $row['airplaneWing']; ?></td>
    </tr>

    <tr><td>
    <input type='submit' name='submit' value='Delete Record'>
    <input type='submit' name='submit' value='Cancel'> 
    </td></tr>
</form>
</table>
</body>
</html>
