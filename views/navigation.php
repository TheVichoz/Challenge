<nav>
    <ul>
        <li><a href="register.php">Registro</a></li>
        <li><a href="login.php">Iniciar Sesión</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="logout.php">Cerrar Sesión</a></li> <!-- Solo para usuarios autenticados -->
    </ul>
</nav>

<style>
    nav ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        background-color: #007BFF;
    }

    nav ul li {
        margin: 0 15px;
    }

    nav ul li a {
        text-decoration: none;
        color: white;
        font-size: 16px;
    }

    nav ul li a:hover {
        text-decoration: underline;
    }
</style>
