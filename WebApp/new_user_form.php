<form method="POST">

  <div class="form-group">
    <label for="firstName">First Name:</label>
    <input type="text" name="firstName" id="firstName" value="<?php if(isset($first)) echo $first;?>"><br/>
  </div>

  <div class="form-group">
    <label for="lastName">Last Name:</label>
    <input type="text" name="lastName" id="lastName" value="<?php if(isset($last)) echo $last;?>"><br/>
  </div>

  <div class="form-group">
    <label for="email">Username:</label>
    <input type="text" name="email" id="email" value="<?php if(isset($email)) {echo $email;}?>"><br/>
  </div>

  <div class="form-group">
    <label for="pass1">Password:</label>
    <input type="password" name="pass1" id="pass1"><br/>
  </div>

  <div class="form-group">
    <label for="pass2">Confirm Password:</label>
    <input type="password" name="pass2" id="pass2"><br/>
  </div>

  <div class="form-group">
    <label for="check1">Accept Terms and Conditions:</label>
    <input type="checkbox" name="terms" id="check1" value="1"><br/>
  </div>



  <div class="form-group">
    <input type="submit" name="add" value="Submit">
    <input type="submit" name="cancel" value="Cancel">
  </div>
</form>
