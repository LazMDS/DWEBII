<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
       header("location: ./Conectese.php");
        exit;
    }
    $user_id = $_SESSION['user_id'] ?? ''; // Obtém o ID do usuário logado
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XPenses - Despesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/despesas.css">
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
                <h2 class="text-center text-success">Despesas</h2>

                <a href="../gerar_pdf.php?id=1" target="_blank">Baixar PDF</a>

                <div class="d-flex justify-content-center mb-4">
                    <label for="monthSelect" class="me-2">Selecione o mês e ano:</label>
                    <input type="month" id="dateFilter" class="form-control" name="dateInput" required>

                </div>

                <form class="container">
                    <div class="row text-center mb-2">
                        <div class="col-4 fw-bold">Descrição</div>
                        <div class="col-4 fw-bold">Categoria</div>
                        <div class="col-2 fw-bold">Valor</div>
                        <div class="col-2"></div>
                    </div>
                    <!-- Expense Items -->
                    <div id="expenseItems">
                    </div>
                    <input type="hidden" id="user_id" value="<?= htmlspecialchars($user_id); ?>">
                    <div class="row mb-2">
                        <div class="add">
                            <button id="addExpenseBtn" class="btn">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAADOUlEQVR4nM2Xz0sUURzA37w3Kqw63++shm1Whrj7vjOCWtOPQ6lFhyCok4eELilIdAiULkVeNLKoLhHSRftxiLLAiJLq1KWUirL/KL5vp92d1Z2Z3Tr04AvDzHvv876/3wjx348+0WITjkqCGUvDgiJcZuFnfmd7OMJz/h0wn+22CG5Igg1J8CtBNiyCeV7TONAXzVLDFUn4PQWwSvAbW0EEoqk+6CCgIlyqHxgVpeGJoPaOdFBq75AEa38LrZB3wney8dBRYafVVGkYUxrPptbcF801uUWfJm60qQhX7IJ71Pbaj0jClyk1n96e2pfdnRRIiuC5yEMvz1UenFQajotCW6fw3H6p4W1SwAndsWsLN0yZuIVfGSI1XmatKzdUGs8IDfukxh9xe1gezFVpK1qS8tTScFP0u3sk4c9tvn8WQS5jabgVe3gN65EiE1akeB9p52LcPKXhhCS8lLSP7eFwOagIZhLBHl435txe43pkuuzfJBMVzfRJ9AAqzz0tCd43CrY0LFQEVsrcJVwRHuxnIwkfhiTBlCJ8lBRUETDhUt3gikh+xSYzHSnIZQR15jj4Uh5+uT5T15YNSXiVK1MauEV4t67gsghvS4LXMXOm2A0pDjpTTicPR5IWmOpEMB1zsDvCd/cm7WOzeyIFRMN67KICng8DarPWd6WdU+ZZ40fpwaRdcA6xSA8mzDtWgEtuVcmcTzjtGgeSJHecy2dUW7gv/B1tSsMzi+ChGOhqNZvmcZAPa54HulotgkVF+CLaqfLZ7vDmEN/e+MRBLsMViKsVFxXhYQ8DWasS1HQ7vCYJZ0uMga5WqfGDJOdcROtUFawob+yCe4xFEq6WzO/BZGS/arAwrXdCETyNNotANCkNj9NfBGAsEji+c5jNy7BQVkOZNQfwYcjWzkGp4YvYMnwny9eVRnLagE1K1QATBKImOISn1TwiDZu6cgSiqZi38QEXkaTgCjgruMG44yJxcB32YC4xz8uptViCcyoRHPgDtTQ8MI0m7uK3ZfAvjIfDbAWuyXwb5c5kabxX+oXJQy/nqUkZDRPsz9CnF/hdEZrZmR5azzAucs5xzhsraVhnnxrzVmj6G+7nTwwp6auVAAAAAElFTkSuQmCC">
                            </button>
                        </div>
                    </div>
                        <!-- Add more rows as needed -->
                    <div class="row mb-2">
                        <div class="col-4"></div>
                        <div class="col-4 text-end fw-bold ">Total:</div>
                        <div class="col-2"><input type="text" class="form-control tot" readonly></div>
                    </div>

                    
                </form>
                <!-- Chatbot Section -->
                <div class="chatbot">
                    <img src="./assents/Avatar.png" alt="Chatbot" class="chatbot-img">
                    <div class="chatbot-message">Oi, oi! Pronto para fazer algumas mudanças nos seus gastos?</div>
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
    <script src="./js/despesas.js"></script>
    <script src="./js/navbar.js"></script>

</body>
</html>