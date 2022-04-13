<?php

use App\ContactsGroup;
use Illuminate\Database\Seeder;

class ContactsGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // News Letter Group
        $ContactsGroup = new ContactsGroup();
        $ContactsGroup->name = 'Newsletter Emails';
        $ContactsGroup->created_by = 1;
        $ContactsGroup->save();
    }
}
