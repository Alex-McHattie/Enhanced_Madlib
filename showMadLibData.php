<html>
<head>
<title>Alex Lab 21 MadLib ShowData</title>
<style>
form {
    margin: 0;
    padding: 0;
}
</style>

<?php

$row = [];

// local functions

//lab 20-21 edit button function  17:50

function editbutton($id)
{
    // echo "EDIT";
    echo "<form method='POST' action='updateForm.php'>";
    // echo "<input type='text' name='id' value='" . $id . "'>";
    echo "<input type='hidden' name='id' value='" . $id . "'>";
    echo "<input type='submit' name='submit' value='Edit'>";
    echo "</form>";
}

function editLink($id)
{
    echo "<a href='updateForm.php?id=$id'>Edit</a>";   
}

function editImageLink($id)
{
    echo "<a href='updateForm.php?id=$id'>";
    echo "<img src='images/editicon.png' alt='Edit' width='25' height='25'>";
    echo "</a>";
}

function editImage($id)
{
    echo "<form method='POST' action='updateForm.php'>";
    echo "<input type='hidden' name='id' value='" . $id . "'>";
    echo "<input type='image' name='img_submit' src='images/editicon.png' alt='Edit' width='25' height='25'>";
    // echo "<input type='submit' name='submit' value='Edit'>";
    echo "</form>";
}

function deletebutton($id)
{
    echo "<form method='POST' action='deleteForm.php'>";
    echo "<input type='hidden' name='id' value='" . $id . "'>";
    echo "<input type='submit' name='submit' value='Delete'>";
    echo "</form>";
}

// Hour 22 slide 5  38:00  -this is JavaScript
// 41:00 NOTE: Ken broke up the open form tag into two lines, 
// and escaped the inner set of double quotes:
function deleteConfirmButton($id, $critter)
{
    echo "<form method='POST' action='deleteForm.php' ";
    $msg = "Delete record number $id? It is the Mad Lib story with $critter.";
    echo "onsubmit=\"return confirm('$msg');\">";
    echo "<input type='hidden' name='id' value='" . $id . "'>";
    echo "<input type='submit' name='submit' value='Delete'>";
    echo "</form>";
}

// print result as an html table 7:40
function printTable($result)
{
    $rowcount = 0;
    if ($result->num_rows > 0) 
    {
        global $row;
        echo "<table cellspacing='0' align='center'>";

        // header row
        echo "<tr>";
        echo "<th>" . "id" . "</th>";
        echo "<th>" . "Mad Lib Version" . "</th>";
        echo "</tr>";

        // output data of each row
        while($row = $result->fetch_assoc()) {
            $rowcount++;

            if ($rowcount % 2 == 0) // even 
                echo "<tr bgcolor='antiquewhite'>";
            else
                echo "<tr bgcolor='lightpink'>";

            // THIS PUTS THE ID NOS IN THE BOXES 
            //echo "<td>" . $row["id"] . "</td>"; 
            echo "<td style='vertical-align:top'>" . $row["id"] . "</td>";            

            echo "<td>" . madLibVersion($row) . "</td>";
            // echo "<td style='vertical-align:bottom'>" . madLibVersion($row) . "</td>";

            // data manipulation buttons

            // LAB 20-21 EDIT BUTTON CALL NEXT TO EACH ENTRY 7:10 16:40
            // is it possible to put these buttons at the top?
            // echo "<td style='vertical-align:top'>" . $row["id"] . "</td>";
            /*
            echo "<td>";
            editButton($row["id"]);
            echo "</td>";          
            */
            // echo "<td>";
            echo "<td style='vertical-align:top'>";
            editImage($row["id"]);
            echo "</td>";
            /*
            echo "<td>";
            editLink($row["id"]);
            echo "</td>";

            echo "<td>";
            editImageLink($row["id"]);
            echo "</td>";

            echo "<td>";
            deleteButton($row["id"]);
            echo "</td>";
            */
            // echo "<td>";
            echo "<td style='vertical-align:top'>";
            deleteConfirmButton($row["id"], $row["critter"]);
            echo "</td>";

            echo "</tr>";
        }

        echo "</table>";
    } 
    else 
    {
        echo "0 results";
    }

}

function getColumn($column)  # scrubs output
{
global $row;
return htmlspecialchars($row[$column]);  
}



function madLibVersion($row)
{
    $critter=getColumn("critter");
    $verb = getColumn("verb");
    $friendName = getColumn("friendName");
    $anyObject = getColumn("anyObject");
    $anotherFriend = getColumn("anotherFriend");
    $vegitable = getColumn("vegitable");
    $footware = getColumn("footware");
    $eyeHole = getColumn("eyeHole");
    $shoeBrand = getColumn("shoeBrand");
    $shoeTongue = getColumn("shoeTongue");
    $furnitureLeg = getColumn("furnitureLeg");
    $airplaneWing = getColumn("airplaneWing");



// echo "
return "    
<p>Thrice the brinded <b>" . $critter . "</b> hath mew'd.<br>
Thrice and once the hedge-pig <b>" . $verb . "</b>.<br>
<b>" . $friendName . "</b> cries 'Tis time, 'tis time.</p>

<p>Round about the cauldron go;<br>
In the poison'd <b>" . $anyObject . "</b> throw.<br>
Toad, that under cold stone<br>
Days and nights has thirty-one<br>
Swelter'd <b>" . $anotherFriend . "</b> sleeping got,<br>
Boil <b>" . $vegitable . "</b> first i' the charmed pot.</p>

<p>Double, double toil and trouble;<br>
Fire burn, and cauldron bubble!</p>

<p>Fillet of a fenny <b>" . $footware . "</b>,<br>
In the cauldron boil and bake;<br>
Eye of <b>" . $eyeHole . "</b> and toe of <b>" .  $shoeBrand . "</b>,<br>
Wool of bat and tongue of <b>" . $shoeTongue . "</b>,<br>
Adder's fork and blind-worm's sting,<br>
<b>" . $furnitureLeg . "</b>'s leg and <b>" . $airplaneWing . "</b>'s wing,<br>
For a charm of powerful trouble,<br>
Like a hell-broth boil and bubble.</p>

<p>Double, double toil and trouble;<br>
Fire burn and cauldron bubble!</p>
";

}

// Create connection object
$user = "jmchattie1";  
$conn = mysqli_connect("localhost",$user,$user,$user);

if (mysqli_connect_errno()) {
  echo "<b>Failed to connect to MySQL: " . mysqli_connect_error() . "</b>";
  // consider loaded an error page here
}

// FLAGGED HOUR 21 15:50  
// KEN CHANGED THIS TO INCLUDE deleted_on COLUMN THAT HE DIDN'T SUGGEST FOR MADLIB DATABASE.
// HERE IT IS CANCELLED OUT.  IT IS TO TAKE PLACE OF THE SIMPLER VERSION UNDERNEATH:
$sql = "SELECT * FROM madLib WHERE deleted_on is NULL;"; 
// $sql = "SELECT * FROM madLib";
$result = $conn->query($sql);

?>

</head>
<body>
<p><a href='insertMadLibForm.php'>Insert New Record</a></p>
<?php printTable($result); ?>
<!-- <?php printTable($result, $row); ?>  ALEX TRIED THIS. -NOT QUITE, AT LEAST NOT YET. -->
</body>
</html>
