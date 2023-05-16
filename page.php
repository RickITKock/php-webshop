<h1>Hello, friend!</h1>

<form id=loginForm action="validations/login_validation.php" method="POST">
    <input 
        type='text' 
        name='email' 
        placeholder="email" 
        size='50' 
        class='form-control form-control-lg input-lg'
        value=<?php echo '"'.$_POST['email'].'"'; ?> />
    <br />
    <input 
        type='password' 
        name='password' 
        placeholder="password" 
        size='50' 
        class='form-control form-control-lg input-lg' 
        value='fuck' />
    <hr />
    <button type='submit' name='btn_login' class='btn btn-info btn-block btn-lg'>Submit</button>
</form>


<?php 
echo $_POST['email'].'<br />';
echo 'hello world!'; 
?>

<script>
let form = document.getElementById('loginForm');
form.submit();
</script>