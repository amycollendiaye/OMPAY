## une commande sur tinker qui permet de lister :

      amy-colle-ndiaye@amycollendiaye:~/Documents/lavarel/OMPAY$ php artisan tinker --execute="dd(Schema::getColumnListing('clients')); dd(Schema::getConnection()->getDoctrineSchemaManager()->listTableColumns('clients'));"

## Gerer AUTHENTIFICATION AVEC PASSPORT OAUTH2 ET LES POCLIES ET GATES

    composer require laravel/passport
    php artisan migrate
    php artisan passport:install

## Mettre à jour config/auth.php pour utiliser Client comme modèle d’utilisateur API :

    'providers' => [
    'users' => [
    'driver' => 'eloquent',
    'model' => App\Models\Client::class,
    ],
    ],

## utilise les Personal Access Tokens de Passport,

## 👉 Le refresh token n’existe que dans le flux OAuth2 “Password Grant Token”.

####  prompt
apres la connexion je veux gerer les permissions je veux le client connecte puisse listes ces transactions
faire transaction tranfert ou paiment tout en sachant le solde du clien nest pas stocke dans la base de donne sera gere par un le scope local qui va gerre la en initalisant dans chanque un un montants de 10000 pour le cas solde = 10000-(sommmes des transsactions payement +sommme destrantactions tranfersts) et a chaque type transaction sera iune requete de transaction son compte sera debite et le destinaire le montant de son solde augmente
pour le latransaction payement on aura beseion du montant et le numero de la basede donne ou un code marchand de la base dex gerer les permissions je veux le client connecte puisse listes ces transactions
faire transaction tranfert ou paiment tout en sachant le solde du clien nest pas stocke dans la base de donne sera gere par un le scope local qui va gerre la en initalisant dans chanque un un montants de 10000 pour le cas solde = 10000-(sommmes des transsactions payement +sommme destrantactions tranfersts) et a chaque type transaction sera iune requete de transaction son compte sera debite et le destinaire le montant de son solde augmente
pour le latransaction payement on aura beseion du montant et le numero de la basede donne ou un code marchand de la base de donnne
pour la tranasaction payement on a besion de numero telephoen existant et le montant
NB dans une transaction tjrs verifer si le montant client a que montant dans solde
dans mon modele cest un client a un compte de type client et le distributeur a compte de type distributeur ( seul le code du distributeur a un code marchand)
NB: tt en responsable le principe de single response donnne
pour la tranasaction payement on a besion de numero telephoen existant et le montant
NB dans une transaction tjrs verifer si le montant client a que montant dans solde
dans mon modele cest un client a un compte de type client et le distributeur a compte de type distributeur ( seul le code du distributeur a un code marchand)
NB: tt en responsable le principe de single response

## afficheer le client amy-colle-ndiaye@amycollendiaye:~/Documents/lavarel/OMPAY$ php artisan tinker --execute="dd(App\Models\Client::all()->toArray());"

    array:2 [
    0 => array:14 [
    "id" => "dfe46803-9ce0-4448-bfd2-53fd79f17ba5"
    "nom" => "Brandon Kilback"
    "prenom" => "Price"
    "cni" => "NEMTBZAQQO"
    "telephone" => "+1-734-208-2108"
    "adresse" => """
    9638 Osborne Knoll\n
    East Eva, ME 02932
    """
    "code_secret" => "1611"
    "email" => null
    "created_at" => "2025-11-10T22:22:50.000000Z"
    "updated_at" => "2025-11-10T22:22:56.000000Z"
    "qr_code" => "qrcodes/client_dfe46803-9ce0-4448-bfd2-53fd79f17ba5.png"
    "is_active" => false
    "password" => "$2y$12$Neb/eMbZpfsATYUgKWUmFec7JSCI78v.iarT3bxBpZNPnGX4m6osm"
    "must_change_password" => true
    ]
    1 => array:14 [
    "id" => "3b357ae1-96e6-4116-8315-9451ccfe8ad9"
    "nom" => "amy colle"
    "prenom" => "ndiaye"
    "cni" => "12347890123"
    "telephone" => "781030848"
    "adresse" => "colobane"
    "code_secret" => "1287"
    "email" => null
    "created_at" => "2025-11-10T22:30:10.000000Z"
    "updated_at" => "2025-11-10T22:30:20.000000Z"
    "qr_code" => "qrcodes/client_3b357ae1-96e6-4116-8315-9451ccfe8ad9.png"
    "is_active" => false
    "password" => "$2y$12$yCwuDDsQCFoH0MfGJd/eneHZFOiZL5ltcG0C5bjnolbiP6jJ3KyZ2"
    "must_change_password" => true
    ]

## $client->createToken('access_token', ['access'])

      createToken() est une fonction que Laravel Passport ajoute automatiquement à ton modèle Client
    (parce qu’il utilise le trait HasApiTokens).
    'access_token' → c’est le nom du token, juste pour toi, pour reconnaître son type (ici un token d’accès).

    ['access'] → ce sont les permissions que tu donnes à ce token.

    💬 Exemple :
    Tu peux créer des permissions comme :

    ['access'] → accès aux endpoints normaux (transactions, profil…)

    ['refresh'] → accès uniquement pour renouveler un token

## code marchand de teset:CM-HCKIKO"

## afficher le client amy colle 781030848

    php artisan tinker --execute="\$client = App\Models\Client::where('telephone', '781030848')->first(); if(\$client) { \$client->load('compte'); echo json_encode(\$client->toArray(), JSON_PRETTY_PRINT); } else { echo 'Client not found'; }"

## model transaction : php artisan tinker --execute="dd(App\Models\Transaction::all()->toArray());"

## les jobs

    pour mettent en place une job il faut d'abord crrer le job avec sa commande ensuite ancer le job avec le planificateur de taches via Kernel de app/console/kernel.php dans la methdole schedule
    use Illuminate\Support\Facades\Log;
    neon :npx neonctl@latest init
    ensuite demarrer le scheduler avec la commande : php artisan schedule:run

## la chaine de connexion de ma base de donne :

psql 'postgresql://neondb_owner:npg_w8HKd0SJAcjg@ep-spring-frost-ah5uux39-pooler.c-3.us-east-1.aws.neon.tech/neondb?sslmode=require&channel_binding=require'

## la structure de table transaction

    :php artisan tinker --execute="dd(Schema::getColumnListing('transactions'));" ou php artisan tinker --execute="dd(Schema::getColumns('transactions'));"

## La commande qui permet de tourne le planificateur laravel

p hp artisan schedule:work permet de faire tourner le planificateur Laravel (scheduler) en continu, sans passer par cron directement.

## tester immédiatement ton job (sans attendre l’heure planifiée), exécute :php artisan schedule:run

### les differents fadcons executer les jobs manuellement

## 1\* les execution immediate synchrone:

      le job s’exécute tout de suite dans le même processus : (new ArchiveOldTransactionJob())->handle();

## 2\* les excutions asynchrone via la queue:

      le job envoyer dans la queue et traite dans la worker: dispatch(new ArchiveOldTransaction());
      ou peu ausi utiliser les interface pour  executer:ArchiveOldTransaction::dispatch();

## 3\* planification automatique:

        protected function schedule(Schedule $schedule)
        {
        $schedule->job(new ArchiveOldTransactionJob)->dailyAt('08:45');
        }
        Et pour exécuter la planification :

        bash
        Copier le code
        php artisan schedule:wor

## les etapes a suivre pour execeuter un job par   commande:
php artisan make:command RunArchiveJob
 creeer la commande artisan   pour cela dans le dossier app 

