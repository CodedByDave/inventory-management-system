<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            // Personal Information
            TextInput::make('employee_id')
                ->label('Employee ID')
                ->default(fn() => now()->year . '-' . mt_rand(10000, 99999))
                ->readOnly()
                ->required(),

            TextInput::make('name')
                ->label('Full Name')
                ->required(),

            TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->required()
                ->unique('users', 'email', ignoreRecord: true),

            TextInput::make('phone')
                ->label('Phone Number')
                ->tel()
                ->nullable(),

            Select::make('gender')
                ->label('Gender')
                ->options([
                    'Male' => 'Male',
                    'Female' => 'Female',
                    'other' => 'Other',
                ])
                ->nullable(),

            DatePicker::make('date_of_birth')
                ->label('Date of Birth')
                 ->maxDate(Carbon::now()->subYears(18))
                ->nullable(),

            // Employment Information
            Select::make('role')
                ->label('Role')
                ->options([
                    'admin' => 'Admin',
                    'manager' => 'Manager',
                    'employee' => 'Employee',
                ])
                ->required(),

            Select::make('status')
                ->label('Employment Status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ])
                ->required(),

            DatePicker::make('date_hired')
                ->label('Date Hired')
                ->maxDate(now())
                ->nullable(),

            // Additional Information
            TextInput::make('address')
                ->label('Address')
                ->nullable(),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(fn($operation) => $operation === 'create')
                ->dehydrated(fn($state) => filled($state))
                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                ->disabled(fn($operation) => $operation === 'edit')
                ->confirmed(),

            TextInput::make('password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->required(fn($operation) => $operation === 'create')
                ->disabled(fn($operation) => $operation === 'edit')
                ->dehydrated(false),

            FileUpload::make('photo')
                ->label('Profile Picture')
                ->image()
                ->directory('employees/photos')
                ->avatar()
                ->nullable(),
        ]);
    }
}
