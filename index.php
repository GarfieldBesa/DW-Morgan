<?php
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            $col1 = "";
            if (isset($column[0])) {
                $col1 = mysqli_real_escape_string($conn, $column[0]);
            }
            $col2 = "";
            if (isset($column[1])) {
                $col2 = mysqli_real_escape_string($conn, $column[1]);
            }
            $col3 = "";
            if (isset($column[2])) {
                $col3 = mysqli_real_escape_string($conn, $column[2]);
            }
            $col4 = "";
            if (isset($column[3])) {
                $col4 = mysqli_real_escape_string($conn, $column[3]);
            }
            $col5 = "";
            if (isset($column[4])) {
                $col5 = mysqli_real_escape_string($conn, $column[4]);
            }
			 $col6 = "";
            if (isset($column[5])) {
                $col6 = mysqli_real_escape_string($conn, $column[5]);
            }
             $col7 = "";
            if (isset($column[6])) {
                $col7 = mysqli_real_escape_string($conn, $column[6]);
            }
			$col8 = "";
            if (isset($column[7])) {
                $col8 = mysqli_real_escape_string($conn, $column[7]);
            }
            $sqlInsert = "INSERT into covid_observations (sno,observation_date,province,country,last_update,confirmed,deaths,recovered)
                   values (?,?,?,?,?,?,?,?)";
            $paramType = "isssssss";
            $paramArray = array(
                $col1,
                $col2,
                $col3,
                $col4,
                $col5,
				$col6,
				$col7,
				$col8
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
            
            if (! empty($insertId)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
<style>
body {
    font-family: Arial;
   
}

.outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
}

.input-row {
    margin-top: 0px;
    margin-bottom: 20px;
}

.btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
}

.outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
}

.outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}

.outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}

#response {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 2px;
    display: none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
<script type="text/javascript">

	

$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {

	    $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
        	    $("#response").addClass("error");
        	    $("#response").addClass("display-block");
            $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
            return false;
        }
        return true;
    });

	
});
</script>
</head>

<body>
    

    <div id="response"
        class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>">
        <?php if(!empty($message)) { echo $message; } ?>
        </div>
    <div class="outer-scontainer">
        <div class="row">

            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport"
                enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                    <button type="submit" id="submit" name="import"
                        class="btn-submit">Import</button>
                    <br />

                </div>

            </form>

		<br/>
		<form action="index.php" method="post">
			<input type="date" name="dateSearch"> <input type="text" name="length" required placeholder="Max Result"> <input type="submit" name="btn_submit">
		</form>
		
		
		
		<?php
		
			if(isset($_POST['btn_submit'])){
				$dateSearch = $_POST['dateSearch'];
				$Length = $_POST['length'];
				$orgDate = $dateSearch;  
				$newDate = date("m/d/Y", strtotime($orgDate));  
					
				echo "<br/><b>Observation Date:</b> ".$newDate."<br/>";
				$query = "SELECT *,SUM(confirmed) as Confirmed FROM covid_observations where observation_date = '01/22/2020' GROUP BY country ORDER BY confirmed DESC  LIMIT ".$Length."";
				$sqlSelect = $query;
				$result = $db->select($sqlSelect);
				
				
				foreach ((array) $result as $row) {
				echo "<br/>";
				echo "<b>Country: </b>".$row['country']."<br/>";
				echo "<b>Confirmed: </b>".$row['Confirmed']."<br/>";
				echo "<b>Deaths: </b>".$row['deaths']."<br/>";
				echo "<b>Recovered: </b>".$row['recovered']."<br/><br/>";
				}
				
			}
		?>
		
</body>

</html>