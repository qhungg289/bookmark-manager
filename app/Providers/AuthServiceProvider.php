<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Bookmark;
use App\Models\Folder;
use App\Policies\BookmarkPolicy;
use App\Policies\FolderPolicy;
use App\Policies\TagPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Folder::class => FolderPolicy::class,
        Bookmark::class => BookmarkPolicy::class,
        Tag::class => TagPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
