<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\CssTemplate;
use App\Page;
use App\ContentArea;
use App\Article;
use App\AccessLevel;
use App\UsersToAccessLevel;

class DatabaseSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->call(UserTableSeeder::class);
        $this->call(ContentAreaSeeder::class);
        $this->call(CssTemplateSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(AccessLevelsSeeder::class);
        $this->call(UsersToAccessLevelsSeeder::class);
    }
}


class UserTableSeeder extends Seeder {
    public function run(){
        DB::table('users')->delete();
        User::create(['fName' => 'Adminis',
            'lName' => 'Trator',
            'email' => 'admin@inet.com',
            'password' => Hash::make('testword'),
            'createdBy' => 2]);
        User::create(['fName' => 'Ed',
            'lName' => 'Itor',
            'email' => 'editor@inet.com',
            'password' => Hash::make('testword'),
            'createdBy' => 2]);
        User::create(['fName' => 'Au',
            'lName' => 'Thor',
            'email' => 'author@inet.com',
            'password' => Hash::make('testword'),
            'createdBy' => 2]);
    }
}

class CssTemplateSeeder extends Seeder {
    public function run(){
        DB::table('css_templates')->delete();
        CssTemplate::create(['name' => 'TestTemplate A',
            'active' => 0,
            'cssContent' => 'SOME CSS GOES HERE',
            'createdBy' => 2]);
        CssTemplate::create(['name' => 'TestTemplate B',
            'active' => 0,
            'cssContent' => 'SOME CSS GOES HERE',
            'createdBy' => 2]);
        CssTemplate::create(['name' => 'TestTemplate C',
            'active' => 0,
            'cssContent' => 'SOME CSS GOES HERE',
            'createdBy' => 3]);
        CssTemplate::create(['name' => 'TestTemplate D',
            'active' => 0,
            'cssContent' => 'SOME CSS GOES HERE',
            'createdBy' => 1]);
        CssTemplate::create(['name' => 'TestTemplate E',
            'active' => 0,
            'cssContent' => 'SOME CSS GOES HERE',
            'createdBy' => 3]);
    }
}

class ContentAreaSeeder extends Seeder {
    public function run(){
        DB::table('content_areas')->delete();
        ContentArea::create(['name' => 'TestArea A',
            'alias' => 'CAA',
            'order' => 1,
            'description' => 'This is TestArea A',
            'createdBy' => 2]);
        ContentArea::create(['name' => 'TestArea B',
            'alias' => 'CAB',
            'order' => 2,
            'description' => 'This is TestArea B',
            'createdBy' => 2]);
        ContentArea::create(['name' => 'TestArea C',
            'alias' => 'CAC',
            'order' => 3,
            'description' => 'This is TestArea C',
            'createdBy' => 3]);
        ContentArea::create(['name' => 'TestArea D',
            'alias' => 'CAD',
            'order' => 4,
            'description' => 'This is TestArea D',
            'createdBy' => 1]);
        ContentArea::create(['name' => 'TestArea E',
            'alias' => 'CAE',
            'order' => 5,
            'description' => 'This is TestArea E',
            'createdBy' => 2]);
    }
}

class PageSeeder extends Seeder {
    public function run(){
        Page::create(['name' => 'Page A',
            'alias' => 'PA',
            'description' => 'This is Page A',
            'createdBy' => 2]);
        Page::create(['name' => 'Page B',
            'alias' => 'PB',
            'description' => 'This is Page B',
            'createdBy' => 2]);
        Page::create(['name' => 'Page C',
            'alias' => 'PC',
            'description' => 'This is Page C',
            'createdBy' => 3]);
        Page::create(['name' => 'Page D',
            'alias' => 'PD',
            'description' => 'This is Page D',
            'createdBy' => 3]);
        Page::create(['name' => 'Page E',
            'alias' => 'PE',
            'description' => 'This is Page E',
            'createdBy' => 3]);
    }
}

class ArticleSeeder extends Seeder{
    public function run(){
        DB::table('articles')->delete();
        Article::create(['name' => 'Article A',
            'title' => 'First Article',
            'description' => 'This is the First Article',
            'page' => 1,
            'contentArea' => 1,
            'htmlContent' => '<html><h1>Put HTML Content in me</h1></html>',
            'createdBy' => 2,
            'allPages' => false]);
        Article::create(['name' => 'Article B',
            'title' => 'Second Article',
            'description' => 'This is the Second Article',
            'page' => 2,
            'contentArea' => 2,
            'htmlContent' => '<html><h1>Put HTML Content in me</h1></html>',
            'createdBy' => 2,
            'allPages' => false]);
        Article::create(['name' => 'Article C',
            'title' => 'Third Article',
            'description' => 'This is the Third Article',
            'page' => 3,
            'contentArea' => 3,
            'htmlContent' => '<html><h1>Put HTML Content in me</h1></html>',
            'createdBy' => 3,
            'allPages' => false]);
        Article::create(['name' => 'Article D',
            'title' => 'Fourth Article',
            'description' => 'This is the Fourth Article',
            'page' => 4,
            'contentArea' => 4,
            'htmlContent' => '<html><h1>Put HTML Content in me</h1></html>',
            'createdBy' => 2,
            'allPages' => false]);
        Article::create(['name' => 'Article E',
            'title' => 'Fifth Article',
            'description' => 'This is the Fifth Article',
            'page' => 5,
            'contentArea' => 5,
            'htmlContent' => '<html><h1>Put HTML Content in me</h1></html>',
            'createdBy' => 2,
            'allPages' => false]);
    }
}

class AccessLevelsSeeder extends Seeder{
    public function run(){
        DB::table('access_levels')->delete();
        AccessLevel::create(['accessLevelName' => 'Admin']);
        AccessLevel::create(['accessLevelName' => 'Author']);
        AccessLevel::create(['accessLevelName' => 'Editor']);
    }
}

class UsersToAccessLevelsSeeder extends Seeder{
    public function run(){
        UsersToAccessLevel::create(['userId' => 1, 'AccessLevelID' => 1]);
        UsersToAccessLevel::create(['userId' => 1, 'AccessLevelID' => 2]);
        UsersToAccessLevel::create(['userId' => 1, 'AccessLevelID' => 3]);
        UsersToAccessLevel::create(['userId' => 2, 'AccessLevelID' => 2]);
        UsersToAccessLevel::create(['userId' => 3, 'AccessLevelID' => 3]);
    }
}