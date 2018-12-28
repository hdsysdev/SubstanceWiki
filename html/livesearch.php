<?php
include("connection.php");

$query = "SELECT * FROM substances";
$result = $conn->query($query);

while($row = $result->fetch_array())
{
    $a[]=$row["SubstanceName"];
}

/* free result set */
$result->free();

/* close connection */
$conn->close();

// get the q parameter from URL
$q = @$_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
        if (@stristr($q, @substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = "<a href=\"substance.php?substance=" . $name . "\" class=\"list-group-item list-group-item-action\">" . $name . "</a>";
//                $hint = $name;
            } else {
//                $hint .= ", $name";
                $hint = "<a href=\"substance.php?substance=" . $name . "\" class=\"list-group-item list-group-item-action\">" . $name . "</a>";
            }
        }
    }
}

if (isset($q))
{
    // Output "no suggestion" if no hint was found or output correct values
    if ($hint != "") {
        echo $hint;
    }
}
?>