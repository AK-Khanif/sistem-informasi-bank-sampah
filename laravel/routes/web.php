<?php

use App\Livewire\Customers\CustomerCreate;
use App\Livewire\Customers\CustomerEdit;
use App\Livewire\Customers\CustomerIndex;
use App\Livewire\Customers\CustomerShow;
use App\Livewire\Settings\SettingsPage;
use App\Livewire\WasteCategories\WasteCategoryCreate;
use App\Livewire\WasteCategories\WasteCategoryEdit;
use App\Livewire\WasteCategories\WasteCategoryIndex;
use App\Livewire\WasteCategories\WasteCategoryShow;
use App\Livewire\WasteTypes\WasteTypeCreate;
use App\Livewire\WasteTypes\WasteTypeEdit;
use App\Livewire\WasteTypes\WasteTypeIndex;
use App\Livewire\WasteTypes\WasteTypeShow;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('settings', SettingsPage::class)
    ->middleware(['auth', 'verified'])
    ->name('settings.index');

Route::get('customers', CustomerIndex::class)
    ->middleware(['auth', 'verified'])
    ->name('customers.index');

Route::get('customers/create', CustomerCreate::class)
    ->middleware(['auth', 'verified'])
    ->name('customers.create');

Route::get('customers/{customer}', CustomerShow::class)
    ->middleware(['auth', 'verified'])
    ->name('customers.show');

Route::get('customers/{customer}/edit', CustomerEdit::class)
    ->middleware(['auth', 'verified'])
    ->name('customers.edit');

Route::get('waste-categories', WasteCategoryIndex::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-categories.index');

Route::get('waste-categories/create', WasteCategoryCreate::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-categories.create');

Route::get('waste-categories/{waste_category}', WasteCategoryShow::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-categories.show');

Route::get('waste-categories/{waste_category}/edit', WasteCategoryEdit::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-categories.edit');

Route::get('waste-types', WasteTypeIndex::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-types.index');

Route::get('waste-types/create', WasteTypeCreate::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-types.create');

Route::get('waste-types/{waste_type}', WasteTypeShow::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-types.show');

Route::get('waste-types/{waste_type}/edit', WasteTypeEdit::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-types.edit');

require __DIR__.'/auth.php';
