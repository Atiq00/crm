<?php

use App\User;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	app()[PermissionRegistrar::class]->forgetCachedPermissions();
		
		// create permissions
		$this->createPermissions();

		// create roles
		$this->createRoles();

		// assign roles and permissions
		$this->assignPermissions();
		$this->assignRoles();
		

    }

	public function createPermissions()
	{
		// users
		Permission::create(['name' => 'users.*']);
		Permission::create(['name' => 'users.index']);
		Permission::create(['name' => 'users.create']);
		Permission::create(['name' => 'users.edit']);
		Permission::create(['name' => 'users.delete']);
		

		// kb
		Permission::create(['name' => 'kb.*']);
		Permission::create(['name' => 'kb.index']);
		Permission::create(['name' => 'kb.create']);
		Permission::create(['name' => 'kb.edit']);
		Permission::create(['name' => 'kb.delete']);
		

		// kb_category
		Permission::create(['name' => 'kb_category.*']);
		Permission::create(['name' => 'kb_category.index']);
		Permission::create(['name' => 'kb_category.create']);
		Permission::create(['name' => 'kb_category.edit']);
		Permission::create(['name' => 'kb_category.delete']);
		

		// faq_category
		Permission::create(['name' => 'faq_category.*']);
		Permission::create(['name' => 'faq_category.index']);
		Permission::create(['name' => 'faq_category.create']);
		Permission::create(['name' => 'faq_category.edit']);
		Permission::create(['name' => 'faq_category.delete']);
		

		// faq
		Permission::create(['name' => 'faq.*']);
		Permission::create(['name' => 'faq.index']);
		Permission::create(['name' => 'faq.create']);
		Permission::create(['name' => 'faq.edit']);
		Permission::create(['name' => 'faq.delete']);
		

		// department
		Permission::create(['name' => 'department.*']);
		Permission::create(['name' => 'department.index']);
		Permission::create(['name' => 'department.create']);
		Permission::create(['name' => 'department.edit']);
		Permission::create(['name' => 'department.delete']);
		

		// priority
		Permission::create(['name' => 'priority.*']);
		Permission::create(['name' => 'priority.index']);
		Permission::create(['name' => 'priority.create']);
		Permission::create(['name' => 'priority.edit']);
		Permission::create(['name' => 'priority.delete']);
		

		// ticket
		Permission::create(['name' => 'ticket.*']);
		Permission::create(['name' => 'ticket.index']);
		Permission::create(['name' => 'ticket.create']);
		Permission::create(['name' => 'ticket.edit']);
		Permission::create(['name' => 'ticket.delete']);
		Permission::create(['name' => 'ticket.reply_ticket']);
		Permission::create(['name' => 'ticket_assigned_only']);
		Permission::create(['name' => 'ticket.assign_user']);
		

		// ticket_canned_messages
		Permission::create(['name' => 'ticket_canned_messages.*']);
		Permission::create(['name' => 'ticket_canned_messages.index']);
		Permission::create(['name' => 'ticket_canned_messages.create']);
		Permission::create(['name' => 'ticket_canned_messages.edit']);
		Permission::create(['name' => 'ticket_canned_messages.delete']);

		// customer
		Permission::create(['name' => 'customer.*']);
		Permission::create(['name' => 'customer.index']);
		Permission::create(['name' => 'customer.create']);
		Permission::create(['name' => 'customer.edit']);
		Permission::create(['name' => 'customer.delete']);

		// role
		Permission::create(['name' => 'role.*']);
		Permission::create(['name' => 'role.index']);
		Permission::create(['name' => 'role.create']);
		Permission::create(['name' => 'role.edit']);
		Permission::create(['name' => 'role.delete']);
		
	}
	
	public function createRoles()
	{
		
		Role::create([
			'name'	=>	'Super Admin',
			'guard_name'	=>	'web',
		]);
		Role::create([
			'name'	=>	'Agent',
			'guard_name'	=>	'web',
		]);

	}

	public function assignPermissions()
	{
		
		$role = Role::where('name', 'Agent')->first();

		$permissions = [
			'ticket.index',
			'ticket.reply_ticket',
			'ticket_assigned_only',
			'ticket_canned_messages.*',
			'ticket_canned_messages.index',
			'ticket_canned_messages.create',
			'ticket_canned_messages.edit',
			'ticket_canned_messages.delete',
		];

		foreach ( $permissions as $code ) {
			$role->givePermissionTo($code);
		};

	}

	public function assignRoles()
	{
		
		$user = User::find(1);
		$user->assignRole('Super Admin');

		$user = User::find(2);
		$user->assignRole('Agent');

	}

}
