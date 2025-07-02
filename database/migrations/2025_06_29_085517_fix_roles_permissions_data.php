<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all roles and fix their permissions data
        $roles = DB::table('roles')->get();
        
        foreach ($roles as $role) {
            $permissions = $role->permissions;
            
            // If permissions is already an array, skip
            if (is_array($permissions)) {
                continue;
            }
            
            // If permissions is a JSON string, decode it
            if (is_string($permissions)) {
                $decoded = json_decode($permissions, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $permissions = $decoded;
                } else {
                    $permissions = [];
                }
            } else {
                $permissions = [];
            }
            
            // Update the role with fixed permissions
            DB::table('roles')
                ->where('id', $role->id)
                ->update(['permissions' => json_encode($permissions)]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this migration
    }
};
