<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <label>Surname:</label><br>
    <input type="text" name="surname" value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>"><br><br>
    
    <label>Email address:</label><br>
    <input type="text" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"><br><br>
    
    <input type="submit" value="Submit">
    <input type="reset" value="Reset">
</form>