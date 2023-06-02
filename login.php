
<?php 
session_start(); 
?>
<!-- начало сессии ( Spustí reláciu PHP. Je to potrebné na spracovanie premenných relácie, ktoré uchovávajú údaje medzi rôznymi požiadavkami.)-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page - Dashboard Admin Template</title>
    <!--
    Template 2108 Dashboard
	http://www.tooplate.com/view/2108-dashboard
    -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600">
    <!-- https://fonts.google.com/specimen/Open+Sans -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <!-- https://fontawesome.com/ -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- https://getbootstrap.com/ -->
    <link rel="stylesheet" href="assets/css/tooplate.css">
</head>
<?php
    if ($_POST['email']) //проверка на наличие каких-либо значений в 'email'
    {
        if ($_POST['password'] == $_POST['confirmPassword']) // проверка на соответсвие вводимого пороля 
        {
            $email = addslashes($_POST['email']); //добавляем слеш во избежании возникновения ошибок
            require_once ($_SERVER['DOCUMENT_ROOT'].'/assets/class/Database.php'); //берем данные с Database.php
            $mysqli = new Database(); // создаем объект класса Databasenum_rows
            $mysqli->getConnection(); // обращаемся к Database
           
            $sql = "Select * from user where email='$email'";  // создаем заброс, для обработки датабазой 
            $mysqli->runQuery($sql); // 
            if ($mysqli->num_rows) // если кол-во строк != 
            {
                $error= "This E-mail is already in use"; // значит E-mail уже используется
            }
            else
            {
                $sql = "INSERT into user (firstName,  middleName, lastName, mobile, email, passwordHash,registeredAt) values     (
                        '".addslashes($_POST['firstName'])."',
                        '".addslashes($_POST['middleName'])."',
                        '".addslashes($_POST['lastName'])."',
                        '".addslashes($_POST['mobile'])."',
                        '".addslashes($_POST['email'])."',
                        '".md5($_POST['password'])."',now())";
                $mysqli->runQuery($sql);
                unset($_GET['action']); // удаляем 'action'
          
            }
            

        }
        else 
        {
            $error= "Not equality password and confirm password";
        }
        
    }
    else 
    {
        session_destroy(); //разрушаем сессию
        unset($_SESSION); // чистим _SESSION
        // var_dump($_SESSION);
    }
    ?>
    <!--далле код для сооздания формы регистрации / подтверждения аккаунта-->
<body class="bg03">
    <div class="container">
        <div class="row tm-mt-big">
            <div class="col-12 mx-auto tm-login-col">
                <div class="bg-white tm-block">
                    <div class="row">
                        <div class="col-12 text-center">
                            <i class="fas fa-3x fa-tachometer-alt tm-site-icon text-center"></i>
                           <?= $_GET['action'] == 'new' ?  '<h2 class="tm-block-title mt-3">NEW USER</h2>' : '<h2 class="tm-block-title mt-3">Login</h2>' ?>
                           <?= $error ? "<h3 style='color:red;'>$error</h3>":'';?>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <form <?= $_GET['action'] == 'new' ? "" : 'action="index.php"' ?> method="post" class="tm-login-form"> 
                                <?php
                                if ($_GET['action'] == 'new') // задаем методу action значение = new и выполняем следующте действия
                                { ?>
                                <div class="input-group">   
                                    <label for="firstName" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">First  Name</label>
                                    <input name="firstName" type="text" class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" id="firstName" value="" required placeholder="First  Name">
                                </div> 
                                <div class="input-group mt-3">
                                    <label for="middleName" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Middle Name</label>
                                    <input name="middleName" type="text" class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" id="middleName" value="" placeholder="Middle Name" >
                                </div> 
                                <div class="input-group mt-3">
                                    <label for="lastName" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Last Name</label>
                                    <input name="lastName" type="text" class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" id="lastName" value="" required placeholder="Last Name">
                                </div> 
                                <div class="input-group mt-3">
                                    <label for="mobile" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">mobile</label>
                                    <input name="mobile" type="phone" class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" id="mobile" value="" required placeholder="mobile">
                                </div>
                                <?php } ?>
                                <div class="input-group mt-3">
                                    <label for="email" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">email</label>
                                    <input name="email" type="email" class="form-control validate col-xl-9 col-lg-8 col-md-8 col-sm-7" id="admin" value="<?= $_POST['email'] ? : "" ?>" required placeholder="email">
                                </div>
                                <div class="input-group mt-3">
                                    <label for="password" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Password</label>
                                    <input name="password" type="password" class="form-control validate" id="password" value="" required placeholder="password">
                                </div>
                                <?php
                                if ($_GET['action'] == 'new')  
                                { ?>
                                <div class="input-group mt-3">
                                    <label for="confirmPassword" class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-form-label">Confirm password</label>
                                    <input name="confirmPassword" type="password" class="form-control validate" id="confirmPassword" value="" required  placeholder="password">
                                </div>
                                <?php 
                                } 
                                ?>
                                <div class="input-group mt-3">
                                    <button type="submit" class="btn btn-primary d-inline-block mx-auto"><?= $_GET['action'] == 'new' ? 'Create' : 'Login' ?> </button> <!--тернальный if, отвечает за переключение 'Create' и 'Login'-->
                                </div>
                                <div class="input-group mt-3">
                                    <p>
                                    <?= $_GET['action'] == 'new' ? ' <a href="?">Return to login</a>' : ' <a href="?action=new">Create new account</a>' ?><!--тернальный if, отвечает за переключение Return to login и Create new account-->
                                   
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</body>

</html>