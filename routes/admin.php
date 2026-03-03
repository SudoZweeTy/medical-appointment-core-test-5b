<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\SupportTicketController;
use Illuminate\Support\Facades\Route;

// Dashboard admin
Route::get('/', function (){
    return view('admin.dashboard');
})->name('dashboard');

// Gestión de roles
Route::resource('roles', RoleController::class)->names('roles');

// Gestión de usuarios
Route::resource('users', UserController::class)->names('users');

// Gestión de pacientes (solo ver y editar, se crean desde usuarios)
Route::resource('patients', PatientController::class)
    ->only(['index', 'show', 'edit', 'update'])
    ->names('patients');

// Gestión de doctores (solo ver y editar, se crean desde usuarios)
Route::resource('doctors', DoctorController::class)
    ->only(['index', 'show', 'edit', 'update'])
    ->names('doctors');

// ──────────────────────────────────────────────────
// Módulo de Soporte — Tickets de soporte técnico
// Permite a los usuarios reportar problemas y al admin
// gestionar el estado, prioridad y respuesta de cada ticket.
// CRUD completo: listar, crear, ver, editar, eliminar.
// ──────────────────────────────────────────────────
Route::resource('tickets', SupportTicketController::class)->names('tickets');

