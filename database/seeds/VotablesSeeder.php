<?php

use Illuminate\Database\Seeder;
use App\Question;
use App\User;

class VotablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('votables')->where('votable_type', 'App\Question')->delete();

        $users = User::all(); 
        $numberOfUsers = $users->count();
        $votes = [-1, 0, 1];

        foreach (Question::all() as $question){
            for ($i = 0; $i < rand(0, $numberOfUsers); $i++) {
                $user = $users[$i];
                $user->voteQuestion($question, $votes[rand(0, 2)]);
            }
        }
    }
}
