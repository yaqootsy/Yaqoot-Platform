<?php

namespace Database\Seeders;

use App\Enums\PermissinsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRole = Role::create(['name' => RolesEnum::User->value]);
        $vendorRole = Role::create(['name' => RolesEnum::Vendor->value]);
        $adminRole = Role::create(['name' => RolesEnum::Admin->value]);

        $apporveVendors = Permission::create(['name' => PermissinsEnum::ApproveVendors->value]);
        $sellProducts = Permission::create(['name' => PermissinsEnum::SellProducts->value]);
        $buyProducts = Permission::create(['name' => PermissinsEnum::BuyProducts->value]);

        $userRole->syncPermissions([
            $buyProducts
        ]);
        $vendorRole->syncPermissions([
            $sellProducts,
            $buyProducts
        ]);
        $adminRole->syncPermissions([
            $apporveVendors,
            $sellProducts,
            $buyProducts
        ]);
    }
}
