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

function jsMessage($message){
    echo '<script type="text/javascript">',
    'alert("' . $message . '.");',
    '</script>';
}
function uploadFile(){
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    if(is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            jsMessage("File is not an image.");
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        jsMessage("File already exists.");
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        jsMessage("Sorry, your file is too large.");
        $uploadOk = 0;
    }
// Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        jsMessage("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1){
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            jsMessage("The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.");
        } else {
            jsMessage("Sorry, there was an error uploading your file.");
        }
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
    uploadFile();
    include("admin.php");
    jsMessage("New substance added");
    uploadFile();
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
    jsMessage("Substance modified");
    uploadFile();
} elseif (!isset($name)) {
    include("admin.php");
    jsMessage("Please enter a substance name.");
}




?>