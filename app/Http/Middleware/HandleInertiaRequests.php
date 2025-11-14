<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'can' => $request->user() ? [
                'admin.home' => $request->user()->can('admin.home'),
                'admin.dashboard' => $request->user()->can('admin.dashboard'),
                'admin.users.index' => $request->user()->can('admin.users.index'),
                'admin.users.create' => $request->user()->can('admin.users.create'),
                'admin.users.edit' => $request->user()->can('admin.users.edit'),
                'admin.users.destroy' => $request->user()->can('admin.users.destroy'),
                'admin.categories.index' => $request->user()->can('admin.categories.index'),
                'admin.categories.create' => $request->user()->can('admin.categories.create'),
                'admin.categories.edit' => $request->user()->can('admin.categories.edit'),
                'admin.categories.destroy' => $request->user()->can('admin.categories.destroy'),
                'admin.tags.index' => $request->user()->can('admin.tags.index'),
                'admin.tags.create' => $request->user()->can('admin.tags.create'),
                'admin.tags.edit' => $request->user()->can('admin.tags.edit'),
                'admin.tags.destroy' => $request->user()->can('admin.tags.destroy'),
                'admin.posts.index' => $request->user()->can('admin.posts.index'),
                'admin.posts.create' => $request->user()->can('admin.posts.create'),
                'admin.posts.edit' => $request->user()->can('admin.posts.edit'),
                'admin.posts.destroy' => $request->user()->can('admin.posts.destroy'),
            ] : [],
        ]);
    }
}
