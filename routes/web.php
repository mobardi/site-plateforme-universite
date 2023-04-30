<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\MainController;
use App\Models\User;
use App\Models\Cours;
use App\Models\Formation;
use App\Models\Planning;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

//Inscription/Connexion/Deconnexion
Route::get('/register', [SessionController::class, 'newUserForm'])->name('register.form');
Route::post('/register', [SessionController::class, 'newUser'])->name('register.store');

Route::get('/login', [SessionController::class, 'loginForm'])->name('login.form');
Route::post('/login', [SessionController::class, 'login'])->name('login.store');

Route::get('/logout', [SessionController::class, 'logout'])->name('logout');

//Parametres
Route::get('/settings', [MainController::class, 'settings'])->name('settings');
Route::put('/settings/updatename', [MainController::class, 'updateName'])->name('update.name');
Route::put('/settings/updatepassword', [MainController::class, 'updatePassword'])->name('update.password');


//-----------ADMIN------------\\
Route::get('/admin/users', function () {
    // Vérifier que l'utilisateur est un administrateur
    if (auth()->user()->type !== 'admin') {
        abort(403, 'Unauthorized action.');
    }
    
    $query = App\Models\User::query();
    
    // Filtrer par type si la requête contient une valeur pour le paramètre "type"
    if (request()->query('type')) {
        $query->where('type', request()->query('type'));
    }
    
    // Récupérer tous les utilisateurs
    $users = $query->get();
    
    // Afficher la vue avec la liste des utilisateurs
    return view('admin.usersindex', ['users' => $users]);
})->name('users.index');

Route::get('/admin/users/create_user', [MainController::class, 'usersCreate'])->name('users.create');
Route::post('/admin/users', [MainController::class, 'usersStore'])->name('users.store');
Route::get('/admin/users/{user}/edit', [MainController::class, 'usersEdit'])->name('users.edit');
Route::put('/admin/users/{user}/update', [MainController::class, 'usersUpdate'])->name('users.update');

Route::delete('/users/{user}', [MainController::class, 'usersDelete'])->name('users.delete');



Route::get('/admin/cours', function () {
    // Vérifier que l'utilisateur est un administrateur
    if (auth()->user()->type !== 'admin') {
        abort(403, 'Unauthorized action.');
    }
    // Récupérer les cours (tous/filtrés par recherche)
    $query = Cours::query();
    if (request()->query('q')) {
        $query->where('intitule', 'like', "%".request()->query('q')."%");
    }
    if (auth()->user()->type === 'enseignant') {
        $query->where('user_id', auth()->id());
    } elseif (request()->query('enseignant')) {
        $query->where('user_id', request()->query('enseignant'));
    }
    $cours = $query->get();
    $enseignants = User::where('type', 'enseignant')->get();
    // Afficher la vue
    return view('admin.coursindex', ['cours' => $cours, 'enseignants' => $enseignants]);
})->name('cours.index');




// Créer un cours
Route::get('/cours/create', [MainController::class, 'coursCreate'])->name('cours.create');
Route::post('/cours', [MainController::class, 'coursStore'])->name('cours.store');
// Modifier ou suppriemr un cours
Route::get('/cours/{cour}/edit', [MainController::class, 'coursEdit'])->name('cours.edit');
Route::put('/cours/{cour}/update', [MainController::class, 'coursUpdate'])->name('cours.update');
Route::delete('/admin/cours/{id}', [MainController::class, 'coursDelete'])->name('cours.delete');

// Gestion des formations :
Route::get('/admin/formations', function () {
    // Vérifier que l'utilisateur est un administrateur
    if (auth()->user()->type !== 'admin') {
        abort(403, 'Unauthorized action.');
    }
    // Récupérer les formations
    $formations =Formation::all();
    // Afficher la vue avec la liste des formations
    return view('admin.formationsindex', ['formations' => $formations]);
})->name('formations.index');

// Afficher le formulaire pour créer une nouvelle formation
Route::get('/admin/formations/create', [MainController::class, 'formationsCreate'])->name('formations.create');
// Enregistrer une nouvelle formation
Route::post('/admin/formations/store', [MainController::class, 'formationsStore'])->name('formations.store');

// Afficher le formulaire de modification des formations
Route::get('/admin/formations/{formation}/edit', [MainController::class, 'formationsEdit'])->name('formations.edit');
// Mettre à jour une formation
Route::put('/admin/formations/{formation}',[MainController::class, 'formationsUpdate'])->name('formations.update');

// Supprimer une formation de la base de données
Route::delete('/admin/formations/{formation}', [MainController::class, 'formationsDelete'])->name('formations.delete');

// Plannings
Route::get('/admin/planning', [MainController::class, 'adminPlanning'])->name('admin.planning');
Route::get('/admin/planning/create', [MainController::class, 'adminSeanceCreate'])->name('admin.seancecreate');
Route::post('/admin/planning', [MainController::class, 'adminSeanceStore'])->name('admin.seancestore');
Route::get('/admin/planning/{planning}/edit', [MainController::class, 'adminSeanceEdit'])->name('admin.seanceedit');
Route::put('/admin/planning/{planning}', [MainController::class, 'adminSeanceUpdate'])->name('admin.seanceupdate');
Route::delete('/admin/planning/{planning}', [MainController::class, 'adminSeanceDelete'])->name('admin.seancedelete');







//----------ETUDIANT----------\\

// Index des cours de la formation
Route::get('/etudiant/maformation', [MainController::class, 'etudiantFormation'])->name('etudiant.maformation');
Route::post('/etudiant/inscription/{cours}', [MainController::class, 'inscriptionCours'])->name('etudiant.inscription');
Route::post('/etudiant/desinscription/{cours}', [MainController::class, 'desinscriptionCours'])->name('etudiant.desinscription');
Route::get('/etudiant/planning', [MainController::class, 'etudiantPlanning'])->name('etudiant.planning');



//----------ENSEIGNANT----------\\
Route::get('/enseignant/mescours', [MainController::class, 'enseignantCours'])->name('enseignant.mescours');
Route::get('enseignant/planning', [MainController::class, 'enseignantPlanning'])->name('enseignant.planning');
Route::get('/enseignant/planning/create', [MainController::class, 'enseignantSeanceCreate'])->name('enseignant.seancecreate');
Route::post('/enseignant/planning', [MainController::class,'enseignantSeanceStore'])->name('enseignant.seancestore');
// Route pour afficher le formulaire de modification de la séance
Route::get('/enseignant/planning/{planning}/edit', [MainController::class, 'enseignantSeanceEdit'])->name('enseignant.seanceedit');

// Route pour mettre à jour la séance dans la base de données
Route::put('/enseignant/planning/{planning}', [MainController::class, 'enseignantSeanceUpdate'])->name('enseignant.seanceupdate');

// Route pour supprimer la séance de la base de données
Route::delete('/enseignant/planning/{planning}', [MainController::class, 'enseignantSeanceDelete'])->name('enseignant.seancedelete');
