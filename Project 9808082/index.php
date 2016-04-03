<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Customer Form</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:500">
        <?php echo '<link rel="stylesheet" type="text/css" href="http://www.ccrscoring.co.nz/9808082/index.css?' . filemtime('index.css') . '" />'; ?>
        <?php echo '<script type="text/javascript" src="http://www.ccrscoring.co.nz/9808082/index.min.js?' . filemtime('index.min.js') . '"></script>'; ?>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    </head>
    <body>
        <header>
        </header>
        
        <main>
            <div id='passwordContainer'>
                <div id='selectRow'>
                    Branch: <select id='user'>
                        <option value='branch1'>branch1</option>
                        <option value='branch2'>branch2</option>
                        <option value='branch3'>branch3</option>
                        <option value='branch4'>branch4</option>
                        <option value='branch5'>branch5</option>
                        <option value='branch6'>branch6</option>
                        <option value='branch7'>branch7</option>
                        <option value='branch8'>branch8</option>
                        <option value='admin'>admin</option>
                    </select>
                </div>
                <br>
                <div id='passwordInputRow'>
                    Password: <input type='password' id='password'>
                </div>
                <br>
                <div id='passwordSubmitButtonRow'>
                    <button type='submit' onclick='checkPassword()'>Submit</button>
                </div>
            </div>
            
            <div id='formContainer'>
                <div id='nameInputRow'>
                    Name: <input type='text' id='name'>
                </div>
                <br>
                <div id='emailInputRow'>
                    Email: <input type='email' id='email'>
                </div>
                <br>
                <div id='postcodeInputRow'>
                    Postcode: <input type='text' id='postcode'>
                </div>
                <br>
                <div id='mensgearInputRow'>
                    Men's Gear: <input type='checkbox' id='mensgear'>
                </div>
                <br>
                <div id='womensgearInputRow'>
                    Women's Gear: <input type='checkbox' id='womensgear'>
                </div>
                <br>
                <div id='formSubmitButtonRow'>
                    <button type='submit' onclick='submitForm()'>Submit</button>
                </div>
            </div>
            
            <div id='adminContainer'>
                <button id='downloadButton' onclick='downloadUserInfo()'>Download All User Information</button>
            </div>
        </main>
        
        <footer>
        </footer>
    </body>
</html>