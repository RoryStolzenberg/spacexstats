<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Tag;

class TagsTableSeeder extends Seeder {
    public function run() {
        Tag::create(array('name' => 'elon-musk'));
        Tag::create(array('name' => 'gwynne-shotwell'));
        Tag::create(array('name' => 'commercial-resupply-services'));
        Tag::create(array('name' => 'falcon-9'));
        Tag::create(array('name' => 'falcon-5'));
        Tag::create(array('name' => 'spacex'));
        Tag::create(array('name' => 'cape-kennedy'));
        Tag::create(array('name' => 'seattle'));
        Tag::create(array('name' => 'hawthorne'));
        Tag::create(array('name' => 'SLC-40'));
        Tag::create(array('name' => 'reusability'));
    }
}