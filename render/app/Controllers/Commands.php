<?php

namespace App\Controllers;

use CodeIgniter\CLI\CLI;
use CodeIgniter\Controller;

class Commands extends Controller
{
    public function help_command()
    {
        $thead = [CLI::color('Controller', 'light_green'), CLI::color('Command', 'light_green'), CLI::color('Route', 'light_green'), CLI::color('Argument', 'light_green')];
        $tbody = [
            [CLI::color('Productos', 'light_yellow'),CLI::color('php', 'light_red').' index.php', 'getAllQuestions', ''],
            [CLI::color('Productos', 'light_yellow'),CLI::color('php', 'light_red').' index.php', 'getAllProductCli', 'id_client'],
            [CLI::color('Productos', 'light_yellow'),CLI::color('php', 'light_red').' index.php', 'updateStatusLikeName', 'like_name action id_excluided'],
        ];

        CLI::table($tbody, $thead);
    }
}
