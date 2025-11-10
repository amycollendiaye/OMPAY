## une commande  sur tinker qui permet de lister :

amy-colle-ndiaye@amycollendiaye:~/Documents/lavarel/OMPAY$ php artisan tinker --execute="dd(Schema::getColumnListing('clients')); dd(Schema::getConnection()->getDoctrineSchemaManager()->listTableColumns('clients'));"