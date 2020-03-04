<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
      $admins = [[
          'admin_type' => 'super_admin',
          'name' => 'admin',
          'email' => 'admin@gmail.com',
          'password' => bcrypt('admin123'),
          'is_active' => 1,
          'created_at' => '2018-09-11 15:08:02',
          'updated_at' => '2018-09-11 15:08:03',
      ]];
      
      foreach($admins as $admin) {
          $objAdmin = App\Models\Admin::where('email', $admin['email'])->first();
          if($objAdmin)
              continue;
          $objAdmin = new App\Models\Admin();
          $objAdmin->fill($admin);
          $objAdmin->save();
      }
    }
}
