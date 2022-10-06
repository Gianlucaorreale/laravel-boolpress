<?php
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Faker\Generator;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $labels = ['FrontEnd', 'BackEnd', 'UI/UX', 'DevOps','FullStack'];
        foreach($labels as $label){
            $tag = new Tag();
            $tag->label = $label;
            $tag->color = $faker->hexcolor();
            $tag->save();
        }
    }
}
