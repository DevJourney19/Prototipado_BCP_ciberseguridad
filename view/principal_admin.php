<head>
    <?php include '../view/fragmentos/head.php' ?>
    <style>
        .derecha {
            padding-top: 30px;
            color: white;
            font-weight: 600;
            padding: 20px 0px 40px 0px;
        }

        .derecha>span {
            font-size: 1.6rem;
            display: block;
            /* text-align: center; */
            text-align: left;
            margin-bottom: 16px;
            color: black;
        }

        .cuentas {
            border: 1px solid lightgray;
        }

        .cuenta_1 {
            background-color: white;
            height: 150px;

        }

        .cuenta_2 {
            border-radius: 0px;
            width: 100%;
            color: #3c3c3c;
            background-color: white;

        }

        .campania {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        @media (min-width: 768px) {
            .cuentas {
                display: flex;

                width: 100%;
            }

            .cuenta_1 {
                width: 100%;
                border-radius: 0%;
            }

            .cuenta_2 {
                height: 150px;
                width: 100%;
                border-radius: 0%;
            }

            .derecha {
                padding: 30px 0px;
            }

            .campania {

                flex-direction: row;
                gap: 10px;
            }
        }
    </style>
</head>

<body>
    <header>
        <link href="../view/css/admin.css" rel="stylesheet" />
        <?php include '../view/fragmentos/nav.php' ?>
    </header>

    <div class="cuadro_superior">
        <div class="izquierda">

            <div><span class="hola">Bienvenido, </span><span>Daniel</span></div>

            <div class="circulo">
                <img src="img/usuario.png" alt="Perfil Usuario">
            </div>
        </div>

    </div>
    <?php include '../view/fragmentos/nav_admin.php' ?>
    <div class="table-container">
        <div class="derecha">
            <span><i class="fa-solid fa-users"></i> Contactos</span>
            <div class="cuentas">
                <div class="cuenta_1">
                    <span>Total de contactos</span>
                    <span class="amount">6.200.103</span>

                </div>
                <div class="cuenta_2">
                    <span>Nuevos contactos a lo largo de 30 días</span>
                    <span class="amount">192.140</span>

                </div>
            </div>
        </div>
        <div class="header-row">
            <h2><i class="fa-solid fa-bullseye"></i> Campañas recientes</h2>
            <div class="campania">
                <a href="#" class="btn">Ver todo</a>
                <a href="#" class="btn">Crear una campaña</a>
            </div>
        </div>
        <div style="overflow-x: auto;padding: 50px 0px 100px 0px;">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Última modificación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ES_blog_newsletter_EN_2024 #4233</td>
                        <td><span class="badge badge-draft"><i class="fa-solid fa-pen-to-square"></i> Borrador</span>
                        </td>
                        <td>18 de ene. de 2024 10:50</td>
                    </tr>
                    <tr>
                        <td>DE_Blog_Newsletter_January_2024 #4227</td>
                        <td><span class="badge badge-sent"><i class="fa-solid fa-paper-plane"></i> Enviado</span></td>
                        <td>17 de ene. de 2024 7:00</td>
                    </tr>
                    <tr>
                        <td>EN_Pros_Newsletter_January_2024 #4168</td>
                        <td><span class="badge badge-sent"><i class="fa-solid fa-paper-plane"></i> Enviado</span></td>
                        <td>16 de ene. de 2024 18:58</td>
                    </tr>
                    <tr>
                        <td>test #4230</td>
                        <td><span class="badge badge-draft"><i class="fa-solid fa-pen-to-square"></i> Borrador</span>
                        </td>
                        <td>15 de ene. de 2024 10:34</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


</body>