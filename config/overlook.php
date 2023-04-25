<?php

return [
    'includes' => [
        App\Filament\Resources\SecretaryResource::class,
        App\Filament\Resources\LocalResource::class,
        App\Filament\Resources\DepartamentsResource::class,
        App\Filament\Resources\UserResource::class,
        \App\Filament\Resources\AcquisitionTypeResource::class

    ],
    'excludes' => [
        // App\Filament\Resources\Blog\AuthorResource::class,
    ],
];
