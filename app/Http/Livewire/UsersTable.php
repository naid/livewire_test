<?php

namespace App\Http\Livewire;

//use App\User;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use App\Models\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\DateColumn;

class UsersTable extends LivewireDatatable
{
    public $model = User::class;

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID')
                ->defaultSort('asc')
                ->sortBy('id')
                ->linkTo('user'),

            Column::name('first_name')
                ->label('First Name'),

            Column::name('last_name')
                ->label('Last Name'),

            Column::name('email')
                ->label('Email'),

            Column::edit()->label('delete'),

            DateColumn::name('created_at')
                ->label('Created at'),

           
            //Column::label('Actions')
        ];
    }
}