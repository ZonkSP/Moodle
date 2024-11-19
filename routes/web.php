<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\alumnoController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\Book;
use App\Models\Reader;
use App\Models\Prestamo;
use App\Models\User;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\EnrollmentRequest;
use App\Models\Calificacion;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\AlumnoTareasController;


// Ruta principal del dashboard del alumno
Route::middleware(['auth', 'role:Alumno'])->group(function () {
    Route::get('/alumno/tareas', [AlumnoTareasController::class, 'index'])->name('alumnos.tareas.index');
    Route::post('/entregas', [AlumnoTareasController::class, 'storeEntrega'])->name('entregas.store');
    // Rutas para tareas
    /* Route::get('/alumno/tareas', [AlumnoTareasController::class, 'tareasIndex'])->name('alumnos.tareas.index'); */
    Route::get('/alumno/tareas/{tarea}', [AlumnoTareasController::class, 'showTarea'])->name('alumnos.tareas.show');
});

//Entregas
Route::put('/entregas/{entrega}', [EntregaController::class, 'update'])->name('entregas.update');
Route::get('/entregas/download/{archivo}', [EntregaController::class, 'download'])->name('entregas.download');

//Tareas
Route::middleware(['auth', 'role:Profesor'])->group(function () {
    Route::get('/tareas/create', [TareaController::class, 'create'])->name('tareas.create');
    Route::post('/tareas', [TareaController::class, 'store'])->name('tareas.store');
    Route::get('/profesor/index', [TareaController::class, 'index'])->name('tareas.index');
    Route::get('/tareas/{tarea}', [TareaController::class, 'show'])->name('tareas.show');
    //Route::get('/entregas/download/{archivo}', [TareaController::class, 'download'])->name('entregas.download');
});


// routes/web.php
Route::post('/enrollment/request/{grupo}', [EnrollmentController::class, 'store'])->name('enrollment.request.store');

Route::post('/grupos/{grupo}/enroll', [GrupoController::class, 'enroll'])->name('grupos.enroll');

Route::get('/alumno/grupos-enrolled', [AlumnoController::class, 'enrolledGroups'])->name('alumno.enrolledGroups');

Route::post('/profesor/calificacion/{grupo_id}/{alumno_id}', [ProfesorController::class, 'storeCalificacion'])->name('profesor.calificacion.store');

Route::get('/profesor', [ProfesorController::class, 'showDashboard']);

Route::get('/profesor', [ProfesorController::class, 'showDashboard'])->name('profesor.dashboard');


Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users/create', [UserController::class, 'createUser'])->name('users.create');

Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

Route::get('/materias', [MateriaController::class, 'index'])->name('materias.index'); // Mostrar lista de materias
Route::post('/materias/create', [MateriaController::class, 'createMateria'])->name('materias.create'); // Crear una nueva materia

Route::get('/grupos', [GrupoController::class, 'index'])->name('grupos.index'); // Mostrar lista de materias
Route::post('/grupos/create', [GrupoController::class, 'createGrupo'])->name('grupos.create'); // Crear una nueva materia

Route::get('/grupos/{grupo}/edit', [GrupoController::class, 'edit'])->name('grupos.edit'); // Editar una materia específica
Route::put('/grupo/{grupo}', [GrupoController::class, 'update'])->name('grupos.update'); // Actualizar una materia
Route::delete('/grupos/{grupo}', [GrupoController::class, 'destroy'])->name('grupos.destroy'); // Eliminar una materia


Route::get('/materias/{materia}/edit', [MateriaController::class, 'edit'])->name('materias.edit'); // Editar una materia específica
Route::put('/materias/{materia}', [MateriaController::class, 'update'])->name('materias.update'); // Actualizar una materia
Route::delete('/materias/{materia}', [MateriaController::class, 'destroy'])->name('materias.destroy'); // Eliminar una materia

Route::get('/', function () {
    return view('welcome');
});

// Admin Dashboard Route
Route::get('/admin', function () {
    if (Auth::check() && Auth::user()->role === 'Administrador') {
        // Fetch all data
        $users = User::all();
        $materias = Materia::all();
        $grupos = Grupo::all();
        // Fetch only users with the 'Profesor' role
        $profesores = User::where('role', 'Profesor')->get();
        $requests = EnrollmentRequest::with(['alumno', 'grupo'])
        ->where('status', 'pending')
        ->get();
        // Pass all data to the view
        return view('admin.dashboard', compact('users', 'materias', 'grupos', 'profesores','requests'));
    }

    // If not authorized, redirect to home
    return redirect('/welcome')->with('error', 'You do not have access to this page.');
})->name('admin.dashboard');


Route::get('/profesor', function () {
    if (Auth::check() && Auth::user()->role === 'Profesor') {
        // Get the logged-in professor's ID
        $profesor_id = Auth::id();

        // Fetch data relevant to the logged-in professor
        $grupos = Grupo::where('profesor_id', $profesor_id)->get();
        $materias = Materia::all();  // You can leave other data as is or filter if needed
        $profesores = User::where('role', 'Profesor')->get();
        $calificaciones = Calificacion::all(); // You can leave other data as is
        // Pass data to the view
        return view('profesor.dashboard', compact('grupos', 'materias', 'profesores','calificaciones'));
    }
})->name('profesor.dashboard'); 

// Alumno Dashboard Route
Route::get('/alumno', [AlumnoController::class, 'dashboard'])->name('alumno.dashboard');




// Authentication Routes
Auth::routes();

// Home Route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::put('/enrollment/request/{id}/approve', [EnrollmentController::class, 'approve'])->name('enrollment.request.approve');
Route::delete('/enrollment/request/{id}/reject', [EnrollmentController::class, 'reject'])->name('enrollment.request.reject');
