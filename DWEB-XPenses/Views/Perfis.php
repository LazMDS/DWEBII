<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("location: ./Conectese.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XPenses - Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/perfil.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="./assents/logo.png" alt="Logo" class="img-fluid me-2">
                <span class="text-white"></span>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="dropdown log">
                <a href="#" id="profileIcon" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img id="navProfileImage" src="../uploads/perfil.jpg" alt="Foto de Perfil" 
                        onerror="this.onerror=null; this.src='../uploads/default-profile.png';">
                </a>
                <a class="nav-link dropdown-toggle set" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                <ul class="dropdown-menu set" aria-labelledby="profileIcon">
                    <li><a class="dropdown-item" href="./Perfis.php">Perfil</a></li>
                    <li><a class="dropdown-item" href="../Controller/logout.php">Logout</a></li>
                </ul>
            </div>
            
        </div>
    </nav>
    <div class="collapse" id="navbarToggleExternalContent">
        <div class=" navbar p-4">
            <div class="d-flex align-items-center ">
                <button class="btn me-2 offset-md-3">
                    <div class="sidebar-item">
                        <a  href="https://icons8.com.br/icons/set/home"></a>
                        <a href="./menuInicial.php">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACK0lEQVR4nO2Xv2sUURDHNxIUwZ+FFtrYxUas7AQJIvgfaCVWqdNZbiW3M2cIV9paSQQJavaNBjmIEkgI2GhzRC4zCZEYLALhChN88jR3t9k79u7CZncP5gsDB3f35n3ezHf2reepesvUS9eIoerCffaGUbQO44ZhiwStC8PwiwTve8Mia+0IMTwhhv0mRATmjxEMfOuf8IqssFY5Rwyv4wAdwTj3jksXvSKK1ks3SWC1J0SrOsihlG8dWkO6/zY7CMZHxNDoF6JdGWi4/0bWmTQCvzMHCWuVUyRQGRigM17MyNTpf2tycJsENjMDeStTV4lhMQWI/60msNIc0eHm00tG4OOxg4QCd0jgR1oQkVbbJg7uuRxV64+6CecmXaajNUWYfZfD5XI5ieFBqhCz23DWCL46NoDOVntTrU9fSBWC6s+uk8C3rCCoCcNYm5PgRioQoZQfGobdrCGo3WoNw/j4yABNs+UGIPFWw+czX/2TA0G8Xy1fjo6/ooQR+PyB4UpfEN0eSIUKxp/hGtxNrgTDRLcrQtHCMO5FR3TbD1v+GSP4Mu8N0sABs/Pfg/MtEGJYPvhiZ4ggdg6qs9QCcSYyDF/MBozlv0Hsr702YMzdz0hwoatP8t4g9Rk9p1beGyQFiSnvkyatSEx5nzRpRWLK+6SpCBXpuXiWuUhBUCtC2loJUo+IesSqR5KkHhH1iFWPJEk9IuoRqx5JEgl+GoIXq4VBc6lU3tH0F/mtvcUpo0glAAAAAElFTkSuQmCC">
                        </a>
                    </div>
                    <span>Home</span>
                </button>
                <button class="btn me-2 offset-md-3">
                    <div class="sidebar-item">
                        <a  href="https://icons8.com/icon/59863/pie-chart"></a>
                        <a href="./graficos.php">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACsklEQVR4nO2Zv4vUUBDH409Qm7MRC2vPXgRRC/UvsPA8bLSzEHH/hBUONDPZYwtRsdLGJlbKmjepVlEbudLOk92ZXb1OkDu5EzwjbxM5vZMjeXnZZCVfmDJkPm/mvcz7xnFq1apVy6YU44xiWCGBJRJ8rQTuE8Nsh+8cdCYNhASjrQFrSvAp9d1TzmSDbIQSCNUQpktN9Pmn5v6w751Xfe+mYryrBB8HA/dkFhD6XSGGRhRFO8aW/MLCwz26zxVDoBPYssKMM9lBMHkWnvjvm3sLBWhGzZ0hwzXFyNsnYw5CMUxQGAz1WseI4V26RPKBUFIZ622m2LukGJfTJ5EfhGKYhjWIQOA6Ma5nS8AOCAmsvRi2juaGIMYriuFn9pW0BYKj/ZILIhDvBAl+N3u5PRASjMI+njaCCJe8AyTYM19FuyAk6BuBECPmawe7IEpwtdtrT2WC6PTwsH6wSiA0ai/3YsZqAORewQJAiPFeaohu1NydjNuVA1EMr9JXYwDn7Ly0iIrAMD0I41xVQRTDSmqQeJq1CxIM3CPxLTFfhFk2Owks2gYpRSTw9f8AYfhhZWMKzNtop+CPm2ZGEPxmB8RWwCMzEIHP5SePGy0q0DYCUQJvyk6e/gr3hmFF8EGlKjLwzpqBMMxWp61w1Zf5fUYg2sb8l71TUjxz8mhkY5YPEWUe2zdLn91lQyjBj3oSzwUSVwXCUqvB7tXcECOQIUyXtVeU4Furxpw2x8YOwbhs3ZXXq6Jty7GBsJ7z4IJThLSRbOuOsj0ErmtzvBCITTAFVkb/uYLLzjiUtFnD9gGgGD+E3DrujFvaULbSavq6wDhnPILYUvLR9DMbeQxDErwdLnqHnCqp22tP6VFCm2fE+FJ7YqMjNHbwv+jWIYGOYrgVsHvGj/xdZedcq1YtZzL1C6l74gTZaIsIAAAAAElFTkSuQmCC">
                        </a>
                    </div>
                    <span>Graficos</span>
                </button>
                <button class="btn me-2 offset-md-3">
                    <div class="sidebar-item">
                        <a  href="https://icons8.com/icon/45GtkgL2dWIo/service-tips"></a>
                        <a href="./despesas.php">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEfklEQVR4nO1ZXYgcRRBef1F8FCJGo6hBEFFQ44uKiL8gUZ99MD4p/iSIJioRwiZIzqmaTcDACacg+BJlTRBz3lTPrpoHH/zhYjQGVEhyU7WbRII/IAl4/o3U7MzdZJ2evbud3UvIFDQs219X9zf109XdlUoppZRSiorXci4nhh2G8a0Gw9KKRXzG+0lw3Ai87h9wl1hxB9wliiGBXTrGhmswLNU5de5x2XJZpV8xjKNGMIzbr4ZxVbq/edi5IiI6iwlJ4Dcjzup6WD8nwelv/a/Tl8Iy7FAdXXOuiuZKcIyj/RMRrKcnjicnP3CvIobnDOPv3f2zOPzGY+eOBsMKYvzShjOMJ4hh40eH3CuJ8YMMTH0gRGIy/1oX1oWbD9Zk9w2OyJBbvSSSSGkRKV0rLGMkT86MGGH8Ie7vvzH8uEhE4OvdYfXcSkGiuohh7/CJMG6vFCzE8O5iWOQPw/i0z7VbimiqywhOlzt7LzkzspYU20gr5a7zymlCBAJi2KYnRT2JTk6Onadz1vdXzzft2jITwEoSHNMT5SlJhBjZZ3iyGlbP7nuBBaTfYxTAzbZxddlyITHWMsahfnHFKBE/cO/WL24E9xiBI5q5SPCwYfjKMIAf4O1hGJ41MCIk8E6vsRRsvTQ1Ztpn5/EZveo2DN/NMXa+8MW9czBEGFkXmkuE8YUEn5DQOOj4/fwTgRHcvGB3zIsREviTBA9a2k9pd0qRaOQs1psQ5wbD+LmVFOP2Bblav8GupJKY6GUJEny2Y0nY2CNZbFoEIvBopCeAlTlf+Rixs16vgxTb5NeuNoJrSOB7m5vpFVMhRNStfIbnifHeVHtE77JmcRCoT+vlnC2wNdZsN5i7p6oXkMAnlnGfFkQE38vCU8u9K/Xltul/nRSbbzFvqnZTZy5oGsadXgsejPQJvGh3Mef6volons/KIKaFT8xinPs6OqJ9InMxiTVIYLJL/9+G0RDD8Zzk8Er/ROIr0eiiWXAsCmTGnepyM5h2bVmsY4+VyJRzXUQk+6o0zA968AohktsY/0lqJyNw1O5auEEx/lH3IgrgMS1d9E6ZGN/WO+H8OeDbgRPRKjalw3Zgig5oxPBw9twjy0ngUA6R9uAtIjg9o4Oh3Zs4Ngzjq4bhZSO4bqJdu1bHajbMca29wyASfnxw8yXxYuxPCjlfO4x3cGL82UJ+fChESJwHOhZBzMF9mLXxEcMvyUORPcZg7ZCI4NZIR+DcZsHsTzY+T+AZEngjzn6jOkb7PHFvtc8xsrxvInN5vNFzhWYudREtxbOrA/ch29zN9sjFJ1cKJ1tyziRsRNQ3O09vzvq8Dcsw7ks2PD1PWMkzThDDUx7jNYrVvYUEX7K5FDH+lew/A38M1b2g+yZSzxP5VnRWK06r2x7WXlOZr+jTMAm+Twxv9n6ehl1ajiTZqlu0pNHzRM4CP/MCuEc3OjumgIuIIqQTL7hprg+kJuVOC7LEoCV6sraU6Ob/Vmh6LbyxciqLluJaxWrAG8Z9hrGlO3bspmuTBFBK5TST/wA/rXYxUwTGWwAAAABJRU5ErkJggg==">
                        </a>
                    </div>
                    <span>Despesas</span>
                </button>
                <button class="btn me-2 offset-md-3">
                    <div class="sidebar-item">
                        <a  href="https://icons8.com/icon/45GtkgL2dWIo/service-tips"></a>
                        <a href="./categoria.php">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAA5UlEQVR4nO2YTQrCMBCF5xrqPa3ewAzoZVxkcNt6DzO36KoSERFsSxaBSeL74O3fY34ShggAAAAAv3jluyhPJcurG2iNq5531iYlUbfgtotBfDgdrQ1KqgIfZivxDjGaG9RkjTHMpzI1zISkzIy1iVwiawMIoqgIm7ePYEb0aysYIbkr0kwQKVxkbQBBFBVh8/YRzIg2uH6plSBSuMjaAIIoKsLm7SN/MSNe3WBtIoP6166ORy4JrqvtQOeV97On03i5K8DglKTgusVX1D8uG3ODmqbodfVLUMnM9Bl+PwAAAEB7PAGKVYvmob//OQAAAABJRU5ErkJggg==">
                        </a>
                    </div>
                    <span>Categorias</span>
                </button>
                <button class="btn offset-md-3">
                    <div class="sidebar-item">
                        <a  href="https://icons8.com/icon/45GtkgL2dWIo/service-tips"></a>
                        <a href="./saldo.php">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACBUlEQVR4nO2ZT0sbQRTAxx5qoQi9e/ADeBAs7clSEb9DT34J/QA5FE3eW23poZ/AWy4KSt4L+IdSKmKvnjxo3tNooSAUerCHdsvEGCV24+6auLPp/GAgs5mdnd/OezPJrjEejycRrBjmoZj/RqSbbB+9f0YCu7bYzyaPlPcLj1lx4+oOksCn7aPCE5MnwjAcYIHlf4REuRAWHpm8QIrvIuNb8KPJA6wwd1eikuCscRkWeMOCv+8WgT9UgxnjIhWF16xwkWAJ/UWC08YlSEqjrHiefD+AH3xcHDMusKZLwyQoaTc2UqyvHwYjLqxQX++9UwvsZe1hSGGzCz85NrL28Hg8/QIpfunBH6PPrf4FdllgJ249NT2QaJT2/uPWU9O1jiL68yJJ8TPiamhxvyQ7exH0M2LxodVO/NyAVarBePUseFrR4AUrrOcu2UlwxT5dvH1utIyTIlVZfN5su0ACP1lx/rJeepkLEVJco+Ng8mo27LOqZphd2Hrl4MOg+yKCb2+GEwm8uvl9RUoT7cecEyHBrdarAwFghdOkG2ZPRcoxB2bDybYnxVJSgbQifB3OdXtdO9ZIkbgDs0tss339oUW4JQTFSJG4IbL6HYaaIt+yEmGF004zEusOV2vBVOMijTDMSETgpIMIFNMOLIOyECliE8jK3Cf2e14ETqxEx2T3eDz9y1+bGS2Je4Ze0gAAAABJRU5ErkJggg==">
                        </a>
                    </div>
                    <span>Limites</span>
                </button>
            </div>
        </div>
    </div>

    <div class="container-fluid analise d-flex flex-column min-vh-100">
        <div class="row flex-grow-1">

            <!-- Main Content -->
            <div class="bloco col-lg-10 p-4">
                <h2 class="text-center text-success">Perfil</h2>


                <div class="text-center mb-4">
                    <!-- Imagem do perfil -->
                    <img id="profileImage" src="../uploads/perfil.jpg" alt="Foto de Perfil" width="150">

                    <!-- Botão para selecionar uma nova imagem -->
                    <button id="profilePictureButton" class="btn btn-sm pict" type="button">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAABR0lEQVR4nO2WIU/DUBSF77stwWy7hxEUYoit7z4MAoFAYDE4HBkSS4JG14BADIJAYTD8ArKQEBLEIFn4R+QtQDrWkhZKMb3JMS9pvrxzz2lLVE9Vwyqv/yGqwVxbrcWDY6wM2KFvnJxXFi5jZZBsTRacSt+pQ3+6rtgvAMYosNhhKw+/vrHKRU4wRmG0sOmfCaLW9o/s9vb6HWdAeRaMl1CxRQ4do7iiLs0bxelfVIxmbmplhRXD9/Mj0uYiK26NyhmrHBjFSYlgpEH9+Zh6WJssa7XVDl1zg9ZpzliJSwAjA/oJv2eLu0R4Yg9nh+PAys2HWOWxEDj8FpqZ3Ng3Zeoz120sGZXL3GBy6BSBpgtjdjicOGGxx4rnPFYPy0pqoHJNvfYyRQ31rUiuIvii8t9cVp4CK7v1Hwin97h6UQ3mqqyuhyqaN02buAA4Aq3uAAAAAElFTkSuQmCC">
                    </button>

                    <!-- Input de arquivo escondido -->
                    <input type="file" id="profilePictureInput" style="display: none;">
                </div>


                

                <h3 class="text-center mb-4">Olá!</h3>
            
                <div class="mb-3 position-relative">
                    <label for="nome" class="form-label">Nome:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="userName" value="" placeholder="Carregando..." disabled>
                        <button class="btn btn-outline-success btn-sm" id="editNameBtn" type="button">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TsQrCQAwG4DS9TWhyRRAXN720g5ObSN9GUPEFfAFfQQcHR3HwNYp18Y0kR0EEl/YQHPrDwZHhIzlyAH+VPEkjR/tY+ATjNAuyTMYLFCpR6KknEjoEYbGjM+R2hMJXjzreBXTGFWZ25Qu5olTCdNBrj9VjovBaO9V6c2xi5yh8f2MefBjhosO+p3uzAprGuGT2ubR+z6pWS6vRz43CGxS+BWMg/WEkfNRrjQZgoAgtY+GLotqpjt8a86DjraLaaRD0i7wApBRYfVdhW3EAAAAASUVORK5CYII=" alt="Editar" style="width: 16px; height: 16px;">
                        </button>
                        <button class="btn btn-primary d-none" id="saveNameBtn">
                            <i class="fas fa-save"></i>
                        </button>
                    </div>
                    
                </div>

                <div class="mb-3 position-relative">
                    <label for="email" class="form-label">E-mail:</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="userEmail" value="" placeholder="Carregando..." disabled>
                        <button class="btn btn-outline-success btn-sm" type="button" id="editEmailBtn">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TsQrCQAwG4DS9TWhyRRAXN720g5ObSN9GUPEFfAFfQQcHR3HwNYp18Y0kR0EEl/YQHPrDwZHhIzlyAH+VPEkjR/tY+ATjNAuyTMYLFCpR6KknEjoEYbGjM+R2hMJXjzreBXTGFWZ25Qu5olTCdNBrj9VjovBaO9V6c2xi5yh8f2MefBjhosO+p3uzAprGuGT2ubR+z6pWS6vRz43CGxS+BWMg/WEkfNRrjQZgoAgtY+GLotqpjt8a86DjraLaaRD0i7wApBRYfVdhW3EAAAAASUVORK5CYII=" alt="Editar" style="width: 16px; height: 16px;">
                        </button>
                        <button class="btn btn-primary d-none" id="saveEmailBtn">
                            <i class="fas fa-save"></i>
                        </button>
                    </div>
                </div>
        
                <div class="mb-3 edit-pas">
                    <label for="editSenhaBtn">Deseja mudar a senha?</label>
                    <button class="btn btn-success w-50" id="editSenhaBtn">Editar Senha</button>
                </div>
            
                <div id="senhaSection" class="d-none">
                    <div class="mb-3">
                        <label for="senhaAntiga" class="form-label">Senha Antiga:</label>
                        <input type="password" class="form-control" id="senhaAntiga">
                    </div>
                    <div class="mb-3">
                        <label for="senhaNova" class="form-label">Senha Nova:</label>
                        <input type="password" class="form-control" id="senhaNova">
                    </div>
                    <div class="mb-3">
                        <label for="confirmarSenha" class="form-label">Confirmar Nova Senha:</label>
                        <input type="password" class="form-control" id="confirmarSenha">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success" id="salvarSenhaBtn">Salvar</button>
                    </div>
                </div>
                
                <div class="chatbot">
                    <img src="./assents/Avatar.png" alt="Chatbot" class="chatbot-img">
                    <div class="chatbot-message">Olá! Pronto para editar seu perfil?</div>
                </div>
            </div>


        </div>
    </div>

    <footer class="text-center py-3">
        <div class="container">
            <a href="#" class="text-center mx-2">Contato</a>
            <a href="#" class="text-center mx-2">Sobre nós</a>
            <a href="#" class="text-center mx-2">Ajuda</a>
            <a href="#" class="text-center mx-2">Privacidade</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/Perfil.js"></script>

</body>
</html>