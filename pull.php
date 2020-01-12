<?php

shell_exec('git pull http://websyncbot:WAK2tRsB5jMzredQJ9uYxqyZwQUM6eYWTP74RJPM4rVvrCapLjf4F5SVHrqNkY4X@lusitania.badblock.fr/Website/managerV2.git');
shell_exec('php artisan view:clear');
shell_exec('php artisan cache:clear');

?>