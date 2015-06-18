<?php
    include'config.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta name="author" content="lolkittens" />

	<title>Untitled 1</title>
</head>

<body>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file" /><br />
    <input type="submit" value="Upload" />
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_FILES['file'])){
            $file = $_FILES['file'];
            
            //Properties
            $filename   = $file['name'];
            $filetmp    = $file['tmp_name'];
            $filesize   = $file['size'];
            $fileerror  = $file['error'];
            
            //What extension
            $file_ext = explode('.', $filename);
            $file_ext = strtolower(end($file_ext));
            
            $allowed = array('xls', 'xlsx', 'csv');
            
            if(in_array($file_ext, $allowed)){
                if($fileerror === 0){
                    
                    $filenamenew = $filename;
                    $filedestination = 'uploads/' . $filenamenew;
                    
                    if(move_uploaded_file($filetmp, $filedestination)){
                        echo $filedestination;
                        
                    $row = 1;
                    if (($handle = fopen("uploads/" . $filename, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $num = count($data);

                    $sql = "INSERT INTO team (vnaam, anaam, club) VALUES (:vnaam, :anaam, :club)";
                    $query  = $handler->prepare($sql);
            
                    try{
                        $query->execute(array(
                            ':vnaam'    => $data[0],
                            ':anaam'    => $data[1],
                            ':club'     => $data[2]
                        ));
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                    }
                        }
                        fclose($handle);
                    }
                    }
                }
            }
            else{
                echo'Dat bestand is niet toegestaan.';
            }
        }
    }
?>
</body>
</html>