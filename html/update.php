<?php
include("connection.php");

$name = @$_POST["name"];
$description = @$_POST["description"];
$pharmacology = @$_POST["pharmacology"];
$chemistry = @$_POST["chemistry"];
$lowdose = @$_POST["lowdose"];
$mediumdose = @$_POST["middose"];
$highdose = @$_POST["highdose"];
$image = @$_POST["image"];
$physicaleffects = @$_POST["physicaleffects"];
$cognitiveeffects = @$_POST["cognitiveeffects"];

$sql = "SELECT SubstanceName FROM substances";
$result = $conn->query($sql);
$exists = false;
while($row = mysqli_fetch_array($result)) {
    if ($row["SubstanceName"] == $name){
        $exists = true;
    }
}

if (isset($name) && !$exists) {
    $sql = $conn->prepare("INSERT INTO substances (SubstanceName, SubstanceDescription, SubstancePharm,
SubstanceChemistry, LowDoseRange, MediumDoseRange, HighDoseRange, StructureImageName,
PhysicalEffects, CognitiveEffects) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssssssss", $name,
        $description,
        $pharmacology,
        $chemistry,
        $lowdose,
        $mediumdose,
        $highdose,
        $image,
        $physicaleffects,
        $cognitiveeffects);
    $sql->execute();

    include("admin.php");
    echo '<script type="text/javascript">',
    'alert("New substance added.");',
    '</script>';
} elseif (isset($name) && $exists) {
    $sql = $conn->prepare("UPDATE substances SET SubstanceName=?, SubstanceDescription=?,
SubstancePharm=?, SubstanceChemistry=?, LowDoseRange=?, MediumDoseRange=?, HighDoseRange=?,
StructureImageName=?, PhysicalEffects=?, CognitiveEffects=? WHERE SubstanceName='" . $name . "'");
    $sql->bind_param("ssssssssss", $name,
        $description,
        $pharmacology,
        $chemistry,
        $lowdose,
        $mediumdose,
        $highdose,
        $image,
        $physicaleffects,
        $cognitiveeffects);
    $sql->execute();
    include("admin.php");
    echo '<script type="text/javascript">',
    'alert("Substance modified.");',
    '</script>';
} elseif (!isset($name)) {
    include("admin.php");
    echo '<script type="text/javascript">',
    'alert("Please enter a substance name!");',
    '</script>';
}




?>