<?php
/**
* User group seeder
* it fills up the database with some user groups
*/
class UserGroupSeeder extends Seeder {
    public function run(){
    	DB::table('groups')->delete();
    	$this->command->info('Emptied the table groups');

        try{
		    // Create the groups
		    foreach ($this->generate_groups() as $group) {
			    $create = Sentry::createGroup($group);
		    	$this->command->info('Group Created '. $group['name']);
		    }
		}catch (Cartalyst\Sentry\Groups\NameRequiredException $e){
		    $this->command->info('Name field is required');
		}catch (Cartalyst\Sentry\Groups\GroupExistsException $e){
		    $this->command->info('Group already exists');
		}
    }

    public function generate_groups(){
    	$male = array(
			'name' => 'male',
			'permissions' => array(
	            'vote' 		=> 1,
	            'share' 	=> 1,
	            'follow' 	=> 1,
	        ),
		);
		$female = array(
			'name' => 'female',
			'permissions' => $male['permissions'] + array(
	            'upload'		=> 1,
	            'photo.remove' 	=> 1,
	            'photo.edit'	=> 1,
	        ),
		);

		$recruiter = array(
			'name' => 'recruiter',
			'permissions' 		=> $female['permissions'] + array(
	            'user.manage' 	=> 1
	        ),
		);

		$admin = array(
			'name' => 'admin',
			'permissions' => $recruiter['permissions'] + array(
				'page.manage' => 1
			),
		);

		return array($male, $female, $recruiter, $admin);
    }
}