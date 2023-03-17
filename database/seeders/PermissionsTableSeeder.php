<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'product_management_access',
            ],
            [
                'id'    => 18,
                'title' => 'product_category_create',
            ],
            [
                'id'    => 19,
                'title' => 'product_category_edit',
            ],
            [
                'id'    => 20,
                'title' => 'product_category_show',
            ],
            [
                'id'    => 21,
                'title' => 'product_category_delete',
            ],
            [
                'id'    => 22,
                'title' => 'product_category_access',
            ],
            [
                'id'    => 23,
                'title' => 'product_tag_create',
            ],
            [
                'id'    => 24,
                'title' => 'product_tag_edit',
            ],
            [
                'id'    => 25,
                'title' => 'product_tag_show',
            ],
            [
                'id'    => 26,
                'title' => 'product_tag_delete',
            ],
            [
                'id'    => 27,
                'title' => 'product_tag_access',
            ],
            [
                'id'    => 28,
                'title' => 'product_create',
            ],
            [
                'id'    => 29,
                'title' => 'product_edit',
            ],
            [
                'id'    => 30,
                'title' => 'product_show',
            ],
            [
                'id'    => 31,
                'title' => 'product_delete',
            ],
            [
                'id'    => 32,
                'title' => 'product_access',
            ],
            [
                'id'    => 33,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 34,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 35,
                'title' => 'team_create',
            ],
            [
                'id'    => 36,
                'title' => 'team_edit',
            ],
            [
                'id'    => 37,
                'title' => 'team_show',
            ],
            [
                'id'    => 38,
                'title' => 'team_delete',
            ],
            [
                'id'    => 39,
                'title' => 'team_access',
            ],
            [
                'id'    => 40,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 41,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 42,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 43,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 44,
                'title' => 'task_management_access',
            ],
            [
                'id'    => 45,
                'title' => 'task_status_create',
            ],
            [
                'id'    => 46,
                'title' => 'task_status_edit',
            ],
            [
                'id'    => 47,
                'title' => 'task_status_show',
            ],
            [
                'id'    => 48,
                'title' => 'task_status_delete',
            ],
            [
                'id'    => 49,
                'title' => 'task_status_access',
            ],
            [
                'id'    => 50,
                'title' => 'task_tag_create',
            ],
            [
                'id'    => 51,
                'title' => 'task_tag_edit',
            ],
            [
                'id'    => 52,
                'title' => 'task_tag_show',
            ],
            [
                'id'    => 53,
                'title' => 'task_tag_delete',
            ],
            [
                'id'    => 54,
                'title' => 'task_tag_access',
            ],
            [
                'id'    => 55,
                'title' => 'task_create',
            ],
            [
                'id'    => 56,
                'title' => 'task_edit',
            ],
            [
                'id'    => 57,
                'title' => 'task_show',
            ],
            [
                'id'    => 58,
                'title' => 'task_delete',
            ],
            [
                'id'    => 59,
                'title' => 'task_access',
            ],
            [
                'id'    => 60,
                'title' => 'tasks_calendar_access',
            ],
            [
                'id'    => 61,
                'title' => 'faq_management_access',
            ],
            [
                'id'    => 62,
                'title' => 'faq_category_create',
            ],
            [
                'id'    => 63,
                'title' => 'faq_category_edit',
            ],
            [
                'id'    => 64,
                'title' => 'faq_category_show',
            ],
            [
                'id'    => 65,
                'title' => 'faq_category_delete',
            ],
            [
                'id'    => 66,
                'title' => 'faq_category_access',
            ],
            [
                'id'    => 67,
                'title' => 'faq_question_create',
            ],
            [
                'id'    => 68,
                'title' => 'faq_question_edit',
            ],
            [
                'id'    => 69,
                'title' => 'faq_question_show',
            ],
            [
                'id'    => 70,
                'title' => 'faq_question_delete',
            ],
            [
                'id'    => 71,
                'title' => 'faq_question_access',
            ],
            [
                'id'    => 72,
                'title' => 'product_status_create',
            ],
            [
                'id'    => 73,
                'title' => 'product_status_edit',
            ],
            [
                'id'    => 74,
                'title' => 'product_status_show',
            ],
            [
                'id'    => 75,
                'title' => 'product_status_delete',
            ],
            [
                'id'    => 76,
                'title' => 'product_status_access',
            ],
            [
                'id'    => 77,
                'title' => 'product_ajaxi_create',
            ],
            [
                'id'    => 78,
                'title' => 'product_ajaxi_edit',
            ],
            [
                'id'    => 79,
                'title' => 'product_ajaxi_show',
            ],
            [
                'id'    => 80,
                'title' => 'product_ajaxi_delete',
            ],
            [
                'id'    => 81,
                'title' => 'product_ajaxi_access',
            ],
            [
                'id'    => 82,
                'title' => 'supplier_create',
            ],
            [
                'id'    => 83,
                'title' => 'supplier_edit',
            ],
            [
                'id'    => 84,
                'title' => 'supplier_show',
            ],
            [
                'id'    => 85,
                'title' => 'supplier_delete',
            ],
            [
                'id'    => 86,
                'title' => 'supplier_access',
            ],
            [
                'id'    => 87,
                'title' => 'purchase_management_access',
            ],
            [
                'id'    => 88,
                'title' => 'expense_create',
            ],
            [
                'id'    => 89,
                'title' => 'expense_edit',
            ],
            [
                'id'    => 90,
                'title' => 'expense_show',
            ],
            [
                'id'    => 91,
                'title' => 'expense_delete',
            ],
            [
                'id'    => 92,
                'title' => 'expense_access',
            ],
            [
                'id'    => 93,
                'title' => 'purchase_create',
            ],
            [
                'id'    => 94,
                'title' => 'purchase_edit',
            ],
            [
                'id'    => 95,
                'title' => 'purchase_show',
            ],
            [
                'id'    => 96,
                'title' => 'purchase_delete',
            ],
            [
                'id'    => 97,
                'title' => 'purchase_access',
            ],
            [
                'id'    => 98,
                'title' => 'return_purchase_create',
            ],
            [
                'id'    => 99,
                'title' => 'return_purchase_edit',
            ],
            [
                'id'    => 100,
                'title' => 'return_purchase_show',
            ],
            [
                'id'    => 101,
                'title' => 'return_purchase_delete',
            ],
            [
                'id'    => 102,
                'title' => 'return_purchase_access',
            ],
            [
                'id'    => 103,
                'title' => 'damage_purchase_create',
            ],
            [
                'id'    => 104,
                'title' => 'damage_purchase_edit',
            ],
            [
                'id'    => 105,
                'title' => 'damage_purchase_show',
            ],
            [
                'id'    => 106,
                'title' => 'damage_purchase_delete',
            ],
            [
                'id'    => 107,
                'title' => 'damage_purchase_access',
            ],
            [
                'id'    => 108,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
