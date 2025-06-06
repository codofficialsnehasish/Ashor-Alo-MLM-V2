<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the default permissions
        $permissions = [
            array('name' => 'Create Role','group_name' => 'Roles'),
            array('name' => 'View Role','group_name' => 'Roles'),
            array('name' => 'Edit Role','group_name' => 'Roles'),
            array('name' => 'Delete Role','group_name' => 'Roles'),
            array('name' => 'Assign Permission','group_name' => 'Roles'),

            array('name' => 'Create Permission','group_name' => 'Permissions'),
            array('name' => 'View Permission','group_name' => 'Permissions'),
            array('name' => 'Edit Permission','group_name' => 'Permissions'),
            array('name' => 'Delete Permission','group_name' => 'Permissions'),

            array('name' => 'Create User','group_name' => 'System Users'),
            array('name' => 'View User','group_name' => 'System Users'),
            array('name' => 'Edit User','group_name' => 'System Users'),
            array('name' => 'Delete User','group_name' => 'System Users'),
            array('name' => 'Activity Log','group_name' => 'System Users'),

            array('name' => 'Create Monthly Return','group_name' => 'Master Data'),
            array('name' => 'View Monthly Return','group_name' => 'Master Data'),
            array('name' => 'Edit Monthly Return','group_name' => 'Master Data'),
            array('name' => 'Delete Monthly Return','group_name' => 'Master Data'),

            array('name' => 'Create Level Bonus','group_name' => 'Master Data'),
            array('name' => 'View Level Bonus','group_name' => 'Master Data'),
            array('name' => 'Edit Level Bonus','group_name' => 'Master Data'),
            array('name' => 'Delete Level Bonus','group_name' => 'Master Data'),

            array('name' => 'Create Remuneration Benefit','group_name' => 'Master Data'),
            array('name' => 'View Remuneration Benefit','group_name' => 'Master Data'),
            array('name' => 'Edit Remuneration Benefit','group_name' => 'Master Data'),
            array('name' => 'Delete Remuneration Benefit','group_name' => 'Master Data'),

            array('name' => 'Edit MLM Settings','group_name' => 'MLM Settings'),

            array('name' => 'Create Leaders','group_name' => 'Leaders'),
            array('name' => 'View Leaders','group_name' => 'Leaders'),  
            array('name' => 'Edit Leaders','group_name' => 'Leaders'),
            array('name' => 'Delete Leaders','group_name' => 'Leaders'),
            array('name' => 'Tree View','group_name' => 'Leaders'),
            array('name' => 'Transfer Tree','group_name' => 'Leaders'),
            array('name' => 'View Members Of Leader','group_name' => 'Leaders'),

            array('name' => 'View KYC','group_name' => 'KYC'),
            array('name' => 'KYC Details','group_name' => 'KYC'),
            array('name' => 'KYC Activity','group_name' => 'KYC'),

            array('name' => 'Create Categories','group_name' => 'Categories'),
            array('name' => 'View Categories','group_name' => 'Categories'),
            array('name' => 'Edit Categories','group_name' => 'Categories'),
            array('name' => 'Delete Categories','group_name' => 'Categories'),

            array('name' => 'Create Products','group_name' => 'Products'),
            array('name' => 'View Products','group_name' => 'Products'),
            array('name' => 'Edit Products','group_name' => 'Products'),
            array('name' => 'Delete Products','group_name' => 'Products'),

            array('name' => 'Create Order','group_name' => 'Order'),
            array('name' => 'View Order','group_name' => 'Order'),
            array('name' => 'View Order Recipts','group_name' => 'Order'),
            array('name' => 'Delete Order','group_name' => 'Order'),
            array('name' => 'Update Order Status','group_name' => 'Order'),

            array('name' => 'ID Activation Report','group_name' => 'Report'),
            array('name' => 'Sales Report','group_name' => 'Report'),
            array('name' => 'TDS Report','group_name' => 'Report'),
            array('name' => 'Repurchase Report','group_name' => 'Report'),
            array('name' => 'Direct Bonus Report','group_name' => 'Report'),
            array('name' => 'Level Bonus Report','group_name' => 'Report'),
            array('name' => 'Investor Return Report','group_name' => 'Report'),
            array('name' => 'Product Support Report','group_name' => 'Report'),
            array('name' => 'Payout Report','group_name' => 'Report'),
            array('name' => 'Payout History Report','group_name' => 'Report'),
            array('name' => 'Hold Amount Report','group_name' => 'Report'),
            array('name' => 'Paid/Unpaid Payments Report','group_name' => 'Report'),
            array('name' => 'Commission < 200 Report','group_name' => 'Report'),
            array('name' => 'Remuneration Transaction Report','group_name' => 'Report'),
            array('name' => 'Remuneration Report','group_name' => 'Report'),
            array('name' => 'Level Wise Business Report','group_name' => 'Report'),
            array('name' => 'Tree Wise Business Report','group_name' => 'Report'),
            array('name' => 'Dilse Plan Report','group_name' => 'Report'),
            array('name' => 'Add On Report','group_name' => 'Report'),
            array('name' => 'Product Delivery Report','group_name' => 'Report'),

            array('name' => 'Edit Site Settings','group_name' => 'Site Settings'),

            array('name' => 'Create Certificates','group_name' => 'Legal'),
            array('name' => 'View Certificates','group_name' => 'Legal'),
            array('name' => 'Edit Certificates','group_name' => 'Legal'),
            array('name' => 'Delete Certificates','group_name' => 'Legal'),

            array('name' => 'Edit Terms & Conditions','group_name' => 'Legal'),
            array('name' => 'Edit Privacy Policy','group_name' => 'Legal'),

            array('name' => 'View Contact Requests','group_name' => 'Contact Requests'),
            array('name' => 'Delete Contact Requests','group_name' => 'Contact Requests'),
            
            array('name' => 'Create Photo Gallery','group_name' => 'Photo Gallery'),
            array('name' => 'View Photo Gallery','group_name' => 'Photo Gallery'),
            array('name' => 'Edit Photo Gallery','group_name' => 'Photo Gallery'),
            array('name' => 'Delete Photo Gallery','group_name' => 'Photo Gallery'),

            array('name' => 'Create Notice','group_name' => 'Notice Board'),
            array('name' => 'View Notice','group_name' => 'Notice Board'),
            array('name' => 'Edit Notice','group_name' => 'Notice Board'),
            array('name' => 'Delete Notice','group_name' => 'Notice Board'),
            
        ];

        // Create the permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['group_name' => $permission['group_name']]
            );
        }

    }
}
