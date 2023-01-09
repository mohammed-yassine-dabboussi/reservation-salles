
<?php
    session_start();
    include('includes/connect_db.php'); // connexion à la base de donnée
    include 'planning-form.php';
    $_SESSION["login"]=null; 
    $_SESSION["password"]=null; 
?>

<!DOCTYPE html>
<html lang="en">
    <?php include 'includes/header.php'; ?>
    
<body>
<?php include ('includes/nav.php')?>
    <main id="main_plan">
        <div id="planning_container">
            <h1 class="planning">Planning</h1>
            

    <!-- <table border="1">
        <thead>
            <?php 
                $semaine = array('lundi','mardi', 'mercredi', 'jeudi','vendredi', 'samedi', 'dimanche') ;
                $i = 0;
                $j = 8;
                $k = 9;
                echo "<tr>";
                echo "<th> Créneaux </th>";
                while ($i < 7) {
                    echo "<th>$semaine[$i]</th>";
                    $i++;
                } 
                echo "</tr>";
            ?>
        </thead>
        <tbody>
            <?php 
            while ($j<=19) {
                echo "<tr>";
                    echo "<td> ".$j."h"." "."à"." ".$k."h". "</td>";
                    echo "<td> résérver </td>";
                    echo "<td> résérver </td>";
                    echo "<td> résérver </td>";
                    echo "<td> résérver </td>";
                    echo "<td> résérver </td>";
                    echo "<td> résérver </td>";
                    echo "<td> résérver </td>";
                echo "</tr>";
            $j++;
            $k++;
            }
            
            ?>
        </tbody>
    </table> -->
    <form method="get" id ="calendar">
        <button type="submit" name="previous_week" id="previous_week"> <i class="fa fa-arrow-left icon"></i> </i> </button> 
        <button type="submit" name="reset" class="button" >Semaine en cours</button> 
        <button type="submit" name="next_week" id="next_week"> <i class="fa fa-arrow-right icon"></i></button>  
    </form>
    </div>
        <table>
            <thead>
                <tr>
                    <th>Créneaux</th>
                    <?php jours_planning() ?>
                </tr>
            </thead>
            <tbody>
                <?php corps_planning($result_events) ?>  
            </tbody>
        </table>
</main>
<?php include 'includes/footer.php'; ?>
</body>
</html>
