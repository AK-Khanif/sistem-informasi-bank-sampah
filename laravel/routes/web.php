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
use App\Livewire\WastePrices\WastePriceCreate;
use App\Livewire\WastePrices\WastePriceEdit;
use App\Livewire\WastePrices\WastePriceIndex;
use App\Livewire\WastePrices\WastePriceShow;
use App\Livewire\Collectors\CollectorCreate;
use App\Livewire\Collectors\CollectorEdit;
use App\Livewire\Collectors\CollectorIndex;
use App\Livewire\Collectors\CollectorShow;
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

Route::get('waste-prices', WastePriceIndex::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-prices.index');

Route::get('waste-prices/create', WastePriceCreate::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-prices.create');

Route::get('waste-prices/{waste_price}', WastePriceShow::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-prices.show');

Route::get('waste-prices/{waste_price}/edit', WastePriceEdit::class)
    ->middleware(['auth', 'verified'])
    ->name('waste-prices.edit');

Route::get('collectors', CollectorIndex::class)
    ->middleware(['auth', 'verified'])
    ->name('collectors.index');

Route::get('collectors/create', CollectorCreate::class)
    ->middleware(['auth', 'verified'])
    ->name('collectors.create');

Route::get('collectors/{collector}', CollectorShow::class)
    ->middleware(['auth', 'verified'])
    ->name('collectors.show');

Route::get('collectors/{collector}/edit', CollectorEdit::class)
    ->middleware(['auth', 'verified'])
    ->name('collectors.edit');

require __DIR__.'/auth.php';
