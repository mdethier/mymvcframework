
<?php echo APPROOT; ?>
<br>
<?php echo URLROOT; ?>
<br>
<?php echo SITENAME; 

    foreach($data['users'] as $user) {
        echo "Information: " . $user->user_name . " => " . $user->user_email;
        echo "<br>";
    }
?>

