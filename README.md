## une commande  sur tinker qui permet de lister :

amy-colle-ndiaye@amycollendiaye:~/Documents/lavarel/OMPAY$ php artisan tinker --execute="dd(Schema::getColumnListing('clients')); dd(Schema::getConnection()->getDoctrineSchemaManager()->listTableColumns('clients'));"
 ## Gerer AUTHENTIFICATION AVEC PASSPORT OAUTH2 ET  LES POCLIES ET GATES 
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
et ce type de token ne génère pas de refresh_token.
## 👉 Le refresh token n’existe que dans le flux OAuth2 “Password Grant Token”.


####  prompt
apres la connexion  je veux  gerer les permissions je veux le client connecte puisse listes ces transactions 
faire transaction  tranfert  ou  paiment tout en sachant le solde du clien  nest pas stocke dans la base de donne  sera gere par un    le scope local   qui va gerre la  en  initalisant  dans chanque un un montants de 10000   pour  le cas solde = 10000-(sommmes des transsactions  payement +sommme destrantactions  tranfersts)  et a chaque  type  transaction sera  iune requete de transaction son  compte  sera debite  et  le destinaire    le montant de son solde  augmente
pour le  latransaction payement  on aura beseion du montant  et le  numero de la basede donne ou un code marchand de la  base de donnne
pour la tranasaction  payement  on a besion  de numero telephoen existant et le  montant
NB  dans une transaction tjrs verifer si   le montant    client a que  montant   dans solde 
 dans mon modele    cest un client a un compte de  type client et le distributeur a  compte de type distributeur ( seul le code du distributeur a un code marchand)
NB: tt  en responsable le  principe de single response
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