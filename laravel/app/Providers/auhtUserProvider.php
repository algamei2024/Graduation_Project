<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Hash;

class auhtUserProvider extends EloquentUserProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }


    //تم انشاء هذا provider  واضافة هذه الدالتبين بشكل يدوي
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];
        return Hash::check($plain, $user->getAuthPassword());
    }

    public function retrieveByCredentials(array $credentials)
    {
        // تحقق من وجود email و admin_id
        if (empty($credentials['email']) || empty($credentials['admin_id'])) {
            return null;
        }

        // استرجاع المستخدم بناءً على email و admin_id
        return $this->createModel()->newQuery()
            ->where('email', $credentials['email'])
            ->where('admin_id', $credentials['admin_id'])
            ->first();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}